<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ExcelUpload;
use App\Models\MonthlyRiskData;
use Carbon\Carbon;

echo "=== SINCRONIZACIÓN DE DATOS EXCEL CON PROGRESO MENSUAL ===\n";

// Obtener el Excel más reciente
$latestExcel = ExcelUpload::where('status', 'procesado')
    ->orderBy('created_at', 'desc')
    ->first();

if (!$latestExcel) {
    echo "❌ No se encontró ningún Excel procesado\n";
    exit(1);
}

echo "📄 Usando Excel: {$latestExcel->original_name} (ID: {$latestExcel->id})\n";
echo "📅 Fecha de subida: {$latestExcel->created_at}\n";

if (!$latestExcel->processed_data || !isset($latestExcel->processed_data['monthly_data'])) {
    echo "❌ El Excel no tiene datos mensuales procesados\n";
    exit(1);
}

$monthlyData = $latestExcel->processed_data['monthly_data'];
echo "📊 Registros mensuales en Excel: " . count($monthlyData) . "\n\n";

$updatedCount = 0;
$createdCount = 0;

echo "=== PROCESANDO DATOS ===\n";

foreach ($monthlyData as $data) {
    $date = Carbon::parse($data['fecha']);
    
    // Solo procesar datos que tengan un nivel de riesgo válido
    if (empty($data['nivel_riesgo']) || trim($data['nivel_riesgo']) === '') {
        echo "⚠️  Saltando {$data['fecha']} - sin nivel de riesgo\n";
        continue;
    }
    
    $riskLevel = trim($data['nivel_riesgo']);
    
    // Verificar si ya existe
    $existing = MonthlyRiskData::where('year', $date->year)
        ->where('month', $date->month)
        ->where('day', $date->day)
        ->first();
    
    if ($existing) {
        // Solo actualizar si está pendiente o vacío
        if ($existing->status === 'pendiente' || empty($existing->risk_level)) {
            $existing->update([
                'risk_level' => $riskLevel,
                'status' => 'evaluado',
                'updated_at' => now()
            ]);
            echo "✅ Actualizado día {$date->day}: {$riskLevel}\n";
            $updatedCount++;
        } else {
            echo "ℹ️  Día {$date->day} ya evaluado: {$existing->risk_level}\n";
        }
    } else {
        // Crear nuevo registro
        MonthlyRiskData::create([
            'year' => $date->year,
            'month' => $date->month,
            'day' => $date->day,
            'risk_level' => $riskLevel,
            'status' => 'evaluado',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        echo "🆕 Creado día {$date->day}: {$riskLevel}\n";
        $createdCount++;
    }
}

echo "\n=== RESULTADO ===\n";
echo "Registros actualizados: {$updatedCount}\n";
echo "Registros creados: {$createdCount}\n";

// Verificar el nuevo estado
$september2025 = MonthlyRiskData::where('year', 2025)
    ->where('month', 9)
    ->get();

$evaluatedCount = $september2025->where('status', 'evaluado')->count();
$totalCount = $september2025->count();
$newProgress = $totalCount > 0 ? round(($evaluatedCount / $totalCount) * 100) : 0;

echo "\n=== PROGRESO ACTUALIZADO ===\n";
echo "Días evaluados: {$evaluatedCount}\n";
echo "Total días: {$totalCount}\n";
echo "Nuevo progreso: {$newProgress}%\n";

echo "\n✅ Sincronización completada. Actualiza la página del dashboard para ver los cambios.\n";