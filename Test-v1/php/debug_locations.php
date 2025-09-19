<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Departamento;
use App\Models\Provincia;

echo "🔍 DEBUGEANDO SELECTORES DE UBICACIÓN\n";
echo "=====================================\n\n";

// Verificar total de departamentos y provincias
$totalDepartamentos = Departamento::count();
$totalProvincias = Provincia::count();

echo "📊 Totales:\n";
echo "- Departamentos: {$totalDepartamentos}\n";
echo "- Provincias: {$totalProvincias}\n\n";

// Verificar departamentos específicos
$departamentos = ['Ayacucho', 'Lima', 'Cusco', 'Arequipa'];

foreach ($departamentos as $deptNombre) {
    echo "🏙️ Verificando {$deptNombre}:\n";
    
    $dept = Departamento::where('nombre', $deptNombre)->first();
    
    if ($dept) {
        $provincias = $dept->provincias;
        echo "  ✅ Encontrado - ID: {$dept->id}\n";
        echo "  📍 Provincias: {$provincias->count()}\n";
        
        if ($provincias->count() > 0) {
            echo "  📝 Lista de provincias:\n";
            foreach ($provincias->take(5) as $provincia) {
                echo "    - {$provincia->nombre} (ID: {$provincia->id})\n";
            }
            if ($provincias->count() > 5) {
                echo "    ... y " . ($provincias->count() - 5) . " más\n";
            }
        } else {
            echo "  ⚠️ SIN PROVINCIAS ASOCIADAS\n";
        }
    } else {
        echo "  ❌ No encontrado\n";
    }
    echo "\n";
}

// Verificar relaciones en la base de datos
echo "🔗 Verificando relaciones:\n";
$provinciasOrfanas = Provincia::whereDoesntHave('departamento')->count();
echo "- Provincias sin departamento: {$provinciasOrfanas}\n";

$departamentosSinProvincias = Departamento::whereDoesntHave('provincias')->count();
echo "- Departamentos sin provincias: {$departamentosSinProvincias}\n\n";

// Verificar API directamente
echo "🌐 Probando API:\n";
try {
    $locationService = new App\Services\LocationService();
    $departamentos = $locationService->getAllDepartamentos();
    echo "- API getAllDepartamentos(): {$departamentos->count()} departamentos\n";
    
    $ayacucho = $departamentos->firstWhere('nombre', 'Ayacucho');
    if ($ayacucho) {
        echo "- Ayacucho en API: ID {$ayacucho->id}\n";
        
        $provinciasAyacucho = $locationService->getProvinciasByDepartamento($ayacucho->id);
        echo "- Provincias de Ayacucho via API: {$provinciasAyacucho->count()}\n";
    }
} catch (Exception $e) {
    echo "- Error en API: " . $e->getMessage() . "\n";
}

echo "\n✅ Debug completado\n";
