<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\RiskUpdateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rutas públicas para autocompletado y búsquedas
Route::prefix('v1')->group(function () {
    
    // Rutas de empresas
    Route::prefix('companies')->group(function () {
        Route::get('/ruc/{ruc}', [CompanyController::class, 'getByRuc'])
            ->name('api.companies.get-by-ruc')
            ->where('ruc', '[0-9]{8,11}');
            
        Route::get('/suggestions', [CompanyController::class, 'getSuggestions'])
            ->name('api.companies.suggestions');
            
        Route::get('/search', [CompanyController::class, 'searchByRazonSocial'])
            ->name('api.companies.search');
            
        Route::get('/validate-ruc/{ruc}', [CompanyController::class, 'validateRuc'])
            ->name('api.companies.validate-ruc')
            ->where('ruc', '[0-9]{8,11}');
            
        Route::get('/stats/{ruc}', [CompanyController::class, 'getStats'])
            ->name('api.companies.stats')
            ->where('ruc', '[0-9]{11}');
            
        Route::post('/', [CompanyController::class, 'store'])
            ->name('api.companies.store');
    });
    
    // Rutas de ubicaciones geográficas
    Route::prefix('locations')->group(function () {
        // Manejar preflight CORS OPTIONS requests
        Route::options('/{any}', function () {
            return response('', 200)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        })->where('any', '.*');
        
        // Departamentos
        Route::get('/departamentos', [LocationController::class, 'getDepartamentos'])
            ->name('api.locations.departamentos');
            
        Route::get('/departamentos/search', [LocationController::class, 'searchDepartamentos'])
            ->name('api.locations.departamentos.search');
            
        Route::get('/departamentos/{id}', [LocationController::class, 'getDepartamento'])
            ->name('api.locations.departamento')
            ->where('id', '[0-9]+');
        
        // Provincias
        Route::get('/provincias/departamento/{departamentoId}', [LocationController::class, 'getProvinciasByDepartamento'])
            ->name('api.locations.provincias-by-departamento')
            ->where('departamentoId', '[0-9]+');
            
        Route::get('/provincias/search', [LocationController::class, 'searchProvincias'])
            ->name('api.locations.provincias.search');
            
        Route::get('/provincias/{id}', [LocationController::class, 'getProvincia'])
            ->name('api.locations.provincia')
            ->where('id', '[0-9]+');
        
        // Utilidades
        Route::get('/stats', [LocationController::class, 'getLocationStats'])
            ->name('api.locations.stats');
            
        Route::get('/validate-ubigeo/{ubigeo}', [LocationController::class, 'validateUbigeo'])
            ->name('api.locations.validate-ubigeo')
            ->where('ubigeo', '[0-9]{6}');
    });
    
    // Rutas de actualización del sistema de riesgo
    Route::prefix('risk')->group(function () {
        Route::post('/update-by-time', [RiskUpdateController::class, 'updateByTime'])
            ->name('api.risk.update-by-time');
            
        Route::post('/update-by-excel', [RiskUpdateController::class, 'updateByExcel'])
            ->name('api.risk.update-by-excel');
            
        Route::get('/status', [RiskUpdateController::class, 'getStatus'])
            ->name('api.risk.status');
            
        Route::post('/force-update', [RiskUpdateController::class, 'forceUpdate'])
            ->name('api.risk.force-update');
    });
});

// Rutas con middleware de autenticación (para futuras funcionalidades)
Route::middleware(['auth:sanctum'])->prefix('v1/authenticated')->group(function () {
    // Aquí se pueden agregar rutas que requieran autenticación
    // Por ejemplo: gestión de empresas del usuario, etc.
});
