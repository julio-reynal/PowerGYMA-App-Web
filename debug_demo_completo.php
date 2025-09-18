<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\DemoDashboardSnapshotService;
use Illuminate\Support\Facades\Cache;

echo "=== VERIFICACIÓN COMPLETA DEL DASHBOARD DEMO ===" . PHP_EOL;

// Limpiar específicamente el caché de demo
Cache::forget('demo_dashboard_snapshot');
echo "✅ Caché demo limpiado" . PHP_EOL;

// Crear nuevo snapshot
$service = new DemoDashboardSnapshotService();
$snapshot = $service->refreshCache();

echo PHP_EOL . "📊 DATOS DEL SERVICIO:" . PHP_EOL;
echo "   - isDemoMode: " . ($snapshot['isDemoMode'] ? 'SÍ' : 'NO') . PHP_EOL;
echo "   - Mes mostrado: " . ($snapshot['demoInfo']['month_spanish'] ?? 'NO DEFINIDO') . PHP_EOL;
echo "   - Datos simulados: " . ($snapshot['demoInfo']['is_simulated'] ? 'SÍ' : 'NO') . PHP_EOL;
echo "   - Cantidad datos: " . ($snapshot['demoInfo']['data_count'] ?? 0) . PHP_EOL;

echo PHP_EOL . "📅 VERIFICACIÓN DE FECHAS:" . PHP_EOL;
$now = \Carbon\Carbon::now('America/Lima');
$lastMonth = $now->copy()->subMonth();

echo "   - Mes actual: " . $now->format('F Y') . " (mes " . $now->month . ")" . PHP_EOL;
echo "   - Mes pasado: " . $lastMonth->format('F Y') . " (mes " . $lastMonth->month . ")" . PHP_EOL;
echo "   - Mes en español: " . $lastMonth->locale('es')->monthName . " " . $lastMonth->year . PHP_EOL;

echo PHP_EOL . "🔍 VERIFICACIÓN DE VISTA:" . PHP_EOL;
echo "   - Título debería ser: 'Previsión " . $snapshot['demoInfo']['month_spanish'] . " (Demo)'" . PHP_EOL;
echo "   - Botón fecha debería ser: '" . $snapshot['demoInfo']['month_spanish'] . "'" . PHP_EOL;

echo PHP_EOL . "⚠️  POSIBLES PROBLEMAS:" . PHP_EOL;
if ($snapshot['isDemoMode'] && isset($snapshot['demoInfo']['month_spanish'])) {
    echo "   ✅ Los datos del backend están correctos" . PHP_EOL;
    echo "   💡 Si aún ves 'Septiembre' en el navegador:" . PHP_EOL;
    echo "      1. Presiona Ctrl+F5 para forzar recarga completa" . PHP_EOL;
    echo "      2. Abre en modo incógnito" . PHP_EOL;
    echo "      3. Limpia manualmente la caché del navegador" . PHP_EOL;
    echo "      4. Revisa la consola del navegador para errores JavaScript" . PHP_EOL;
} else {
    echo "   ❌ Los datos del backend NO están configurados correctamente" . PHP_EOL;
}

echo PHP_EOL . "🎯 RESULTADO ESPERADO: El dashboard debe mostrar 'Agosto 2025' en lugar de 'Septiembre 2025'" . PHP_EOL;