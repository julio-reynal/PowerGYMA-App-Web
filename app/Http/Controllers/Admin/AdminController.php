<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DemoRequest;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'new_users_last_week' => User::where('created_at', '>=', now()->subWeek())->count(),
            'clientes_activos' => User::where('role', 'cliente')->where('is_active', true)->count(),
            'clientes_inactivos' => User::where('role', 'cliente')->where('is_active', false)->count(),
            'demos_activos' => User::where('role', 'demo')->where('is_active', true)->where('expires_at', '>', now())->count(),
            'demos_expirados' => User::where('role', 'demo')->where(function ($query) {
                $query->where('is_active', false)
                      ->orWhere('expires_at', '<=', now());
            })->count(),
        ];
        
        // Estadísticas de solicitudes de demo
        $demo_stats = [
            'total' => DemoRequest::count(),
            'pendientes' => DemoRequest::where('estado', 'pendiente')->count(),
            'contactados' => DemoRequest::where('estado', 'contactado')->count(),
            'programados' => DemoRequest::where('estado', 'programado')->count(),
            'completados' => DemoRequest::where('estado', 'completado')->count(),
            'recientes' => DemoRequest::where('created_at', '>=', now()->subDays(7))->count(),
        ];
        
        // Obtener datos de riesgo para estadísticas (verificar si existen los modelos)
        $data_stats = [
            'evaluations_today' => 0,
            'monthly_entries' => 0,
            'high_risk_days' => 0,
            'pending_days' => 0,
            'excel_uploads' => 0,
        ];
        
        // Verificar si existen los modelos de riesgo
        try {
            if (class_exists('App\Models\RiskEvaluation')) {
                $data_stats['evaluations_today'] = \App\Models\RiskEvaluation::whereDate('evaluation_date', today())->count();
                $data_stats['high_risk_days'] = \App\Models\RiskEvaluation::where('risk_level', 'Alto')
                                                                           ->orWhere('risk_level', 'Crítico')
                                                                           ->whereMonth('evaluation_date', now()->month)
                                                                           ->count();
            }
            
            if (class_exists('App\Models\MonthlyRiskData')) {
                $data_stats['monthly_entries'] = \App\Models\MonthlyRiskData::where('year', now()->year)
                                                                              ->where('month', now()->month)
                                                                              ->count();
                $data_stats['pending_days'] = \App\Models\MonthlyRiskData::where('year', now()->year)
                                                                          ->where('month', now()->month)
                                                                          ->where('status', 'pendiente')
                                                                          ->count();
            }
            
            if (class_exists('App\Models\ExcelUpload')) {
                $data_stats['excel_uploads'] = \App\Models\ExcelUpload::whereMonth('created_at', now()->month)->count();
            }
        } catch (\Exception $e) {
            // Silenciar errores si los modelos no existen
        }
        
        $recent_users = User::latest()->take(5)->get();
        
        // Solicitudes de demo recientes (últimas 10)
        $recent_demo_requests = DemoRequest::with(['departamento', 'provincia'])
                                            ->latest()
                                            ->take(10)
                                            ->get();
        
        // Verificar si se ha subido un archivo Excel hoy
        $hasTodayExcel = false;
        if (class_exists('App\Models\ExcelUpload')) {
            $hasTodayExcel = \App\Models\ExcelUpload::whereDate('created_at', today())->exists();
        }

        $currentEval = null;
        if ($hasTodayExcel && class_exists('App\Models\RiskEvaluation')) {
            $currentEval = \App\Models\RiskEvaluation::today();
        }

        return view('admin.dashboard', compact('stats', 'demo_stats', 'data_stats', 'recent_users', 'recent_demo_requests', 'hasTodayExcel', 'currentEval'));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        $departamentos = $this->locationService->getDepartamentos();
        $companies = \App\Models\Company::orderBy('razon_social')->get();
        return view('admin.users.create', compact('departamentos', 'companies'));
    }

    public function createDemo()
    {
        $departamentos = $this->locationService->getDepartamentos();
        $companies = \App\Models\Company::orderBy('razon_social')->get();
        return view('admin.users.create-demo', compact('departamentos', 'companies'));
    }

    public function storeUser(Request $request)
    {
        $request->merge(['tipo_documento' => strtoupper($request->input('tipo_documento'))]);
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'cliente', 'demo'])],
            'expires_at' => 'nullable|date|after:today',
            'tipo_documento' => 'required|in:DNI,RUC,CE,PASAPORTE',
            'numero_documento' => ['required', 'string', 'max:20', Rule::unique('users')->where(function ($query) use ($request) {
                return $query->where('tipo_documento', $request->tipo_documento);
            })],
            'puesto_trabajo' => 'required|string|max:100',
            'telefono_celular' => 'required|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'genero' => 'nullable|in:masculino,femenino,otro',
            'comentarios_adicionales' => 'nullable|string',
            'company_id' => 'nullable|integer|exists:companies,id',
            'ruc_empresa' => 'required|string|regex:/^[0-9]{11}$/',
            'giro_empresa' => 'nullable|string|max:100',
            'razon_social' => 'required|string|max:255',
            'telefono_fijo' => 'nullable|string|max:15',
            'departamento_id' => 'required|integer|exists:departamentos,id',
            'provincia_id' => 'required|integer|exists:provincias,id',
            'distrito' => 'required|string|max:255',
            'direccion_empresa' => 'required|string|max:255',
        ];

        try {
            $validatedData = $request->validate($validationRules);

            // Manually build the array to ensure correct keys
            $company = \App\Models\Company::firstOrCreate(
                ['ruc' => $validatedData['ruc_empresa']],
                [
                    'razon_social' => $validatedData['razon_social'],
                    'telefono_fijo' => $validatedData['telefono_fijo'] ?? null,
                    'departamento_id' => $validatedData['departamento_id'],
                    'provincia_id' => $validatedData['provincia_id'],
                    'direccion_calle' => $validatedData['direccion_empresa'],
                    'activo' => true,
                ]
            );

            $userData = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
                'is_active' => $request->has('is_active'),
                'expires_at' => $validatedData['expires_at'] ?? null,
                'tipo_documento' => $validatedData['tipo_documento'],
                'numero_documento' => $validatedData['numero_documento'],
                'puesto_trabajo' => $validatedData['puesto_trabajo'],
                'telefono_celular' => $validatedData['telefono_celular'],
                'telefono' => $validatedData['telefono_celular'],
                'direccion' => $validatedData['direccion'] ?? null,
                'fecha_nacimiento' => $validatedData['fecha_nacimiento'] ?? null,
                'genero' => $validatedData['genero'] ?? null,
                'comentarios_adicionales' => $validatedData['comentarios_adicionales'] ?? null,
                'company_id' => $company->id,
                'ruc_empresa' => $validatedData['ruc_empresa'],
                'giro_empresa' => $validatedData['giro_empresa'] ?? null,
                'razon_social' => $validatedData['razon_social'],
                'telefono_fijo' => $validatedData['telefono_fijo'] ?? null,
                'departamento_id' => $validatedData['departamento_id'],
                'provincia_id' => $validatedData['provincia_id'],
                'distrito' => $validatedData['distrito'],
                'direccion_empresa' => $validatedData['direccion_empresa'],
                'company_name' => $validatedData['razon_social'],
                'company_cuit' => $validatedData['ruc_empresa'],
                'company_address' => $validatedData['direccion_empresa'],
                'company_phone' => $validatedData['telefono_fijo'] ?? null,
                'company_activity' => $validatedData['giro_empresa'] ?? null,
            ];

            User::create($userData);

            return redirect()->route('admin.users')->with('success', 'Usuario creado exitosamente.');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el usuario: ' . $e->getMessage())->withInput();
        }
    }

    public function storeDemo(Request $request)
    {
        $request->merge(['tipo_documento' => strtoupper($request->input('tipo_documento'))]);
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'expires_at' => 'required|date|after:today',
            'tipo_documento' => 'required|in:DNI,RUC,CE,PASAPORTE',
            'numero_documento' => ['required', 'string', 'max:20', Rule::unique('users')->where(function ($query) use ($request) {
                return $query->where('tipo_documento', $request->tipo_documento);
            })],
            'puesto_trabajo' => 'required|string|max:100',
            'telefono_celular' => 'required|string|max:15',
            'comentarios_adicionales' => 'nullable|string',
            'company_id' => 'nullable|integer|exists:companies,id',
            'ruc_empresa' => 'required|string|regex:/^[0-9]{11}$/',
            'giro_empresa' => 'nullable|string|max:100',
            'razon_social' => 'required|string|max:255',
            'telefono_fijo' => 'nullable|string|max:15',
            'departamento_id' => 'required|integer|exists:departamentos,id',
            'provincia_id' => 'required|integer|exists:provincias,id',
            'distrito' => 'required|string|max:255',
            'direccion_empresa' => 'required|string|max:255',
        ];

        try {
            $validatedData = $request->validate($validationRules);

            // Manually build the array to ensure correct keys
            $company = \App\Models\Company::firstOrCreate(
                ['ruc' => $validatedData['ruc_empresa']],
                [
                    'razon_social' => $validatedData['razon_social'],
                    'telefono_fijo' => $validatedData['telefono_fijo'] ?? null,
                    'departamento_id' => $validatedData['departamento_id'],
                    'provincia_id' => $validatedData['provincia_id'],
                    'direccion_calle' => $validatedData['direccion_empresa'],
                    'activo' => true,
                ]
            );

            $userData = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'demo',
                'is_active' => $request->has('is_active'),
                'expires_at' => $validatedData['expires_at'],
                'tipo_documento' => $validatedData['tipo_documento'],
                'numero_documento' => $validatedData['numero_documento'],
                'puesto_trabajo' => $validatedData['puesto_trabajo'],
                'telefono_celular' => $validatedData['telefono_celular'],
                'telefono' => $validatedData['telefono_celular'],
                'comentarios_adicionales' => $validatedData['comentarios_adicionales'] ?? null,
                'company_id' => $company->id,
                'ruc_empresa' => $validatedData['ruc_empresa'],
                'giro_empresa' => $validatedData['giro_empresa'] ?? null,
                'razon_social' => $validatedData['razon_social'],
                'telefono_fijo' => $validatedData['telefono_fijo'] ?? null,
                'departamento_id' => $validatedData['departamento_id'],
                'provincia_id' => $validatedData['provincia_id'],
                'distrito' => $validatedData['distrito'],
                'direccion_empresa' => $validatedData['direccion_empresa'],
                'company_name' => $validatedData['razon_social'],
                'company_cuit' => $validatedData['ruc_empresa'],
                'company_address' => $validatedData['direccion_empresa'],
                'company_phone' => $validatedData['telefono_fijo'] ?? null,
                'company_activity' => $validatedData['giro_empresa'] ?? null,
            ];

            User::create($userData);

            return redirect()->route('admin.users')->with('success', 'Usuario demo creado exitosamente.');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el usuario demo: ' . $e->getMessage())->withInput();
        }
    }

    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activado' : 'desactivado';
        return redirect()->back()->with('success', "Usuario {$status} exitosamente.");
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }
        $user->delete();
        return redirect()->back()->with('success', 'Usuario eliminado exitosamente.');
    }
}