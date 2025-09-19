<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🚀 TESTING FASE 4: AUTOCOMPLETADO AVANZADO\n";
echo "==========================================\n\n";

// Probar servicios de API
$apiTests = [
    [
        'name' => 'Búsqueda de departamentos: "lima"',
        'url' => 'http://127.0.0.1:8000/api/v1/locations/departamentos/search?q=lima&limit=3'
    ],
    [
        'name' => 'Búsqueda de departamentos: "cusco"',
        'url' => 'http://127.0.0.1:8000/api/v1/locations/departamentos/search?q=cusco&limit=3'
    ],
    [
        'name' => 'Búsqueda de departamentos: "ayacu"',
        'url' => 'http://127.0.0.1:8000/api/v1/locations/departamentos/search?q=ayacu&limit=3'
    ],
    [
        'name' => 'Búsqueda de provincias en Lima: "lima"',
        'url' => 'http://127.0.0.1:8000/api/v1/locations/provincias/search?q=lima&departamento_id=15&limit=3'
    ],
    [
        'name' => 'Búsqueda de provincias en Ayacucho: "huan"',
        'url' => 'http://127.0.0.1:8000/api/v1/locations/provincias/search?q=huan&departamento_id=5&limit=3'
    ]
];

function testAPI($name, $url) {
    echo "🔍 Probando: $name\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Content-Type: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        if ($data && $data['success']) {
            echo "  ✅ SUCCESS: {$data['count']} resultados encontrados\n";
            if (!empty($data['data'])) {
                foreach ($data['data'] as $item) {
                    echo "    - {$item['nombre']} (ID: {$item['id']})\n";
                }
            }
        } else {
            echo "  ❌ ERROR: API devolvió error\n";
        }
    } else {
        echo "  ❌ HTTP ERROR: $httpCode\n";
    }
    echo "\n";
}

// Ejecutar pruebas
foreach ($apiTests as $test) {
    testAPI($test['name'], $test['url']);
}

// Verificar archivos del componente
echo "📁 VERIFICANDO ARCHIVOS:\n";
echo "========================\n\n";

$files = [
    'public/resources/js/advanced-location-autocomplete.js' => 'Componente JavaScript avanzado',
    'resources/views/demo/autocompletado.blade.php' => 'Página de demostración',
    'app/Http/Controllers/Api/LocationController.php' => 'Controlador de API'
];

foreach ($files as $file => $description) {
    $fullPath = base_path($file);
    if (file_exists($fullPath)) {
        $size = number_format(filesize($fullPath) / 1024, 1);
        echo "  ✅ $description: {$size}KB\n";
    } else {
        echo "  ❌ $description: NO ENCONTRADO\n";
    }
}

echo "\n🌐 URLS DE ACCESO:\n";
echo "==================\n\n";
echo "  📍 Demo de Autocompletado: http://127.0.0.1:8000/demo/autocompletado\n";
echo "  🔍 API Departamentos: http://127.0.0.1:8000/api/v1/locations/departamentos/search?q=QUERY\n";
echo "  🏘️ API Provincias: http://127.0.0.1:8000/api/v1/locations/provincias/search?q=QUERY&departamento_id=ID\n";

echo "\n✅ FASE 4: AUTOCOMPLETADO AVANZADO - IMPLEMENTACIÓN COMPLETADA\n";
