<?php

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Services\ExcelProcessorService;

$processor = new ExcelProcessorService();
$testFile = 'plantilla_test.csv';

if (file_exists($testFile)) {
    echo "Archivo existe, procesando..." . PHP_EOL;
    try {
        $result = $processor->processExcelFile($testFile, 1);
        echo json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . PHP_EOL;
        echo "Trace: " . $e->getTraceAsString() . PHP_EOL;
    }
} else {
    echo "Archivo no encontrado: $testFile" . PHP_EOL;
}
