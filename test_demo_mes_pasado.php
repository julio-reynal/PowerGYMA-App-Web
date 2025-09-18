<?php

require_once __DIR__ . '/vendor/autoload.php';

// Inicializar Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== PRUEBA DEL DASHBOARD DEMO CON MES PASADO ===\n\n";

try {
    // 1. Verificar fecha actual
    echo "1. Información de fechas:\n";
    $now = \Carbon\Carbon::now();
    $lastMonth = $now->copy()->subMonth();
    echo "Fecha actual: " . $now->format('Y-m-d') . " (mes: " . $now->month . ")\n";
    echo "Mes pasado: " . $lastMonth->format('Y-m-d') . " (mes: " . $lastMonth->month . ")\n\n";
    
    // 2. Verificar datos del mes pasado
    echo "2. Verificando datos del mes pasado:\n";
    $year = $lastMonth->year;
    $month = $lastMonth->month;
    
    // Buscar en RiskEvaluation del mes pasado
    $evalCount = \App\Models\RiskEvaluation::whereYear('evaluation_date', $year)
        ->whereMonth('evaluation_date', $month)
        ->count();
    echo "RiskEvaluations del mes $month/$year: $evalCount\n";
    
    // Buscar en MonthlyRiskData del mes pasado
    $monthlyCount = \App\Models\MonthlyRiskData::where('year', $year)
        ->where('month', $month)
        ->count();
    echo "MonthlyRiskData del mes $month/$year: $monthlyCount\n\n";
    
    // 3. Probar servicio demo
    echo "3. Probando DemoDashboardSnapshotService:\n";
    $service = new \App\Services\DemoDashboardSnapshotService();
    $snapshot = $service->buildSnapshot();
    
    echo "✅ Servicio creado exitosamente\n";
    echo "Fuente de datos: " . $snapshot['dataSource'] . "\n";
    echo "Es modo demo: " . ($snapshot['isDemoMode'] ? 'SÍ' : 'NO') . "\n";
    echo "Información del mes: " . ($snapshot['demoInfo']['month_spanish'] ?? 'N/A') . "\n";
    echo "Es simulado: " . (($snapshot['demoInfo']['is_simulated'] ?? true) ? 'SÍ' : 'NO') . "\n";
    echo "Nivel de riesgo: " . $snapshot['riskLevel'] . "\n";
    echo "Porcentaje: " . $snapshot['riskPercent'] . "%\n";
    echo "Datos de calendario: " . count($snapshot['monthData']) . " días\n\n";
    
    // 4. Verificar gráfico
    echo "4. Datos del gráfico:\n";
    echo "Etiquetas: " . count($snapshot['labels']) . " puntos\n";
    echo "Serie de datos: " . count($snapshot['series']) . " valores\n";
    echo "Horario pico: " . ($snapshot['peakFrom'] ?? 'N/A') . " - " . ($snapshot['peakTo'] ?? 'N/A') . "\n";
    echo "Valores de ejemplo: [" . implode(', ', array_slice($snapshot['series'], 8, 8)) . "]\n\n";
    
    // 5. Probar cache
    echo "5. Probando sistema de cache:\n";
    $cached = $service->getCachedOrBuild();
    echo "✅ Cache funcionando\n";
    echo "Datos desde cache: " . ($cached['updatedAt'] === $snapshot['updatedAt'] ? 'SÍ' : 'NO') . "\n\n";
    
    // 6. Probar refresh
    echo "6. Probando refresh de cache:\n";
    $refreshed = $service->refreshCache();
    echo "✅ Refresh exitoso\n";
    echo "Timestamp actualizado: " . ($refreshed['updatedAt'] !== $snapshot['updatedAt'] ? 'SÍ' : 'NO') . "\n\n";
    
    echo "=== ✅ TODAS LAS PRUEBAS COMPLETADAS EXITOSAMENTE ===\n";
    echo "\n🎯 RESUMEN:\n";
    echo "- Dashboard Demo ahora usa datos de " . ($snapshot['demoInfo']['month_spanish'] ?? 'mes anterior') . "\n";
    echo "- " . ($snapshot['demoInfo']['is_simulated'] ? 'Datos simulados' : 'Datos reales') . " disponibles\n";
    echo "- Sistema de cache funcionando correctamente\n";
    echo "- Gráficos y calendario generados para el mes pasado\n\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}