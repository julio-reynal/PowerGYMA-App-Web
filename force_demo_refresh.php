<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\DemoDashboardSnapshotService;
use Illuminate\Support\Facades\Cache;

echo "=== LIMPIEZA Y VERIFICACIÓN DE CACHÉ DEMO ===" . PHP_EOL;

// Limpiar específicamente el caché de demo
Cache::forget('demo_dashboard_snapshot');
echo "✅ Caché demo limpiado" . PHP_EOL;

// Crear nuevo snapshot
$service = new DemoDashboardSnapshotService();
$snapshot = $service->refreshCache();

echo "✅ Snapshot demo recreado:" . PHP_EOL;
echo "   - isDemoMode: " . ($snapshot['isDemoMode'] ? 'true' : 'false') . PHP_EOL;
echo "   - month_spanish: " . ($snapshot['demoInfo']['month_spanish'] ?? 'NO DEFINIDO') . PHP_EOL;
echo "   - is_simulated: " . ($snapshot['demoInfo']['is_simulated'] ? 'true' : 'false') . PHP_EOL;

// Verificar que esté en caché
$cached = Cache::get('demo_dashboard_snapshot');
echo "✅ Verificación de caché:" . PHP_EOL;
echo "   - Caché existe: " . ($cached ? 'SÍ' : 'NO') . PHP_EOL;
echo "   - Mes en caché: " . ($cached['demoInfo']['month_spanish'] ?? 'NO DEFINIDO') . PHP_EOL;

echo PHP_EOL . "¡Listo! El dashboard demo ahora debería mostrar " . $snapshot['demoInfo']['month_spanish'] . PHP_EOL;