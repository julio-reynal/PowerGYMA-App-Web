<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ExcelUpload;
use App\Models\MonthlyRiskData;
use App\Services\ExcelProcessorService;
use App\Services\RiskCalculationService;

echo "=== REPROCESANDO EXCEL Y ACTUALIZANDO PROGRESO ===\n";

// Obtener el Excel más reciente
$latestExcel = ExcelUpload::orderBy('created_at', 'desc')->first();

if (!$latestExcel) {
    echo "❌ No se encontró ningún Excel\n";
    exit(1);
}

echo "📄 Excel encontrado: {$latestExcel->original_name} (ID: {$latestExcel->id})\n";
echo "📅 Fecha: {$latestExcel->created_at}\n";
echo "🔄 Estado: {$latestExcel->status}\n";

// Verificar si el archivo existe
if (!file_exists($latestExcel->file_path)) {
    echo "❌ El archivo físico no existe: {$latestExcel->file_path}\n";
    exit(1);
}

echo "📁 Archivo físico encontrado: {$latestExcel->file_path}\n";

try {
    echo "\n🔄 Reprocesando archivo Excel...\n";
    
    $excelProcessor = app(ExcelProcessorService::class);
    $riskService = app(RiskCalculationService::class);
    
    // Reprocesar el archivo Excel
    $result = $excelProcessor->processExcelFile($latestExcel->file_path, $latestExcel->id, 2025);
    
    if ($result['success']) {
        echo "✅ Excel reprocesado exitosamente\n";
        
        // Actualizar el sistema de riesgo con los datos del Excel
        echo "🔄 Actualizando sistema de riesgo...\n";
        $riskService->updateRiskByExcelData($latestExcel->id);
        
        echo "✅ Sistema de riesgo actualizado\n";
        
        // Verificar el progreso actual
        echo "\n=== VERIFICANDO PROGRESO ACTUALIZADO ===\n";
        
        $monthlyComplete = MonthlyRiskData::where('year', now()->year)
            ->where('month', now()->month)
            ->where('status', 'evaluado')
            ->count();

        $monthlyTotal = MonthlyRiskData::where('year', now()->year)
            ->where('month', now()->month)
            ->count();

        $progressPercent = $monthlyTotal > 0 ? round(($monthlyComplete / $monthlyTotal) * 100) : 0;

        echo "Año: " . now()->year . "\n";
        echo "Mes: " . now()->month . "\n";
        echo "Días evaluados: {$monthlyComplete}\n";
        echo "Total días: {$monthlyTotal}\n";
        echo "Progreso: {$progressPercent}%\n";
        
        echo "\n✅ Proceso completado. El progreso del mes debe estar actualizado.\n";
        echo "🔄 Actualiza la página del dashboard para ver los cambios.\n";
        
    } else {
        echo "❌ Error al reprocesar Excel: " . $result['message'] . "\n";
        exit(1);
    }
    
} catch (\Exception $e) {
    echo "❌ Error durante el proceso: " . $e->getMessage() . "\n";
    exit(1);
}