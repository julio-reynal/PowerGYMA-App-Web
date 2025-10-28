<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VERIFICACIÓN DE DATOS GEOGRÁFICOS ===\n\n";

// Total de departamentos
$totalDepts = \App\Models\Departamento::count();
echo "✅ Total Departamentos: {$totalDepts}\n";

// Total de provincias
$totalProvs = \App\Models\Provincia::count();
echo "✅ Total Provincias: {$totalProvs}\n\n";

// Verificar Madre de Dios
echo "=== MADRE DE DIOS ===\n";
$madreDeDios = \App\Models\Departamento::where('nombre', 'Madre de Dios')->first();

if ($madreDeDios) {
    echo "Departamento: {$madreDeDios->nombre} (ID: {$madreDeDios->id}, Código: {$madreDeDios->codigo})\n";
    
    $provincias = \App\Models\Provincia::where('departamento_id', $madreDeDios->id)->get();
    echo "Total provincias: {$provincias->count()}\n";
    
    foreach ($provincias as $prov) {
        echo "  ✓ {$prov->codigo} - {$prov->nombre}\n";
    }
} else {
    echo "❌ Departamento Madre de Dios NO encontrado\n";
}

echo "\n=== FIN ===\n";
