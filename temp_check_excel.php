<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ExcelUpload;

echo "=== VERIFICANDO ÚLTIMOS ARCHIVOS EXCEL ===\n";

// Obtener los últimos uploads
$uploads = ExcelUpload::orderBy('created_at', 'desc')->take(5)->get();

foreach ($uploads as $upload) {
    echo "\n--- Upload ID: {$upload->id} ---\n";
    echo "Archivo: {$upload->original_name}\n";
    echo "Fecha: {$upload->created_at}\n";
    echo "Estado: {$upload->status}\n";
    
    if ($upload->processed_data && is_array($upload->processed_data)) {
        echo "Tiene datos procesados: SÍ\n";
        
        // Verificar si tiene datos mensuales
        if (isset($upload->processed_data['monthly_data'])) {
            $monthlyData = $upload->processed_data['monthly_data'];
            echo "Registros mensuales: " . count($monthlyData) . "\n";
            
            // Mostrar algunos ejemplos
            $count = 0;
            foreach ($monthlyData as $data) {
                if ($count < 5) {
                    echo "  - {$data['fecha']}: {$data['nivel_riesgo']} (status: " . ($data['status'] ?? 'evaluado') . ")\n";
                    $count++;
                }
            }
            if (count($monthlyData) > 5) {
                echo "  ... y " . (count($monthlyData) - 5) . " más\n";
            }
        }
        
        // Verificar si tiene evaluación diaria
        if (isset($upload->processed_data['daily_evaluation'])) {
            $dailyEval = $upload->processed_data['daily_evaluation'];
            echo "Evaluación diaria: {$dailyEval['evaluation_date']} - {$dailyEval['risk_level']}\n";
        }
    } else {
        echo "Tiene datos procesados: NO\n";
    }
}