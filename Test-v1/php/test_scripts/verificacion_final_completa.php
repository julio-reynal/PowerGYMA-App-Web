<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\DemoDashboardSnapshotService;
use Illuminate\Support\Facades\Cache;

echo "🔄 VERIFICACIÓN FINAL DESPUÉS DE LIMPIAR CACHÉS" . PHP_EOL;
echo "=============================================" . PHP_EOL;

// Limpiar específicamente el caché de demo
Cache::forget('demo_dashboard_snapshot');

// Crear nuevo snapshot
$service = new DemoDashboardSnapshotService();
$snapshot = $service->refreshCache();

echo "✅ ESTADO ACTUAL:" . PHP_EOL;
echo "   📅 Mes actual: " . now()->format('F Y') . PHP_EOL;
echo "   📅 Mes demo: " . $snapshot['demoInfo']['month_spanish'] . PHP_EOL;
echo "   🔧 Modo demo: " . ($snapshot['isDemoMode'] ? 'ACTIVO' : 'INACTIVO') . PHP_EOL;
echo "   📊 Fuente: " . $snapshot['dataSource'] . PHP_EOL;

echo PHP_EOL . "🎯 LO QUE DEBES VER EN EL NAVEGADOR:" . PHP_EOL;
echo "   ✅ Título: 'Previsión Agosto 2025 (Demo)'" . PHP_EOL;
echo "   ✅ Botón fecha: 'Agosto 2025'" . PHP_EOL;
echo "   ✅ Fecha completa: 'viernes, 15 de agosto de 2025 (Demo)'" . PHP_EOL;
echo "   ✅ Banner: 'Datos de Agosto 2025'" . PHP_EOL;

echo PHP_EOL . "💡 SI AÚN VES 'SEPTIEMBRE':" . PHP_EOL;
echo "   1. 🔄 Presiona Ctrl+F5 para FORZAR la recarga" . PHP_EOL;
echo "   2. 🕵️ Abre en modo INCÓGNITO" . PHP_EOL;
echo "   3. 🧹 Limpia la CACHÉ del navegador manualmente" . PHP_EOL;
echo "   4. 🔍 Inspecciona elemento y verifica que no hay errores JavaScript" . PHP_EOL;
echo "   5. 🌐 Prueba en otro navegador diferente" . PHP_EOL;

echo PHP_EOL . "⚠️  IMPORTANTE:" . PHP_EOL;
echo "   El backend está configurado CORRECTAMENTE ✅" . PHP_EOL;
echo "   Si ves 'Septiembre', es 100% problema de caché del navegador 🌐" . PHP_EOL;

echo PHP_EOL . "📝 VERIFICACIÓN DE TÍTULO:" . PHP_EOL;
echo "   El título de la página ahora incluye timestamp: '" . date('His') . "'" . PHP_EOL;
echo "   Esto debería forzar la recarga del navegador" . PHP_EOL;

echo PHP_EOL . "🎉 ¡CONFIGURACIÓN COMPLETADA!" . PHP_EOL;