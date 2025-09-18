<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DemoExcelProcessorService;
use App\Services\DemoDashboardSnapshotService;
use App\Models\ExcelUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DemoExcelController extends Controller
{
    protected $demoExcelProcessor;
    protected DemoDashboardSnapshotService $demoSnapshotService;

    public function __construct(DemoExcelProcessorService $demoExcelProcessor, DemoDashboardSnapshotService $demoSnapshotService)
    {
        $this->middleware('auth');
        $this->middleware('role:admin'); // Solo admins pueden subir archivos de demo
        $this->demoExcelProcessor = $demoExcelProcessor;
        $this->demoSnapshotService = $demoSnapshotService;
    }

    /**
     * Mostrar la página de gestión de Excel para Demo
     */
    public function index()
    {
        $uploads = ExcelUpload::with('adminUser')
                             ->whereJsonContains('processing_summary->demo_mode', true)
                             ->latest()
                             ->paginate(10);

        return view('admin.excel.demo-index', compact('uploads'));
    }

    /**
     * Subir y procesar archivo Excel específicamente para modo demo
     * Las fechas se convertirán automáticamente al mes anterior
     */
    public function upload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:csv,txt|max:10240',
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
            // Guardar archivo primero
            $file = $request->file('excel_file');
            $fileName = 'demo_risk_data_' . time() . '.csv';

            // Usar Laravel Storage para manejar el archivo
            $fileContent = file_get_contents($file->getRealPath());
            $storagePath = 'excel_uploads/demo/' . $fileName;
            
            // Asegurar que el directorio exista
            if (!Storage::disk('local')->exists('excel_uploads/demo')) {
                Storage::disk('local')->makeDirectory('excel_uploads/demo');
            }

            // Guardar usando Storage facade
            Storage::disk('local')->put($storagePath, $fileContent);

            // Construir ruta completa
            $fullPath = Storage::disk('local')->path($storagePath);

            // Crear registro de upload específico para demo
            $excelUpload = ExcelUpload::create([
                'admin_user_id' => Auth::id(),
                'filename' => $fileName,
                'original_filename' => $file->getClientOriginalName(),
                'file_path' => $fullPath,
                'file_size' => $file->getSize(),
                'status' => 'processing',
                'processing_summary' => [
                    'csv_year' => (int) $request->input('csv_year'),
                    'demo_mode' => true,
                    'processing_type' => 'demo_excel_upload',
                    'target_month' => now()->subMonth()->format('Y-m'),
                ],
            ]);
            
            // Verificar que el archivo se guardó correctamente
            if (!Storage::disk('local')->exists($storagePath)) {
                throw new \Exception('El archivo no se guardó correctamente usando Storage');
            }
            
            // Log para debug
            Log::info('Archivo guardado exitosamente para procesamiento DEMO', [
                'fileName' => $fileName,
                'storagePath' => $storagePath,
                'fullPath' => $fullPath,
                'fileExists' => file_exists($fullPath),
                'targetMonth' => now()->subMonth()->format('Y-m')
            ]);

            // Procesar archivo con el servicio especializado para demo
            $result = $this->demoExcelProcessor->processDemoFile($fullPath, $excelUpload->id, (int) $request->input('csv_year'));

            if ($result['success']) {
                // Refrescar caché del dashboard demo para mostrar los nuevos datos
                $this->demoSnapshotService->refreshCache();
                
                // También limpiar cachés relacionados
                Cache::forget('demo_dashboard_snapshot');
                Cache::forget('cliente_dashboard_pending_update');
                
                $successMessage = $result['message'] . ' Los datos han sido procesados y están disponibles en el dashboard de demo con fechas del mes anterior.';
                
                return redirect()->route('admin.demo-excel.index')
                               ->with('success', $successMessage)
                               ->with('upload_summary', $result['summary']);
            } else {
                return redirect()->route('admin.demo-excel.index')
                               ->with('error', $result['message']);
            }

        } catch (\Exception $e) {
            // Marcar el upload como fallido si existe
            if (isset($excelUpload)) {
                $excelUpload->update([
                    'status' => 'failed',
                    'error_message' => 'Error en procesamiento demo: ' . $e->getMessage()
                ]);
            }
            
            Log::error('Error al procesar archivo Excel para demo', [
                'error' => $e->getMessage(),
                'file' => $request->file('excel_file')->getClientOriginalName() ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('admin.demo-excel.index')
                           ->with('error', 'Error al procesar el archivo para demo: ' . $e->getMessage());
        }
    }

    /**
     * Ver detalles de un upload de demo específico
     */
    public function show($id)
    {
        $upload = ExcelUpload::with('adminUser')
                            ->whereJsonContains('processing_summary->demo_mode', true)
                            ->findOrFail($id);
        
        return view('admin.excel.demo-show', compact('upload'));
    }

    /**
     * Reprocesar un archivo Excel de demo
     */
    public function reprocess($id)
    {
        $upload = ExcelUpload::whereJsonContains('processing_summary->demo_mode', true)
                            ->findOrFail($id);
        
        if (!file_exists($upload->file_path)) {
            return redirect()->route('admin.demo-excel.index')
                           ->with('error', 'El archivo original ya no existe.');
        }

        try {
            // Determinar el año usado originalmente
            $csvYear = now()->year;
            if (is_array($upload->processing_summary) && isset($upload->processing_summary['csv_year'])) {
                $csvYear = (int) $upload->processing_summary['csv_year'];
            }

            // Reprocesar con el servicio especializado para demo
            $result = $this->demoExcelProcessor->processDemoFile($upload->file_path, $upload->id, $csvYear);

            if ($result['success']) {
                // Refrescar caché del dashboard demo
                $this->demoSnapshotService->refreshCache();
                Cache::forget('demo_dashboard_snapshot');
                
                return redirect()->route('admin.demo-excel.index')
                               ->with('success', 'Archivo de demo reprocesado exitosamente. Los datos actualizados están disponibles en el dashboard de demo.')
                               ->with('upload_summary', $result['summary']);
            } else {
                return redirect()->route('admin.demo-excel.index')
                               ->with('error', $result['message']);
            }

        } catch (\Exception $e) {
            return redirect()->route('admin.demo-excel.index')
                           ->with('error', 'Error al reprocesar el archivo de demo: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar registro de upload de demo
     */
    public function destroy($id)
    {
        $upload = ExcelUpload::whereJsonContains('processing_summary->demo_mode', true)
                            ->findOrFail($id);
        
        // Eliminar archivo físico si existe
        if (file_exists($upload->file_path)) {
            unlink($upload->file_path);
        }

        $upload->delete();

        // Refrescar caché del demo después de eliminar
        $this->demoSnapshotService->refreshCache();

        return redirect()->route('admin.demo-excel.index')
                       ->with('success', 'Registro de upload de demo eliminado exitosamente.');
    }

    /**
     * Refrescar manualmente los datos del demo
     */
    public function refreshDemo()
    {
        try {
            $snapshot = $this->demoSnapshotService->refreshCache();
            
            return redirect()->back()
                           ->with('success', 'Datos del demo actualizados exitosamente.')
                           ->with('demo_info', [
                               'month' => $snapshot['demoInfo']['month_spanish'] ?? 'N/A',
                               'data_count' => $snapshot['demoInfo']['data_count'] ?? 0,
                               'is_simulated' => $snapshot['demoInfo']['is_simulated'] ?? true
                           ]);
        } catch (\Exception $e) {
            Log::error('Error al refrescar datos del demo: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Error al refrescar los datos del demo: ' . $e->getMessage());
        }
    }

    /**
     * API: Obtener estado de procesamiento específico para demo
     */
    public function getProcessingStatus($id)
    {
        $upload = ExcelUpload::whereJsonContains('processing_summary->demo_mode', true)
                            ->findOrFail($id);
        
        return response()->json([
            'status' => $upload->status,
            'records_processed' => $upload->records_processed,
            'summary' => $upload->processing_summary,
            'error_message' => $upload->error_message,
            'demo_mode' => true,
            'target_month' => $upload->processing_summary['target_month'] ?? null
        ]);
    }

    /**
     * Descargar plantilla de ejemplo específica para demo
     */
    public function downloadTemplate()
    {
        $templatePath = resource_path('templates/plantilla_demo_riesgo_ejemplo.csv');
        
        // Si no existe plantilla específica de demo, usar la general
        if (!file_exists($templatePath)) {
            $templatePath = resource_path('templates/plantilla_riesgo_ejemplo.csv');
        }
        
        if (!file_exists($templatePath)) {
            return redirect()->route('admin.demo-excel.index')
                           ->with('error', 'La plantilla no está disponible.');
        }

        return response()->download($templatePath, 'Plantilla_Demo_Datos_Riesgo_PowerGYMA.csv');
    }
}