<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ExcelUpload;

echo "=== VERIFICANDO TODOS LOS ARCHIVOS EXCEL ===\n";

$allUploads = ExcelUpload::orderBy('created_at', 'desc')->get();

echo "Total de uploads: " . $allUploads->count() . "\n\n";

foreach ($allUploads as $upload) {
    echo "--- Upload ID: {$upload->id} ---\n";
    echo "Archivo: {$upload->original_name}\n";
    echo "Fecha: {$upload->created_at}\n";
    echo "Estado: {$upload->status}\n";
    echo "Tiene processed_data: " . ($upload->processed_data ? 'SÍ' : 'NO') . "\n";
    
    if ($upload->processed_data && is_array($upload->processed_data)) {
        if (isset($upload->processed_data['monthly_data'])) {
            echo "Registros mensuales: " . count($upload->processed_data['monthly_data']) . "\n";
        }
    }
    echo "\n";
}