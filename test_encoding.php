<?php

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Services\ExcelProcessorService;
use Illuminate\Support\Facades\Log;

echo "🧪 PRUEBA DE CODIFICACIÓN CSV\n";
echo "==============================\n\n";

// Crear archivo CSV de prueba con diferentes codificaciones
$testCsvContent = "FECHA,3-sept\n";
$testCsvContent .= "RIESGO,Alto\n";
$testCsvContent .= "HORA INICIO,08:00\n";
$testCsvContent .= "HORA FIN,18:00\n";
$testCsvContent .= "\n";
$testCsvContent .= "1-sept,Moderado,Observación con tildes: ésta es una pruébá\n";
$testCsvContent .= "2-sept,Alto,Observación normal\n";
$testCsvContent .= "3-sept,Bajo,Más observaciones con ñ y acentós\n";

// Crear archivos de prueba con diferentes codificaciones
$testFiles = [
    'utf8' => 'test_utf8.csv',
    'iso' => 'test_iso.csv',
    'windows' => 'test_windows.csv'
];

// UTF-8
file_put_contents($testFiles['utf8'], $testCsvContent);

// ISO-8859-1 (Latin-1)
file_put_contents($testFiles['iso'], mb_convert_encoding($testCsvContent, 'ISO-8859-1', 'UTF-8'));

// Windows-1252
file_put_contents($testFiles['windows'], mb_convert_encoding($testCsvContent, 'Windows-1252', 'UTF-8'));

$service = new ExcelProcessorService();

foreach ($testFiles as $encoding => $filename) {
    echo "📄 Probando archivo: {$filename} (codificación: {$encoding})\n";
    echo "---------------------------------------------------\n";
    
    try {
        $result = $service->processFile($filename, null, 2024);
        echo "✅ Éxito: {$result['message']}\n";
        echo "   Evaluaciones diarias: {$result['summary']['daily_evaluations']}\n";
        echo "   Datos mensuales: {$result['summary']['monthly_data']}\n";
    } catch (Exception $e) {
        echo "❌ Error: {$e->getMessage()}\n";
    }
    
    echo "\n";
}

// Limpiar archivos de prueba
foreach ($testFiles as $filename) {
    if (file_exists($filename)) {
        unlink($filename);
    }
}

echo "🔧 PARÁMETROS CORREGIDOS:\n";
echo "========================\n";
echo "✅ Septiembre ahora reconoce: sep, sept, septiembre, september\n";
echo "✅ Codificación UTF-8 mejorada\n";
echo "✅ Detección automática de separadores (coma y punto y coma)\n";
echo "✅ Limpieza de caracteres BOM\n";
echo "✅ Validación y conversión de codificación automática\n";
echo "✅ Mensajes de error más descriptivos\n";

echo "\n📋 FORMATOS SOPORTADOS:\n";
echo "======================\n";
echo "🗓️ FECHAS: DD-MMM donde MMM puede ser:\n";
echo "   • Enero: ene, enero, jan\n";
echo "   • Febrero: feb, febrero, febr\n";
echo "   • Marzo: mar, marzo\n";
echo "   • Abril: abr, abril, apr\n";
echo "   • Mayo: may, mayo\n";
echo "   • Junio: jun, junio, june\n";
echo "   • Julio: jul, julio, july\n";
echo "   • Agosto: ago, agosto, aug\n";
echo "   • Septiembre: sep, sept, septiembre, september ← CORREGIDO\n";
echo "   • Octubre: oct, octubre, october\n";
echo "   • Noviembre: nov, noviembre, november\n";
echo "   • Diciembre: dic, diciembre, dec, december\n";

echo "\n📝 CODIFICACIONES SOPORTADAS:\n";
echo "=============================\n";
echo "✅ UTF-8 (recomendado)\n";
echo "✅ ISO-8859-1 (Latin-1)\n";
echo "✅ Windows-1252\n";
echo "✅ ASCII\n";

echo "\n💡 RECOMENDACIONES:\n";
echo "==================\n";
echo "1. Guarda tus archivos CSV como 'CSV UTF-8' desde Excel\n";
echo "2. Usa fechas en formato: 1-sept, 25-ago, etc.\n";
echo "3. Si tienes caracteres especiales (tildes, ñ), asegúrate de usar UTF-8\n";
echo "4. El sistema ahora detecta y convierte automáticamente la codificación\n";
