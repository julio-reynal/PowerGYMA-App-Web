<?php
/**
 * Script de prueba para verificar APIs de ubicaciones
 */

echo "🧪 PROBANDO APIs DE UBICACIONES\n";
echo "================================\n\n";

// Configurar base URL
$baseUrl = 'http://127.0.0.1:8000/api/v1/locations';

function testApi($url, $name) {
    echo "📡 Probando: $name\n";
    echo "URL: $url\n";
    
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Accept: application/json\r\n",
            'timeout' => 10
        ]
    ]);
    
    $response = @file_get_contents($url, false, $context);
    
    if ($response === false) {
        echo "❌ Error: No se pudo conectar\n";
        return false;
    }
    
    $data = json_decode($response, true);
    
    if ($data === null) {
        echo "❌ Error: Respuesta no es JSON válido\n";
        echo "Respuesta: " . substr($response, 0, 200) . "...\n";
        return false;
    }
    
    if (isset($data['success']) && $data['success']) {
        echo "✅ Exitoso\n";
        if (isset($data['data']) && is_array($data['data'])) {
            echo "📊 Elementos: " . count($data['data']) . "\n";
            if (count($data['data']) > 0) {
                $first = $data['data'][0];
                echo "📝 Primer elemento: " . json_encode($first, JSON_UNESCAPED_UNICODE) . "\n";
            }
        }
        return true;
    } else {
        echo "❌ Error en API\n";
        echo "Respuesta: " . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";
        return false;
    }
    
    echo "\n";
}

// Esperar un momento para que el servidor inicie
echo "⏳ Esperando que el servidor inicie...\n";
sleep(3);

// Probar APIs
echo "\n🔍 INICIANDO PRUEBAS:\n\n";

$tests = [
    'Departamentos' => $baseUrl . '/departamentos',
    'Departamentos con límite' => $baseUrl . '/departamentos?limit=5',
    'Provincias de Lima (ID=15)' => $baseUrl . '/provincias/departamento/15',
    'Búsqueda departamentos' => $baseUrl . '/departamentos/search?query=Lima',
    'Estadísticas' => $baseUrl . '/stats'
];

foreach ($tests as $name => $url) {
    testApi($url, $name);
    echo "\n" . str_repeat("-", 50) . "\n\n";
}

echo "🏁 PRUEBAS COMPLETADAS\n";
?>
