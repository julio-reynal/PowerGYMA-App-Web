<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$service = new \App\Services\DemoDashboardSnapshotService();
$snapshot = $service->getCachedOrBuild();

echo 'DEMO DASHBOARD FUNCIONANDO:' . PHP_EOL;
echo '✅ Mes: ' . $snapshot['demoInfo']['month_spanish'] . PHP_EOL;
echo '✅ Datos: ' . ($snapshot['demoInfo']['is_simulated'] ? 'Simulados' : 'Reales') . PHP_EOL;
echo '✅ Riesgo: ' . $snapshot['riskLevel'] . ' (' . $snapshot['riskPercent'] . '%)' . PHP_EOL;
echo '✅ Modo Demo: ' . ($snapshot['isDemoMode'] ? 'SÍ' : 'NO') . PHP_EOL;