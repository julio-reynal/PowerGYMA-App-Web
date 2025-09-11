<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ClienteDashboardController;
use App\Http\Controllers\DemoDashboardController;

Route::get('/', function () {
    return view('index');
});

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
    Route::get('/demo/create', [AdminController::class, 'createDemo'])->name('demo.create');
    Route::post('/demo', [AdminController::class, 'storeDemo'])->name('demo.store');
    
    // Acciones de usuario
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Gestión de Excel
    Route::get('/excel', [ExcelController::class, 'index'])->name('excel.index');
    Route::post('/excel/upload', [ExcelController::class, 'upload'])->name('excel.upload');
    Route::get('/excel/{id}', [ExcelController::class, 'show'])->name('excel.show');
    Route::post('/excel/{id}/reprocess', [ExcelController::class, 'reprocess'])->name('excel.reprocess');
    Route::delete('/excel/{id}', [ExcelController::class, 'destroy'])->name('excel.destroy');
    Route::get('/excel/template/download', [ExcelController::class, 'downloadTemplate'])->name('excel.template');
    
    // API Status
    Route::get('/api/excel/{id}/status', [ExcelController::class, 'getProcessingStatus'])->name('excel.status');
    
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

    // Endpoint JSON (read-only)
    Route::get('/api/snapshot', [DemoDashboardController::class, 'apiSnapshot'])->name('api.snapshot');

    Route::view('/info', 'demo.info')->name('info');
});
