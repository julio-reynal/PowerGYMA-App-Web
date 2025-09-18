<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\MonthlyRiskData;

echo "=== VERIFICANDO DATOS MENSUALES ===\n";

// Verificar datos para septiembre 2025
$september2025 = MonthlyRiskData::where('year', 2025)
    ->where('month', 9)
    ->orderBy('day')
    ->get();

echo "Registros para septiembre 2025: " . $september2025->count() . "\n";
echo "Registros 'evaluado': " . $september2025->where('status', 'evaluado')->count() . "\n";
echo "Registros 'pendiente': " . $september2025->where('status', 'pendiente')->count() . "\n";
echo "Registros 'no_procede': " . $september2025->where('status', 'no_procede')->count() . "\n\n";

echo "=== DETALLE POR DÍA ===\n";
foreach ($september2025 as $data) {
    echo "Día {$data->day}: {$data->risk_level} (status: {$data->status})\n";
}

// Verificar total de días que deberían existir en septiembre
$totalDaysInSeptember = 30;
echo "\n=== RESUMEN ===\n";
echo "Días que deberían existir en septiembre: {$totalDaysInSeptember}\n";
echo "Días con datos: " . $september2025->count() . "\n";
echo "Progreso calculado: " . round(($september2025->where('status', 'evaluado')->count() / $september2025->count()) * 100) . "%\n";

// Verificar también los datos del mes actual desde la vista
echo "\n=== CÁLCULO DE LA VISTA ===\n";
$monthlyComplete = MonthlyRiskData::where('year', now()->year)
    ->where('month', now()->month)
    ->where('status', 'evaluado')
    ->count();

$monthlyTotal = MonthlyRiskData::where('year', now()->year)
    ->where('month', now()->month)
    ->count();

$progressPercent = $monthlyTotal > 0 ? round(($monthlyComplete / $monthlyTotal) * 100) : 0;

echo "Año actual: " . now()->year . "\n";
echo "Mes actual: " . now()->month . "\n";
echo "Días completados (evaluado): {$monthlyComplete}\n";
echo "Total días registrados: {$monthlyTotal}\n";
echo "Progreso mostrado en vista: {$progressPercent}%\n";