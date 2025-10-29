<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ClienteDashboardController;
use App\Http\Controllers\DemoDashboardController;
use App\Http\Controllers\DemoRequestController;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('index');
})->name('home');

// Ruta para enviar formulario de contacto
Route::post('/contacto/enviar', [ContactController::class, 'send'])->name('contacto.enviar');

// RUTA TEMPORAL DE DEBUG - ELIMINAR DESPUÉS DE PROBAR
Route::get('/test-email', function () {
    try {
        $config = [
            'MAIL_MAILER' => config('mail.default'),
            'MAIL_HOST' => config('mail.mailers.smtp.host'),
            'MAIL_PORT' => config('mail.mailers.smtp.port'),
            'MAIL_USERNAME' => config('mail.mailers.smtp.username'),
            'MAIL_ENCRYPTION' => config('mail.mailers.smtp.encryption'),
            'MAIL_FROM_ADDRESS' => config('mail.from.address'),
        ];

        \Mail::raw('Email de prueba desde Railway - PowerGYMA', function ($message) {
            $message->to('info@powergyma.com')
                    ->subject('Test desde Railway - ' . now());
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Email enviado correctamente',
            'config' => $config,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'config' => config('mail'),
        ], 500);
    }
});

// Ruta de prueba para el formulario de contacto
Route::get('/test/contacto', function () {
    return view('test-contact-form');
})->name('test.contacto');

// Ruta para servicios
Route::get('/servicios', function () {
    return view('servicios.index');
})->name('servicios');

// Ruta para nosotros
Route::get('/nosotros', function () {
    return view('nosotros.index');
})->name('nosotros');

// Ruta para clientes
Route::get('/clientes', [App\Http\Controllers\ClientesController::class, 'index'])->name('clientes');

// Ruta para contacto
Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

// Ruta de prueba para servicios
Route::get('/servicios-test', function () {
    return view('servicios.test');
})->name('servicios.test');

// Ruta de prueba para verificar assets y rutas
Route::get('/test-routes', function() {
    return view('test-routes');
})->name('test.routes');

// Ruta de verificación para el botón de acceso
Route::get('/verification', function() {
    return view('verification');
})->name('verification');

// Ruta de prueba para verificar datos del dashboard
Route::get('/test-dashboard-data', function() {
    return view('test-dashboard-data');
})->name('test.dashboard.data');

// Ruta para el formulario de registro extendido (demo)
Route::get('/demo/enhanced-registration', function () {
    return view('enhanced-registration-demo');
});

// Ruta para debug de selectores de ubicación
Route::get('/debug/location-selector', function () {
    return view('debug-location-selector');
});

// Ruta para test simple
Route::get('/test/simple', function () {
    return view('test-simple');
});

// Ruta para fix de ubicaciones
Route::get('/fix/locations', function () {
    return view('location-fix');
});

// Ruta para solución final de ubicaciones
Route::get('/solution/locations', function () {
    return view('location-solution');
});

// Rutas temporales para probar upload sin autenticación ni CSRF
Route::withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])->group(function () {
    Route::get('/test-upload', function() {
        return '<form method="POST" action="/test-upload-process" enctype="multipart/form-data">
            <input type="file" name="excel_file" accept=".csv,.xlsx,.xls" required>
            <button type="submit">Subir archivo</button>
        </form>';
    });

    Route::post('/test-upload-process', function(\Illuminate\Http\Request $request) {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240'
        ]);

        try {
            $processor = new \App\Services\ExcelProcessorService();
            $file = $request->file('excel_file');
            $fileName = 'risk_data_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Crear directorio si no existe
            $uploadDir = storage_path('app/excel_uploads');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Ruta completa del archivo
            $fullPath = $uploadDir . '/' . $fileName;
            
            // Mover el archivo directamente
            if (!$file->move($uploadDir, $fileName)) {
                throw new \Exception('No se pudo guardar el archivo');
            }
            
            // Verificar que el archivo existe
            if (!file_exists($fullPath)) {
                throw new \Exception('El archivo no se guardó correctamente en: ' . $fullPath);
            }
            
            // Procesar archivo
            $result = $processor->processExcelFile($fullPath, 1);
            
            return response()->json($result);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    });

    // Ruta para probar directamente con un archivo específico
    Route::get('/test-plantilla', function() {
        try {
            $processor = new \App\Services\ExcelProcessorService();
            $testFile = base_path('plantilla_test.csv');
            
            if (!file_exists($testFile)) {
                return response()->json(['error' => 'Archivo plantilla_test.csv no encontrado en: ' . $testFile]);
            }
            
            $result = $processor->processExcelFile($testFile, 1);
            return response()->json($result);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    });
});

// Autenticación básica
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
// Fallback GET para cerrar sesión (útil si el botón POST falla por entorno)
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout.get');
Route::get('/salir', [LoginController::class, 'logout'])->middleware('auth')->name('logout.es');

// Rutas públicas para solicitud de demo
Route::get('/demo/solicitar', [DemoRequestController::class, 'create'])->name('demo.solicitar');
Route::post('/demo/solicitar', [DemoRequestController::class, 'store'])->name('demo.store');
Route::get('/demo/gracias', [DemoRequestController::class, 'gracias'])->name('demo.gracias');

// API públicas para el formulario de demo
Route::get('/api/demo/provincias/{departamento}', [DemoRequestController::class, 'getProvinciasByDepartamento'])->name('demo.provincias');
Route::post('/api/demo/check-email', [DemoRequestController::class, 'checkEmail'])->name('demo.check-email');

// Dashboard principal (redirige según rol)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Rutas de administración
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestión de usuarios
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    
    // Gestión de usuarios demo
    Route::get('/users/create-demo', [AdminController::class, 'createDemo'])->name('users.create-demo');
    Route::post('/demo', [AdminController::class, 'storeDemo'])->name('demo.store');
    
    // Acciones de usuario
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete')->where('user', '[0-9]+');
    
    // Gestión de solicitudes de demo
    Route::get('/demo-requests', [DemoRequestController::class, 'index'])->name('demo-requests.index');
    Route::get('/demo-requests/{demoRequest}', [DemoRequestController::class, 'show'])->name('demo-requests.show');
    Route::put('/demo-requests/{demoRequest}', [DemoRequestController::class, 'update'])->name('demo-requests.update');
    Route::patch('/demo-requests/{demoRequest}/estado', [DemoRequestController::class, 'updateEstado'])->name('demo-requests.update-estado');
    Route::delete('/demo-requests/{demoRequest}', [DemoRequestController::class, 'destroy'])->name('demo-requests.destroy');
    Route::get('/demo-requests/export/csv', [DemoRequestController::class, 'exportarCSV'])->name('demo-requests.export');
    
    // Gestión de Excel
    Route::get('/excel', [ExcelController::class, 'index'])->name('excel.index');
    Route::post('/excel/upload', [ExcelController::class, 'upload'])->name('excel.upload');
    Route::get('/excel/{id}', [ExcelController::class, 'show'])->name('excel.show');
    Route::post('/excel/{id}/reprocess', [ExcelController::class, 'reprocess'])->name('excel.reprocess');
    Route::delete('/excel/{id}', [ExcelController::class, 'destroy'])->name('excel.destroy');
    Route::get('/excel/template/download', [ExcelController::class, 'downloadTemplate'])->name('excel.template');
    
    // API Status
    Route::get('/api/excel/{id}/status', [ExcelController::class, 'getProcessingStatus'])->name('excel.status');
    
    // Gestión de Excel para Demo (fechas del mes anterior)
    Route::prefix('demo-excel')->name('demo-excel.')->group(function () {
        Route::get('/', [\App\Http\Controllers\DemoExcelController::class, 'index'])->name('index');
        Route::post('/upload', [\App\Http\Controllers\DemoExcelController::class, 'upload'])->name('upload');
        Route::get('/{id}', [\App\Http\Controllers\DemoExcelController::class, 'show'])->name('show');
        Route::post('/{id}/reprocess', [\App\Http\Controllers\DemoExcelController::class, 'reprocess'])->name('reprocess');
        Route::delete('/{id}', [\App\Http\Controllers\DemoExcelController::class, 'destroy'])->name('destroy');
        Route::get('/template/download', [\App\Http\Controllers\DemoExcelController::class, 'downloadTemplate'])->name('download-template');
        Route::get('/refresh/demo', [\App\Http\Controllers\DemoExcelController::class, 'refreshDemo'])->name('refresh');
        
        // API Status para demo
        Route::get('/api/{id}/status', [\App\Http\Controllers\DemoExcelController::class, 'getProcessingStatus'])->name('status');
    });
    
    // Ruta de prueba para debug
    Route::get('/excel/test-processor', function() {
        $processor = new \App\Services\ExcelProcessorService();
        $testFile = storage_path('app/excel_uploads/test_manual.csv');
        
        if (!file_exists($testFile)) {
            return response()->json(['error' => 'Archivo de prueba no existe: ' . $testFile]);
        }
        
        $result = $processor->processExcelFile($testFile, 1);
        return response()->json($result);
    })->name('excel.test');
});

// Rutas para clientes
Route::middleware(['auth', 'role:cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    // Dashboard de cliente (acceso directo)
    Route::get('/dashboard', [ClienteDashboardController::class, 'index'])->name('dashboard');
    // Refrescar información del dashboard manualmente
    Route::post('/dashboard/refresh', [ClienteDashboardController::class, 'refresh'])->name('dashboard.refresh');
    // Exportar imagen PNG del gráfico del dashboard
    Route::post('/dashboard/export/png', [ClienteDashboardController::class, 'exportDashboardPng'])->name('dashboard.export.png');

    // Endpoints JSON (opcional)
    Route::get('/api/snapshot', [ClienteDashboardController::class, 'apiSnapshot'])->name('api.snapshot');
    Route::get('/api/meta', [ClienteDashboardController::class, 'apiMeta'])->name('api.meta');

    // Páginas de cliente (enlaces desde tarjetas)
    Route::view('/instalaciones', 'cliente.instalaciones')->name('instalaciones');
    Route::view('/planes', 'cliente.planes')->name('planes');
    Route::view('/reservas', 'cliente.reservas')->name('reservas');
    Route::view('/entrenamientos', 'cliente.entrenamientos')->name('entrenamientos');

    // Fase 2: Historicos y exportaciones (controlador)
    Route::get('/reportes', [ClienteDashboardController::class, 'reportes'])->name('reportes');
    Route::get('/reportes/{fecha}', [ClienteDashboardController::class, 'show'])
        ->where('fecha', '[0-9]{4}-[0-9]{2}-[0-9]{2}')
        ->name('reportes.show');
    Route::get('/dashboard/export/pdf', [ClienteDashboardController::class, 'exportDashboardPdf'])->name('dashboard.export');
    Route::get('/reportes/{fecha}/csv', [ClienteDashboardController::class, 'exportCsv'])
        ->where('fecha', '[0-9]{4}-[0-9]{2}-[0-9]{2}')
        ->name('reportes.csv');
    // Exportar imagen PNG del gráfico del día
    Route::post('/reportes/{fecha}/png', [ClienteDashboardController::class, 'exportDayPng'])
        ->where('fecha', '[0-9]{4}-[0-9]{2}-[0-9]{2}')
        ->name('reportes.png');
    // Exportar PDF del día con caché
    Route::get('/reportes/{fecha}/pdf', [ClienteDashboardController::class, 'exportDayPdf'])
        ->where('fecha', '[0-9]{4}-[0-9]{2}-[0-9]{2}')
        ->name('reportes.pdf');
});

// Rutas para usuarios demo
Route::middleware(['auth', 'role:demo'])->prefix('demo')->name('demo.')->group(function () {
    // Dashboard de demo (acceso directo)
    Route::get('/dashboard', [DemoDashboardController::class, 'index'])->name('dashboard');

    // Refrescar cache de datos demo del mes pasado
    Route::post('/dashboard/refresh', [DemoDashboardController::class, 'refreshDemoCache'])->name('dashboard.refresh');

    // Endpoint JSON (read-only)
    Route::get('/api/snapshot', [DemoDashboardController::class, 'apiSnapshot'])->name('api.snapshot');

    Route::view('/info', 'demo.info')->name('info');
});

// Rutas para demos (accesibles para todos los usuarios autenticados)
Route::middleware('auth')->group(function () {
    // FASE 4: Autocompletado de ubicaciones
    Route::view('/demo/autocompletado', 'demo.autocompletado')->name('demo.autocompletado');
    
    // FASE 5: Formularios y validaciones
    Route::get('/demo/formularios', [App\Http\Controllers\AdvancedFormController::class, 'showDemo'])->name('demo.formularios');
});

// API Routes para formularios avanzados
Route::middleware('auth')->prefix('api/v1/forms')->name('forms.')->group(function () {
    // Procesar formulario de registro
    Route::post('/registration', [App\Http\Controllers\AdvancedFormController::class, 'processRegistration'])->name('process-registration');
    
    // Validación individual de campos
    Route::post('/validate-field', [App\Http\Controllers\AdvancedFormController::class, 'validateField'])->name('validate-field');
    
    // Validación completa del formulario
    Route::post('/validate-full', [App\Http\Controllers\AdvancedFormController::class, 'validateFullForm'])->name('validate-full');
    
    // Verificaciones de disponibilidad
    Route::post('/check-email', [App\Http\Controllers\AdvancedFormController::class, 'checkEmailAvailability'])->name('check-email');
    Route::post('/check-document', [App\Http\Controllers\AdvancedFormController::class, 'checkDocumentAvailability'])->name('check-document');
    
    // Validación de relaciones de ubicación
    Route::post('/validate-location', [App\Http\Controllers\AdvancedFormController::class, 'validateLocationRelation'])->name('validate-location');
    
    // Sugerencias para autocompletado de campos
    Route::get('/suggestions/{field}', [App\Http\Controllers\AdvancedFormController::class, 'getFieldSuggestions'])->name('field-suggestions');
});
