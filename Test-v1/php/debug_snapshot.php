<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\DemoDashboardSnapshotService;
use Illuminate\Support\Facades\Cache;

// Limpiar caché de demo específico
Cache::forget('demo_dashboard_snapshot');

// Obtener snapshot demo
$service = new DemoDashboardSnapshotService();
$snapshot = $service->getCachedOrBuild();

echo 'Verificando snapshot demo:' . PHP_EOL;
echo 'isDemoMode: ' . ($snapshot['isDemoMode'] ? 'true' : 'false') . PHP_EOL;
echo 'month_spanish: ' . ($snapshot['demoInfo']['month_spanish'] ?? 'NO DEFINIDO') . PHP_EOL;
echo 'date_for_display: ' . ($snapshot['demoInfo']['date_for_display'] ?? 'NO DEFINIDO') . PHP_EOL;
echo 'is_simulated: ' . ($snapshot['demoInfo']['is_simulated'] ? 'true' : 'false') . PHP_EOL;

echo PHP_EOL . 'Datos completos:' . PHP_EOL;
var_dump($snapshot['demoInfo']);