<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExcelProcessorService;
use App\Services\DashboardSnapshotService;
use App\Models\ExcelUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ExcelController extends Controller
{
    protected $excelProcessor;
    protected DashboardSnapshotService $snapshotService;

    public function __construct(ExcelProcessorService $excelProcessor, DashboardSnapshotService $snapshotService)
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
        $this->excelProcessor = $excelProcessor;
        $this->snapshotService = $snapshotService;
    }

    /**
     * Mostrar la página de gestión de Excel
     */
    public function index()
    {
        $uploads = ExcelUpload::with('adminUser')
                             ->latest()
                             ->paginate(10);

        return view('admin.excel.index', compact('uploads'));
    }

    /**
     * Subir y procesar archivo Excel
     */
    public function upload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:csv,txt|max:10240', // Solo CSV por ahora
            'csv_year'   => 'required|integer|min:2000|max:2100',
        ], [
            'excel_file.required' => 'Debe seleccionar un archivo CSV.',
            'excel_file.mimes' => 'Actualmente solo se aceptan archivos CSV (.csv).',
            'excel_file.max' => 'El archivo no puede ser mayor a 10MB.',
            'csv_year.required' => 'Debe seleccionar el año de los datos.',
            'csv_year.integer' => 'El año debe ser un número válido.',
            'csv_year.min' => 'El año mínimo permitido es 2000.',
            'csv_year.max' => 'El año máximo permitido es 2100.',
        ]);

        try {
            // Guardar archivo primero y luego crear el registro para evitar errores de NOT NULL
            $file = $request->file('excel_file');
            $fileName = 'risk_data_' . time() . '.csv';

            // Usar Laravel Storage para manejar el archivo
            $fileContent = file_get_contents($file->getRealPath());
            $storagePath = 'excel_uploads/' . $fileName;
            // Asegurar que el directorio exista
            if (!Storage::disk('local')->exists('excel_uploads')) {
                Storage::disk('local')->makeDirectory('excel_uploads');
            }

            // Guardar usando Storage facade
            Storage::disk('local')->put($storagePath, $fileContent);

            // Construir ruta completa
            $fullPath = Storage::disk('local')->path($storagePath);

            // Crear registro de upload incluyendo file_path (columna NOT NULL)
            $excelUpload = ExcelUpload::create([
                'admin_user_id' => Auth::id(),
                'filename' => $fileName,
                'original_filename' => $file->getClientOriginalName(),
                'file_path' => $fullPath,
                'file_size' => $file->getSize(),
                'status' => 'processing',
                'processing_summary' => [
                    'csv_year' => (int) $request->input('csv_year'),
                ],
            ]);
            
            // Verificar que el archivo se guardó correctamente
            if (!Storage::disk('local')->exists($storagePath)) {
                throw new \Exception('El archivo no se guardó correctamente usando Storage');
            }
            
            // Log para debug
            Log::info('Archivo guardado exitosamente usando Storage', [
                'fileName' => $fileName,
                'storagePath' => $storagePath,
                'fullPath' => $fullPath,
                'fileExists' => file_exists($fullPath)
            ]);

            // Procesar archivo con el ID del registro ExcelUpload y el año seleccionado
            $result = $this->excelProcessor->processExcelFile($fullPath, $excelUpload->id, (int) $request->input('csv_year'));

            if ($result['success']) {
                // Marcar actualización pendiente: el dashboard cliente se actualizará solo cuando el usuario haga clic en "Actualizar información"
                Cache::forever('cliente_dashboard_pending_update', now()->toIso8601String());
                return redirect()->route('admin.excel.index')
                               ->with('success', $result['message'])
                               ->with('upload_summary', $result['summary']);
            } else {
                return redirect()->route('admin.excel.index')
                               ->with('error', $result['message']);
            }

        } catch (\Exception $e) {
            // Marcar el upload como fallido si existe
            if (isset($excelUpload)) {
                $excelUpload->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage()
                ]);
            }
            
            return redirect()->route('admin.excel.index')
                           ->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Ver detalles de un upload específico
     */
    public function show($id)
    {
        $upload = ExcelUpload::with('adminUser')->findOrFail($id);
        
        return view('admin.excel.show', compact('upload'));
    }

    /**
     * Reprocesar un archivo Excel
     */
    public function reprocess($id)
    {
        $upload = ExcelUpload::findOrFail($id);
        
        if (!file_exists($upload->file_path)) {
            return redirect()->route('admin.excel.index')
                           ->with('error', 'El archivo original ya no existe.');
        }

        try {
            // Determinar el año usado originalmente (si existe en el resumen), sino usar el año actual
            $csvYear = now()->year;
            if (is_array($upload->processing_summary) && isset($upload->processing_summary['csv_year'])) {
                $csvYear = (int) $upload->processing_summary['csv_year'];
            }

            // Pasar el ID del upload para actualizar su estado correctamente con el año seleccionado
            $result = $this->excelProcessor->processExcelFile($upload->file_path, $upload->id, $csvYear);

            if ($result['success']) {
                // Marcar actualización pendiente
                Cache::forever('cliente_dashboard_pending_update', now()->toIso8601String());
                return redirect()->route('admin.excel.index')
                               ->with('success', 'Archivo reprocesado exitosamente.')
                               ->with('upload_summary', $result['summary']);
            } else {
                return redirect()->route('admin.excel.index')
                               ->with('error', $result['message']);
            }

        } catch (\Exception $e) {
            return redirect()->route('admin.excel.index')
                           ->with('error', 'Error al reprocesar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar registro de upload
     */
    public function destroy($id)
    {
        $upload = ExcelUpload::findOrFail($id);
        
        // Eliminar archivo físico si existe
        if (file_exists($upload->file_path)) {
            unlink($upload->file_path);
        }

        $upload->delete();

        return redirect()->route('admin.excel.index')
                       ->with('success', 'Registro de upload eliminado exitosamente.');
    }

    /**
     * Descargar plantilla de ejemplo
     */
    public function downloadTemplate()
    {
        $templatePath = resource_path('templates/plantilla_riesgo_ejemplo.csv');
        
        if (!file_exists($templatePath)) {
            return redirect()->route('admin.excel.index')
                           ->with('error', 'La plantilla no está disponible.');
        }

        return response()->download($templatePath, 'Plantilla_Datos_Riesgo_PowerGYMA.csv');
    }

    /**
     * API: Obtener estado de procesamiento
     */
    public function getProcessingStatus($id)
    {
        $upload = ExcelUpload::findOrFail($id);
        
        return response()->json([
            'status' => $upload->status,
            'records_processed' => $upload->records_processed,
            'summary' => $upload->processing_summary,
            'error_message' => $upload->error_message
        ]);
    }
}
