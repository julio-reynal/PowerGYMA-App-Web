<?php
/**
 * Script para verificar que los assets JavaScript estén accesibles
 */

echo "🔍 VERIFICANDO ASSETS JAVASCRIPT\n";
echo "================================\n\n";

$baseUrl = 'http://127.0.0.1:8000';
$jsFiles = [
    'company-autocomplete.js' => '/resources/js/company-autocomplete.js',
    'location-selector.js' => '/resources/js/location-selector.js',
    'enhanced-registration-form.js' => '/resources/js/enhanced-registration-form.js'
];

foreach ($jsFiles as $name => $path) {
    $url = $baseUrl . $path;
    echo "📁 Verificando: $name\n";
    echo "URL: $url\n";
    
    $headers = @get_headers($url);
    if ($headers && strpos($headers[0], '200') !== false) {
        echo "✅ Accesible\n";
    } else {
        echo "❌ No accesible\n";
        if ($headers) {
            echo "Status: " . $headers[0] . "\n";
        }
    }
    echo "\n";
}

echo "📄 Verificando página demo...\n";
$demoUrl = $baseUrl . '/demo/enhanced-registration';
$headers = @get_headers($demoUrl);
if ($headers && strpos($headers[0], '200') !== false) {
    echo "✅ Página demo accesible: $demoUrl\n";
} else {
    echo "❌ Página demo no accesible\n";
    if ($headers) {
        echo "Status: " . $headers[0] . "\n";
    }
}

echo "\n🎯 PRÓXIMO PASO:\n";
echo "Abrir en navegador: $demoUrl\n";
echo "Y verificar la consola del navegador para errores JavaScript\n";
?>
