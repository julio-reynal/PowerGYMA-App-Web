<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Departamento;
use App\Models\Provincia;

echo "🚨 DEPARTAMENTOS SIN PROVINCIAS:\n";
echo "================================\n\n";

$departamentosSinProvincias = Departamento::whereDoesntHave('provincias')->get(['id', 'nombre']);

foreach ($departamentosSinProvincias as $dept) {
    echo "ID {$dept->id}: {$dept->nombre}\n";
}

echo "\n📊 Total: {$departamentosSinProvincias->count()} departamentos sin provincias\n\n";

echo "🔍 REVISANDO TABLA PROVINCIAS:\n";
echo "==============================\n\n";

// Verificar algunas provincias de Ayacucho
$provinciasAyacucho = Provincia::where('nombre', 'LIKE', '%ayacucho%')
    ->orWhere('nombre', 'LIKE', '%Ayacucho%')
    ->orWhere('nombre', 'LIKE', '%AYACUCHO%')
    ->get(['id', 'nombre', 'departamento_id']);

echo "Provincias con 'Ayacucho' en el nombre:\n";
foreach ($provinciasAyacucho as $prov) {
    echo "ID {$prov->id}: {$prov->nombre} (Dept ID: {$prov->departamento_id})\n";
}

echo "\n🔍 REVISANDO MUESTRA DE PROVINCIAS:\n";
echo "===================================\n\n";

$muestraProvincias = Provincia::with('departamento')->take(10)->get();
foreach ($muestraProvincias as $prov) {
    $deptNombre = $prov->departamento ? $prov->departamento->nombre : 'SIN DEPARTAMENTO';
    echo "Provincia: {$prov->nombre} -> Departamento: {$deptNombre} (ID: {$prov->departamento_id})\n";
}

echo "\n✅ Análisis completado\n";
