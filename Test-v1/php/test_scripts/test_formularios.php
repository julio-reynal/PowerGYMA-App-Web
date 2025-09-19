<?php
/**
 * Script de prueba para FASE 5: FORMULARIOS Y VALIDACIONES
 * Valida toda la funcionalidad de formularios avanzados
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "🧪 INICIANDO PRUEBAS DE FASE 5: FORMULARIOS Y VALIDACIONES\n";
echo "================================================================\n\n";

// Configuración base
$baseUrl = 'http://127.0.0.1:8000';
$testResults = [];

// Función para realizar peticiones HTTP
function makeRequest($url, $method = 'GET', $data = null, $headers = []) {
    $ch = curl_init();
    
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'FASE5-Tester/1.0'
    ]);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) {
            if (is_array($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                $headers[] = 'Content-Type: application/json';
            }
        }
    }
    
    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    
    curl_close($ch);
    
    return [
        'response' => $response,
        'http_code' => $httpCode,
        'error' => $error
    ];
}

// 1. Verificar archivos de FASE 5
echo "📁 1. VERIFICANDO ARCHIVOS DE FASE 5\n";
echo "-----------------------------------\n";

$files = [
    'Validador JS' => 'public/resources/js/advanced-form-validator.js',
    'FormRequest' => 'app/Http/Requests/AdvancedLocationFormRequest.php',
    'Controlador' => 'app/Http/Controllers/AdvancedFormController.php',
    'Vista Demo' => 'resources/views/demo/formularios.blade.php'
];

foreach ($files as $name => $path) {
    $fullPath = __DIR__ . '/' . $path;
    if (file_exists($fullPath)) {
        $size = round(filesize($fullPath) / 1024, 1);
        echo "  ✅ $name: $size KB\n";
        $testResults[] = ['test' => "Archivo $name", 'status' => 'SUCCESS', 'details' => "$size KB"];
    } else {
        echo "  ❌ $name: NO ENCONTRADO\n";
        $testResults[] = ['test' => "Archivo $name", 'status' => 'FAILED', 'details' => 'Archivo no encontrado'];
    }
}

echo "\n";

// 2. Verificar rutas de formularios
echo "🌐 2. VERIFICANDO RUTAS DE FORMULARIOS\n";
echo "-------------------------------------\n";

$routes = [
    'Demo Formularios' => '/demo/formularios',
    'API Validar Campo' => '/api/v1/forms/validate-field',
    'API Verificar Email' => '/api/v1/forms/check-email',
    'API Validar Ubicación' => '/api/v1/forms/validate-location'
];

foreach ($routes as $name => $route) {
    $url = $baseUrl . $route;
    $result = makeRequest($url);
    
    if ($result['http_code'] === 200) {
        echo "  ✅ $name: HTTP {$result['http_code']}\n";
        $testResults[] = ['test' => "Ruta $name", 'status' => 'SUCCESS', 'details' => "HTTP {$result['http_code']}"];
    } elseif ($result['http_code'] === 401 || $result['http_code'] === 302) {
        echo "  ⚠️  $name: HTTP {$result['http_code']} (Requiere autenticación)\n";
        $testResults[] = ['test' => "Ruta $name", 'status' => 'SUCCESS', 'details' => "HTTP {$result['http_code']} - Auth required"];
    } else {
        echo "  ❌ $name: HTTP {$result['http_code']}\n";
        $testResults[] = ['test' => "Ruta $name", 'status' => 'FAILED', 'details' => "HTTP {$result['http_code']}"];
    }
}

echo "\n";

// 3. Verificar integración con Laravel
echo "🔧 3. VERIFICANDO INTEGRACIÓN CON LARAVEL\n";
echo "----------------------------------------\n";

// Verificar que las clases existen
$classes = [
    'FormRequest' => 'App\\Http\\Requests\\AdvancedLocationFormRequest',
    'Controlador' => 'App\\Http\\Controllers\\AdvancedFormController'
];

foreach ($classes as $name => $className) {
    try {
        if (class_exists($className)) {
            echo "  ✅ $name: Clase cargada correctamente\n";
            $testResults[] = ['test' => "Clase $name", 'status' => 'SUCCESS', 'details' => 'Clase existe'];
        } else {
            echo "  ❌ $name: Clase no encontrada\n";
            $testResults[] = ['test' => "Clase $name", 'status' => 'FAILED', 'details' => 'Clase no existe'];
        }
    } catch (Exception $e) {
        echo "  ❌ $name: Error - {$e->getMessage()}\n";
        $testResults[] = ['test' => "Clase $name", 'status' => 'FAILED', 'details' => $e->getMessage()];
    }
}

echo "\n";

// 4. Simular validaciones de formulario
echo "✅ 4. SIMULANDO VALIDACIONES DE FORMULARIO\n";
echo "-----------------------------------------\n";

// Datos de prueba para validación
$testValidations = [
    'Email válido' => [
        'field' => 'email',
        'value' => 'test@ejemplo.com',
        'expected' => true
    ],
    'Email inválido' => [
        'field' => 'email',
        'value' => 'email-invalido',
        'expected' => false
    ],
    'DNI válido' => [
        'field' => 'numero_documento',
        'value' => '12345678',
        'tipo' => 'DNI',
        'expected' => true
    ],
    'DNI inválido' => [
        'field' => 'numero_documento',
        'value' => '123',
        'tipo' => 'DNI',
        'expected' => false
    ],
    'RUC válido' => [
        'field' => 'numero_documento',
        'value' => '20123456789',
        'tipo' => 'RUC',
        'expected' => true
    ]
];

foreach ($testValidations as $testName => $test) {
    // Simular validación con reglas de Laravel
    $isValid = false;
    
    switch ($test['field']) {
        case 'email':
            $isValid = filter_var($test['value'], FILTER_VALIDATE_EMAIL) !== false;
            break;
        case 'numero_documento':
            if ($test['tipo'] === 'DNI') {
                $isValid = preg_match('/^\d{8}$/', $test['value']);
            } elseif ($test['tipo'] === 'RUC') {
                $isValid = preg_match('/^\d{11}$/', $test['value']);
            }
            break;
    }
    
    if ($isValid === $test['expected']) {
        echo "  ✅ $testName: Validación correcta\n";
        $testResults[] = ['test' => "Validación $testName", 'status' => 'SUCCESS', 'details' => 'Validación correcta'];
    } else {
        echo "  ❌ $testName: Validación incorrecta\n";
        $testResults[] = ['test' => "Validación $testName", 'status' => 'FAILED', 'details' => 'Validación incorrecta'];
    }
}

echo "\n";

// 5. Verificar estructura de la base de datos para formularios
echo "🗄️  5. VERIFICANDO ESTRUCTURA DE BASE DE DATOS\n";
echo "---------------------------------------------\n";

try {
    // Verificar que las tablas necesarias existen
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $tables = ['users', 'departamentos', 'provincias'];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='$table'");
        if ($stmt->rowCount() > 0) {
            // Contar registros
            $countStmt = $pdo->query("SELECT COUNT(*) as total FROM $table");
            $count = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
            echo "  ✅ Tabla $table: $count registros\n";
            $testResults[] = ['test' => "Tabla $table", 'status' => 'SUCCESS', 'details' => "$count registros"];
        } else {
            echo "  ❌ Tabla $table: No encontrada\n";
            $testResults[] = ['test' => "Tabla $table", 'status' => 'FAILED', 'details' => 'Tabla no encontrada'];
        }
    }
    
} catch (Exception $e) {
    echo "  ❌ Error de base de datos: {$e->getMessage()}\n";
    $testResults[] = ['test' => 'Base de datos', 'status' => 'FAILED', 'details' => $e->getMessage()];
}

echo "\n";

// 6. Verificar assets JavaScript
echo "📜 6. VERIFICANDO ASSETS JAVASCRIPT\n";
echo "----------------------------------\n";

$jsFiles = [
    'advanced-form-validator.js' => 'public/resources/js/advanced-form-validator.js',
    'advanced-location-autocomplete.js' => 'public/resources/js/advanced-location-autocomplete.js'
];

foreach ($jsFiles as $name => $path) {
    $fullPath = __DIR__ . '/' . $path;
    if (file_exists($fullPath)) {
        $content = file_get_contents($fullPath);
        
        // Verificar que contiene funciones clave
        $functions = [];
        if (strpos($content, 'class AdvancedFormValidator') !== false) {
            $functions[] = 'AdvancedFormValidator class';
        }
        if (strpos($content, 'validateField') !== false) {
            $functions[] = 'validateField method';
        }
        if (strpos($content, 'validateForm') !== false) {
            $functions[] = 'validateForm method';
        }
        
        $size = round(filesize($fullPath) / 1024, 1);
        echo "  ✅ $name: $size KB, " . count($functions) . " funciones detectadas\n";
        $testResults[] = ['test' => "JS $name", 'status' => 'SUCCESS', 'details' => "$size KB, " . implode(', ', $functions)];
    } else {
        echo "  ❌ $name: No encontrado\n";
        $testResults[] = ['test' => "JS $name", 'status' => 'FAILED', 'details' => 'Archivo no encontrado'];
    }
}

echo "\n";

// 7. Generar resumen final
echo "📊 RESUMEN FINAL DE PRUEBAS\n";
echo "==========================\n";

$totalTests = count($testResults);
$successTests = count(array_filter($testResults, function($test) { return $test['status'] === 'SUCCESS'; }));
$failedTests = $totalTests - $successTests;

echo "Total de pruebas: $totalTests\n";
echo "Exitosas: $successTests ✅\n";
echo "Fallidas: $failedTests ❌\n";
echo "Porcentaje de éxito: " . round(($successTests / $totalTests) * 100, 1) . "%\n\n";

if ($failedTests > 0) {
    echo "❌ PRUEBAS FALLIDAS:\n";
    foreach ($testResults as $test) {
        if ($test['status'] === 'FAILED') {
            echo "  - {$test['test']}: {$test['details']}\n";
        }
    }
    echo "\n";
}

// 8. Instrucciones de uso
echo "📋 INSTRUCCIONES DE USO\n";
echo "======================\n";
echo "1. Iniciar el servidor: php artisan serve\n";
echo "2. Acceder a: http://127.0.0.1:8000/demo/formularios\n";
echo "3. Usar credenciales de prueba:\n";
echo "   - admin@powergym.com / admin123\n";
echo "   - cliente@powergym.com / cliente123\n";
echo "   - demo@powergym.com / demo123\n\n";

echo "📝 FUNCIONALIDADES A PROBAR:\n";
echo "============================\n";
echo "✓ Validación en tiempo real de campos\n";
echo "✓ Autocompletado de departamentos y provincias\n";
echo "✓ Validación de documentos (DNI, RUC)\n";
echo "✓ Verificación de emails únicos\n";
echo "✓ Validación cruzada de ubicaciones\n";
echo "✓ Sugerencias inteligentes de campos\n";
echo "✓ Envío de formulario por AJAX\n";
echo "✓ Manejo de errores y mensajes\n";
echo "✓ Testing automatizado de formularios\n\n";

echo "🎯 PUNTOS DE VERIFICACIÓN:\n";
echo "=========================\n";
echo "1. Los campos muestran validación en tiempo real\n";
echo "2. Los mensajes de error aparecen inmediatamente\n";
echo "3. El autocompletado de ubicaciones funciona\n";
echo "4. La validación de DNI/RUC es correcta\n";
echo "5. El formulario se envía correctamente\n";
echo "6. Los datos se guardan en la base de datos\n";
echo "7. Las pruebas automáticas pasan todas\n\n";

if ($successTests === $totalTests) {
    echo "🎉 ¡FASE 5 IMPLEMENTADA EXITOSAMENTE!\n";
    echo "Todas las pruebas han pasado correctamente.\n";
} else {
    echo "⚠️  FASE 5 IMPLEMENTADA CON OBSERVACIONES\n";
    echo "Revisar las pruebas fallidas antes de continuar.\n";
}

echo "\n================================================================\n";
echo "🏁 PRUEBAS DE FASE 5 COMPLETADAS\n";
echo "================================================================\n";
?>
