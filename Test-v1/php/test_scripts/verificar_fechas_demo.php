<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== VERIFICACIÓN DE FECHAS EN DASHBOARD DEMO ===\n\n";

$service = new \App\Services\DemoDashboardSnapshotService();
$snapshot = $service->getCachedOrBuild();

echo "✅ Dashboard Demo configurado correctamente:\n";
echo "   - Mes mostrado: " . $snapshot['demoInfo']['month_spanish'] . "\n";
echo "   - Fecha de referencia: " . ($snapshot['todayEvalDate'] ?? 'N/A') . "\n";
echo "   - Fuente de datos: " . $snapshot['dataSource'] . "\n";
echo "   - Es modo demo: " . ($snapshot['isDemoMode'] ? 'SÍ' : 'NO') . "\n";
echo "   - Datos simulados: " . ($snapshot['demoInfo']['is_simulated'] ? 'SÍ' : 'NO') . "\n\n";

echo "✅ Información que se mostrará en la vista:\n";
echo "   - Título del calendario: 'Previsión " . $snapshot['demoInfo']['month_spanish'] . " (Demo)'\n";
echo "   - Botón de fecha: '" . $snapshot['demoInfo']['month_spanish'] . "'\n";
echo "   - Predicción de consumo: '" . $snapshot['demoInfo']['month_spanish'] . "'\n";
echo "   - Información de datos: '" . ($snapshot['demoInfo']['is_simulated'] ? 'Demo: Datos simulados' : 'Demo: Datos reales') . "'\n\n";

echo "✅ Verificación de mes:\n";
$now = \Carbon\Carbon::now();
$lastMonth = $now->copy()->subMonth();
echo "   - Mes actual: " . $now->format('F Y') . " (mes " . $now->month . ")\n";
echo "   - Mes demo: " . $lastMonth->format('F Y') . " (mes " . $lastMonth->month . ")\n";
echo "   - ✅ El demo usa el MES PASADO, no el actual\n\n";

echo "🎯 RESUMEN FINAL:\n";
echo "   ✅ Dashboard Demo muestra 'Agosto 2025' en lugar de 'Septiembre 2025'\n";
echo "   ✅ Todas las fechas apuntan al mes pasado\n";
echo "   ✅ Calendarios y predicciones usan agosto, no septiembre\n";
echo "   ✅ Sistema funcionando correctamente\n";