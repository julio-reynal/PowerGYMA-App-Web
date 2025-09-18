<?php

namespace App\Http\Controllers;

use App\Models\DemoRequest;
use App\Models\Departamento;
use App\Models\Provincia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class DemoRequestController extends Controller
{
    /**
     * Mostrar el formulario de solicitud de demo
     */
    public function create()
    {
        $departamentos = Departamento::orderBy('nombre')->get();
        $provincias = Provincia::orderBy('nombre')->get();
        
        return view('demo.solicitar', compact('departamentos', 'provincias'));
    }

    /**
     * Procesar la solicitud de demo
     */
    public function store(Request $request)
    {
        try {
            // Validación
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:demo_requests,email',
                'telefono' => 'nullable|string|max:20',
                'telefono_celular' => 'nullable|string|max:20',
                'tipo_documento' => 'required|in:DNI,CE,Pasaporte,RUC',
                'numero_documento' => 'nullable|string|max:20',
                'empresa' => 'required|string|max:255',
                'ruc_empresa' => 'nullable|string|max:11',
                'giro_empresa' => 'nullable|string|max:255',
                'cargo_puesto' => 'nullable|string|max:255',
                'direccion' => 'nullable|string|max:500',
                'ciudad' => 'nullable|string|max:100',
                'departamento_id' => 'nullable|exists:departamentos,id',
                'provincia_id' => 'nullable|exists:provincias,id',
                'tipo_demo' => 'required|in:evaluacion,prueba_gratis,consultoria,otro',
                'comentarios' => 'nullable|string|max:1000',
                'necesidades_especificas' => 'nullable|string|max:1000',
                'acepta_terminos' => 'required|boolean|accepted',
                'acepta_marketing' => 'nullable|boolean',
            ]);

            // Crear la solicitud
            $demoRequest = DemoRequest::create($validated);

            // Log para auditoría
            Log::info('Nueva solicitud de demo registrada', [
                'id' => $demoRequest->id,
                'email' => $demoRequest->email,
                'empresa' => $demoRequest->empresa,
                'ip' => $request->ip(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Solicitud de demo registrada exitosamente',
                    'id' => $demoRequest->id,
                ]);
            }

            return redirect()->route('demo.gracias')
                ->with('success', 'Su solicitud de demo ha sido registrada exitosamente. Nos pondremos en contacto con usted pronto.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors(),
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            Log::error('Error al procesar solicitud de demo', [
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
                'data' => $request->all(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error interno del servidor. Por favor, intente nuevamente.',
                ], 500);
            }

            return back()->with('error', 'Ocurrió un error al procesar su solicitud. Por favor, intente nuevamente.')
                ->withInput();
        }
    }

    /**
     * Página de agradecimiento después del registro
     */
    public function gracias()
    {
        return view('demo.gracias');
    }

    /**
     * Panel de administración - listar solicitudes
     */
    public function index(Request $request)
    {
        $query = DemoRequest::with(['departamento', 'provincia'])
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo_demo')) {
            $query->where('tipo_demo', $request->tipo_demo);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('empresa', 'like', "%{$search}%")
                  ->orWhere('ruc_empresa', 'like', "%{$search}%");
            });
        }

        $solicitudes = $query->paginate(20);

        // Estadísticas para el dashboard
        $estadisticas = [
            'total' => DemoRequest::count(),
            'pendientes' => DemoRequest::where('estado', 'pendiente')->count(),
            'contactados' => DemoRequest::where('estado', 'contactado')->count(),
            'programados' => DemoRequest::where('estado', 'programado')->count(),
            'completados' => DemoRequest::where('estado', 'completado')->count(),
            'recientes' => DemoRequest::recientes()->count(),
        ];

        return view('admin.demo-requests.index', compact('solicitudes', 'estadisticas'));
    }

    /**
     * Ver detalles de una solicitud específica
     */
    public function show(DemoRequest $demoRequest)
    {
        $demoRequest->load(['departamento', 'provincia']);
        return view('admin.demo-requests.show', compact('demoRequest'));
    }

    /**
     * Actualizar una solicitud de demo
     */
    public function update(Request $request, DemoRequest $demoRequest)
    {
        try {
            // Validación de los datos
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:demo_requests,email,' . $demoRequest->id,
                'telefono' => 'nullable|string|max:20',
                'telefono_celular' => 'nullable|string|max:20',
                'empresa' => 'required|string|max:255',
                'ruc_empresa' => 'nullable|string|max:11',
                'giro_empresa' => 'nullable|string|max:255',
                'cargo_puesto' => 'nullable|string|max:255',
                'direccion' => 'nullable|string|max:500',
                'ciudad' => 'nullable|string|max:100',
                'departamento_id' => 'nullable|exists:departamentos,id',
                'provincia_id' => 'nullable|exists:provincias,id',
                'tipo_demo' => 'required|in:evaluacion,prueba_gratis,consultoria,otro',
                'comentarios' => 'nullable|string|max:1000',
                'necesidades_especificas' => 'nullable|string|max:1000',
                'estado' => 'required|in:pendiente,contactado,programado,completado,rechazado',
                'notas_internas' => 'nullable|string|max:1000',
                'fecha_demo_programada' => 'nullable|date|after:now',
            ]);

            DB::beginTransaction();

            // Actualizar la solicitud
            $demoRequest->update($validated);

            // Si se marca como contactado, registrar fecha
            if ($validated['estado'] === 'contactado' && !$demoRequest->fecha_contacto) {
                $demoRequest->fecha_contacto = now();
                $demoRequest->save();
            }

            DB::commit();

            Log::info('Solicitud de demo actualizada', [
                'id' => $demoRequest->id,
                'admin' => auth()->user()->email,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Solicitud actualizada exitosamente',
                ]);
            }

            return back()->with('success', 'Solicitud actualizada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar solicitud de demo', [
                'id' => $demoRequest->id,
                'error' => $e->getMessage(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la solicitud',
                ], 500);
            }

            return back()->with('error', 'Error al actualizar la solicitud');
        }
    }

    /**
     * Actualizar el estado de una solicitud
     */
    public function updateEstado(Request $request, DemoRequest $demoRequest)
    {
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,contactado,programado,completado,rechazado',
            'notas_internas' => 'nullable|string|max:1000',
            'fecha_demo_programada' => 'nullable|date|after:now',
        ]);

        try {
            DB::beginTransaction();

            $demoRequest->estado = $validated['estado'];
            
            if (isset($validated['notas_internas'])) {
                $demoRequest->notas_internas = $validated['notas_internas'];
            }

            // Si se marca como contactado, registrar fecha
            if ($validated['estado'] === 'contactado' && !$demoRequest->fecha_contacto) {
                $demoRequest->fecha_contacto = now();
            }

            // Si se programa demo, registrar fecha
            if ($validated['estado'] === 'programado' && isset($validated['fecha_demo_programada'])) {
                $demoRequest->fecha_demo_programada = $validated['fecha_demo_programada'];
            }

            $demoRequest->save();

            DB::commit();

            Log::info('Estado de solicitud de demo actualizado', [
                'id' => $demoRequest->id,
                'nuevo_estado' => $validated['estado'],
                'admin' => auth()->user()->email,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Estado actualizado exitosamente',
                    'nuevo_estado' => $demoRequest->estado_label,
                ]);
            }

            return back()->with('success', 'Estado de la solicitud actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar estado de solicitud', [
                'id' => $demoRequest->id,
                'error' => $e->getMessage(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el estado',
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el estado de la solicitud');
        }
    }

    /**
     * Eliminar una solicitud
     */
    public function destroy(DemoRequest $demoRequest)
    {
        try {
            $email = $demoRequest->email;
            $demoRequest->delete();

            Log::info('Solicitud de demo eliminada', [
                'email' => $email,
                'admin' => auth()->user()->email,
            ]);

            return back()->with('success', 'Solicitud eliminada exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar solicitud de demo', [
                'id' => $demoRequest->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Error al eliminar la solicitud');
        }
    }

    /**
     * API: Obtener provincias por departamento
     */
    public function getProvinciasByDepartamento($departamentoId)
    {
        $provincias = Provincia::where('departamento_id', $departamentoId)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return response()->json($provincias);
    }

    /**
     * API: Verificar disponibilidad de email
     */
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $isAvailable = DemoRequest::isEmailUnique($request->email);

        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable ? 
                'Email disponible' : 
                'Ya existe una solicitud con este email',
        ]);
    }

    /**
     * Exportar solicitudes a CSV
     */
    public function exportarCSV(Request $request)
    {
        $query = DemoRequest::with(['departamento', 'provincia']);

        // Aplicar mismos filtros que en index
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo_demo')) {
            $query->where('tipo_demo', $request->tipo_demo);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('empresa', 'like', "%{$search}%");
            });
        }

        $solicitudes = $query->get();

        $filename = 'solicitudes_demo_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($solicitudes) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fwrite($file, "\xEF\xBB\xBF");
            
            // Encabezados
            fputcsv($file, [
                'ID', 'Fecha Solicitud', 'Nombre', 'Email', 'Teléfono', 
                'Documento', 'Empresa', 'RUC', 'Cargo', 'Tipo Demo', 
                'Estado', 'Departamento', 'Provincia', 'Comentarios'
            ]);
            
            // Datos
            foreach ($solicitudes as $solicitud) {
                fputcsv($file, [
                    $solicitud->id,
                    $solicitud->created_at->format('d/m/Y H:i'),
                    $solicitud->nombre,
                    $solicitud->email,
                    $solicitud->telefono_celular ?: $solicitud->telefono,
                    $solicitud->tipo_documento . ': ' . $solicitud->numero_documento,
                    $solicitud->empresa,
                    $solicitud->ruc_empresa,
                    $solicitud->cargo_puesto,
                    $solicitud->tipo_demo_label,
                    $solicitud->estado_label,
                    $solicitud->departamento?->nombre,
                    $solicitud->provincia?->nombre,
                    $solicitud->comentarios,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
