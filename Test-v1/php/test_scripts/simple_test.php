<?php
// Test simple para verificar API de departamentos

$url = 'http://127.0.0.1:8000/api/v1/locations/departamentos';

echo "🧪 Probando API de departamentos...\n";
echo "URL: $url\n\n";

$response = @file_get_contents($url, false, stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => "Accept: application/json\r\n",
        'timeout' => 5
    ]
]));

if ($response === false) {
    echo "❌ No se pudo conectar\n";
    exit(1);
}

echo "📡 Respuesta recibida:\n";
echo $response . "\n";

$data = json_decode($response, true);
if ($data && isset($data['success']) && $data['success']) {
    echo "\n✅ API funcionando correctamente\n";
    echo "📊 Departamentos encontrados: " . (isset($data['count']) ? $data['count'] : 'N/A') . "\n";
} else {
    echo "\n❌ Error en la API\n";
}
?>
