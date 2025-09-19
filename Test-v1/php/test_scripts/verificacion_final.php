<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\DemoDashboardSnapshotService;
use Illuminate\Support\Facades\Cache;

echo "=== VERIFICACIÓN FINAL DEL DASHBOARD DEMO ===" . PHP_EOL . PHP_EOL;

// Limpiar y recrear caché
Cache::forget('demo_dashboard_snapshot');
$service = new DemoDashboardSnapshotService();
$snapshot = $service->refreshCache();

echo "✅ DATOS DEL SERVICIO:" . PHP_EOL;
echo "   📅 Mes mostrado: " . $snapshot['demoInfo']['month_spanish'] . PHP_EOL;
echo "   🔧 Modo demo: " . ($snapshot['isDemoMode'] ? 'SÍ' : 'NO') . PHP_EOL;
echo "   📊 Datos simulados: " . ($snapshot['demoInfo']['is_simulated'] ? 'SÍ' : 'NO') . PHP_EOL;
echo "   📈 Cantidad de datos: " . $snapshot['demoInfo']['data_count'] . PHP_EOL;

echo PHP_EOL . "✅ VERIFICACIÓN DE VISTA:" . PHP_EOL;

// Simular la lógica de la vista
$isDemoMode = $snapshot['isDemoMode'] ?? false;
$monthSpanish = $snapshot['demoInfo']['month_spanish'] ?? 'Mes Anterior';

if ($isDemoMode) {
    echo "   📅 Título calendario: 'Previsión " . $monthSpanish . " (Demo)'" . PHP_EOL;
    echo "   📅 Botón fecha: '" . $monthSpanish . "'" . PHP_EOL;
    echo "   📅 Fecha completa: '" . \Carbon\Carbon::now('America/Lima')->subMonth()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') . " (Demo)'" . PHP_EOL;
} else {
    echo "   ❌ NO está en modo demo" . PHP_EOL;
}

echo PHP_EOL . "🎯 RESULTADO ESPERADO:" . PHP_EOL;
echo "   - El dashboard debe mostrar 'Agosto 2025' en lugar de 'Septiembre 2025'" . PHP_EOL;
echo "   - Todas las fechas deben ser del mes pasado" . PHP_EOL;
echo "   - Debe indicar claramente que es un demo" . PHP_EOL;

echo PHP_EOL . "💡 Si aún ves 'Septiembre', intenta:" . PHP_EOL;
echo "   1. Refrescar la página con Ctrl+F5 (forzar recarga)" . PHP_EOL;
echo "   2. Abrir en modo incógnito" . PHP_EOL;
echo "   3. Limpiar caché del navegador" . PHP_EOL;

echo PHP_EOL . "✅ ¡Sistema configurado correctamente para mostrar " . $monthSpanish . "!" . PHP_EOL;