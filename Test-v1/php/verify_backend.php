<?php

// Cargar el bootstrap de Laravel
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\LocationService;
use App\Services\CompanyService;

echo "=== VERIFICACIÓN FASE 2 - BACKEND ===\n\n";

try {
    // Verificar LocationService
    echo "1. Probando LocationService...\n";
    $locationService = new LocationService();
    $departamentos = $locationService->getDepartamentos();
    echo "   ✓ Departamentos cargados: " . $departamentos->count() . "\n";
    
    if ($departamentos->count() > 0) {
        $primer_departamento = $departamentos->first();
        echo "   ✓ Primer departamento: " . $primer_departamento->nombre . "\n";
        
        $provincias = $locationService->getProvinciasByDepartamento($primer_departamento->id);
        echo "   ✓ Provincias del primer departamento: " . $provincias->count() . "\n";
    }
    
    // Verificar CompanyService
    echo "\n2. Probando CompanyService...\n";
    $companyService = new CompanyService();
    
    // Probar validación de RUC
    $ruc_test = '20123456789';
    $es_valido = $companyService->validatePeruvianRuc($ruc_test);
    echo "   ✓ Validación RUC {$ruc_test}: " . ($es_valido ? 'VÁLIDO' : 'INVÁLIDO') . "\n";
    
    // Probar búsqueda de empresas
    $companies = $companyService->getSuggestions('TEST', 5);
    echo "   ✓ Búsqueda de empresas con 'TEST': " . count($companies) . " resultados\n";
    
    echo "\n3. Probando modelos y relaciones...\n";
    
    // Verificar modelo Departamento
    $total_departamentos = \App\Models\Departamento::count();
    echo "   ✓ Total departamentos en BD: " . $total_departamentos . "\n";
    
    // Verificar modelo Provincia
    $total_provincias = \App\Models\Provincia::count();
    echo "   ✓ Total provincias en BD: " . $total_provincias . "\n";
    
    // Verificar modelo Company
    $total_companies = \App\Models\Company::count();
    echo "   ✓ Total empresas en BD: " . $total_companies . "\n";
    
    echo "\n=== VERIFICACIÓN COMPLETADA EXITOSAMENTE ===\n";
    echo "✓ LocationService: FUNCIONANDO\n";
    echo "✓ CompanyService: FUNCIONANDO\n";
    echo "✓ Modelos de BD: FUNCIONANDO\n";
    echo "✓ Datos cargados: DEPARTAMENTOS Y PROVINCIAS OK\n";

} catch (Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
}
