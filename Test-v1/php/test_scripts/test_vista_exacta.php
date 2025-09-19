<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\DemoDashboardSnapshotService;
use Illuminate\Support\Facades\Cache;

echo "=== SIMULACIÓN EXACTA DE LA VISTA ===" . PHP_EOL;

// Obtener snapshot tal como lo hace el controlador
$demoSnapshotService = new DemoDashboardSnapshotService();
$snapshot = $demoSnapshotService->getCachedOrBuild();

echo "📊 DATOS RECIBIDOS EN LA VISTA:" . PHP_EOL;
echo "   - \$snapshot existe: " . (isset($snapshot) ? 'SÍ' : 'NO') . PHP_EOL;

if (isset($snapshot)) {
    echo "   - \$snapshot['isDemoMode'] existe: " . (isset($snapshot['isDemoMode']) ? 'SÍ' : 'NO') . PHP_EOL;
    
    if (isset($snapshot['isDemoMode'])) {
        echo "   - \$snapshot['isDemoMode'] valor: " . ($snapshot['isDemoMode'] ? 'true' : 'false') . PHP_EOL;
    }
    
    echo "   - \$snapshot['demoInfo'] existe: " . (isset($snapshot['demoInfo']) ? 'SÍ' : 'NO') . PHP_EOL;
    
    if (isset($snapshot['demoInfo'])) {
        echo "   - \$snapshot['demoInfo']['month_spanish']: " . ($snapshot['demoInfo']['month_spanish'] ?? 'NO DEFINIDO') . PHP_EOL;
    }
}

echo PHP_EOL . "🔍 SIMULACIÓN DE LA LÓGICA BLADE:" . PHP_EOL;

// Simular exactamente la lógica de la vista
$condicion = isset($snapshot['isDemoMode']) && $snapshot['isDemoMode'];

echo "   - Condición: isset(\$snapshot['isDemoMode']) && \$snapshot['isDemoMode']" . PHP_EOL;
echo "   - Resultado: " . ($condicion ? 'TRUE (debe mostrar agosto)' : 'FALSE (mostrará septiembre)') . PHP_EOL;

if ($condicion) {
    $titulo = "Previsión " . ($snapshot['demoInfo']['month_spanish'] ?? 'Mes Anterior') . " (Demo)";
    echo "   - Título que se debe mostrar: '$titulo'" . PHP_EOL;
} else {
    $now = \Carbon\Carbon::now('America/Lima');
    $titulo = "Previsión " . ucfirst($now->locale('es')->monthName) . " " . $now->year . " (Demo)";
    echo "   - Título que se debe mostrar: '$titulo'" . PHP_EOL;
}

echo PHP_EOL . "🚨 DIAGNÓSTICO:" . PHP_EOL;
if ($condicion) {
    echo "   ✅ La lógica está correcta - debe mostrar Agosto" . PHP_EOL;
    echo "   ❓ Si ves Septiembre, es problema de caché del navegador" . PHP_EOL;
} else {
    echo "   ❌ ERROR: La condición es FALSE - por eso muestra Septiembre" . PHP_EOL;
    echo "   🔧 Necesitamos revisar por qué isDemoMode no es true" . PHP_EOL;
}

// Mostrar toda la estructura del snapshot para debug
echo PHP_EOL . "🔍 ESTRUCTURA COMPLETA DEL SNAPSHOT:" . PHP_EOL;
var_export($snapshot);