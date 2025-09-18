<?php
/**
 * Script de Verificación - Campos Empresariales
 * Verifica que todos los archivos y configuraciones estén correctos
 */

echo "🔍 VERIFICANDO IMPLEMENTACIÓN DE CAMPOS EMPRESARIALES\n";
echo "=" . str_repeat("=", 60) . "\n\n";

$checks = [];
$workspace = "c:\\xampp\\htdocs\\Nueva carpeta\\\$RSO45PZ\\PowerGYMA-App-Web";

// 1. Verificar archivos frontend
echo "📁 1. VERIFICANDO ARCHIVOS FRONTEND\n";

$frontend_files = [
    'resources/views/admin/users/create.blade.php' => 'Template de creación de clientes',
    'resources/views/admin/users/create-demo.blade.php' => 'Template de creación de demos',
    'public/resources/js/location-handler.js' => 'Script de manejo de ubicaciones'
];

foreach ($frontend_files as $file => $description) {
    $full_path = $workspace . '\\' . str_replace('/', '\\', $file);
    if (file_exists($full_path)) {
        echo "  ✅ $description\n";
        $checks[] = "✅ $file";
    } else {
        echo "  ❌ $description - ARCHIVO NO ENCONTRADO\n";
        $checks[] = "❌ $file";
    }
}

// 2. Verificar controladores
echo "\n🎮 2. VERIFICANDO CONTROLADORES\n";

$controller_file = $workspace . '\\app\\Http\\Controllers\\Admin\\AdminController.php';
if (file_exists($controller_file)) {
    $controller_content = file_get_contents($controller_file);
    
    // Verificar métodos actualizados
    $controller_checks = [
        'ruc_empresa' => 'Campo RUC empresa en validaciones',
        'giro_empresa' => 'Campo giro empresa en validaciones',
        'razon_social' => 'Campo razón social en validaciones',
        'puesto_trabajo' => 'Campo puesto trabajo en validaciones',
        'telefono_celular' => 'Campo teléfono celular en validaciones',
        'departamento' => 'Campo departamento en validaciones',
        'provincia' => 'Campo provincia en validaciones',
        'direccion_empresa' => 'Campo dirección empresa en validaciones'
    ];
    
    foreach ($controller_checks as $field => $description) {
        if (strpos($controller_content, $field) !== false) {
            echo "  ✅ $description\n";
            $checks[] = "✅ Controller: $field";
        } else {
            echo "  ❌ $description - NO ENCONTRADO\n";
            $checks[] = "❌ Controller: $field";
        }
    }
} else {
    echo "  ❌ AdminController.php - ARCHIVO NO ENCONTRADO\n";
    $checks[] = "❌ AdminController.php";
}

// 3. Verificar modelo User
echo "\n👤 3. VERIFICANDO MODELO USER\n";

$user_model = $workspace . '\\app\\Models\\User.php';
if (file_exists($user_model)) {
    $user_content = file_get_contents($user_model);
    
    $model_fields = [
        'ruc_empresa', 'giro_empresa', 'razon_social', 'puesto_trabajo',
        'telefono_fijo', 'departamento', 'provincia', 'direccion_empresa'
    ];
    
    $found_fields = 0;
    foreach ($model_fields as $field) {
        if (strpos($user_content, "'$field'") !== false) {
            $found_fields++;
        }
    }
    
    echo "  ✅ Campos empresariales en \$fillable: $found_fields/" . count($model_fields) . "\n";
    $checks[] = "✅ User Model: $found_fields/" . count($model_fields) . " campos";
} else {
    echo "  ❌ User.php - ARCHIVO NO ENCONTRADO\n";
    $checks[] = "❌ User.php";
}

// 4. Verificar migración
echo "\n🗄️ 4. VERIFICANDO MIGRACIÓN\n";

$migrations_dir = $workspace . '\\database\\migrations';
$migration_found = false;

if (is_dir($migrations_dir)) {
    $migrations = scandir($migrations_dir);
    foreach ($migrations as $migration) {
        if (strpos($migration, 'add_additional_empresa_fields') !== false) {
            $migration_found = true;
            echo "  ✅ Migración de campos empresariales: $migration\n";
            $checks[] = "✅ Migration: $migration";
            break;
        }
    }
}

if (!$migration_found) {
    echo "  ❌ Migración de campos empresariales - NO ENCONTRADA\n";
    $checks[] = "❌ Migration: empresa fields";
}

// 5. Verificar JavaScript de ubicaciones
echo "\n🌍 5. VERIFICANDO JAVASCRIPT DE UBICACIONES\n";

$location_js = $workspace . '\\public\\resources\\js\\location-handler.js';
if (file_exists($location_js)) {
    $js_content = file_get_contents($location_js);
    
    $js_checks = [
        'class LocationHandler' => 'Clase LocationHandler',
        'this.provincias' => 'Objeto de provincias',
        'updateProvincias' => 'Método updateProvincias',
        'setupEventListeners' => 'Setup de event listeners',
        'getAllDepartamentos' => 'Método getAllDepartamentos'
    ];
    
    foreach ($js_checks as $pattern => $description) {
        if (strpos($js_content, $pattern) !== false) {
            echo "  ✅ $description\n";
            $checks[] = "✅ JS: $description";
        } else {
            echo "  ❌ $description - NO ENCONTRADO\n";
            $checks[] = "❌ JS: $description";
        }
    }
} else {
    echo "  ❌ location-handler.js - ARCHIVO NO ENCONTRADO\n";
    $checks[] = "❌ location-handler.js";
}

// 6. Verificar templates blade contienen nuevos campos
echo "\n📝 6. VERIFICANDO CAMPOS EN TEMPLATES\n";

$template_files = [
    'resources/views/admin/users/create.blade.php',
    'resources/views/admin/users/create-demo.blade.php'
];

foreach ($template_files as $template) {
    $template_path = $workspace . '\\' . str_replace('/', '\\', $template);
    if (file_exists($template_path)) {
        $template_content = file_get_contents($template_path);
        
        $required_fields = [
            'ruc_empresa' => 'RUC empresa',
            'giro_empresa' => 'Giro empresa',
            'razon_social' => 'Razón social',
            'puesto_trabajo' => 'Puesto trabajo',
            'telefono_celular' => 'Teléfono celular',
            'departamento' => 'Departamento',
            'provincia' => 'Provincia',
            'direccion_empresa' => 'Dirección empresa'
        ];
        
        $found_in_template = 0;
        foreach ($required_fields as $field => $label) {
            if (strpos($template_content, $field) !== false) {
                $found_in_template++;
            }
        }
        
        echo "  ✅ " . basename($template) . ": $found_in_template/" . count($required_fields) . " campos\n";
        $checks[] = "✅ Template " . basename($template) . ": $found_in_template/" . count($required_fields);
    }
}

// 7. Resumen final
echo "\n📊 RESUMEN DE VERIFICACIÓN\n";
echo "=" . str_repeat("=", 60) . "\n";

$total_checks = count($checks);
$passed_checks = count(array_filter($checks, function($check) {
    return strpos($check, '✅') === 0;
}));

echo "Total de verificaciones: $total_checks\n";
echo "Verificaciones exitosas: $passed_checks\n";
echo "Verificaciones fallidas: " . ($total_checks - $passed_checks) . "\n";

$percentage = round(($passed_checks / $total_checks) * 100, 1);
echo "Porcentaje de éxito: $percentage%\n\n";

if ($percentage >= 90) {
    echo "🎉 IMPLEMENTACIÓN EXITOSA - Todo listo para usar\n";
} elseif ($percentage >= 75) {
    echo "⚠️ IMPLEMENTACIÓN MAYORMENTE COMPLETA - Revisar elementos faltantes\n";
} else {
    echo "❌ IMPLEMENTACIÓN INCOMPLETA - Requiere correcciones\n";
}

echo "\n📋 SIGUIENTES PASOS:\n";
echo "1. Iniciar MySQL/XAMPP\n";
echo "2. Ejecutar: php artisan migrate\n";
echo "3. Probar formularios en:\n";
echo "   - http://localhost/admin/users/create\n";
echo "   - http://localhost/admin/demo/create\n";
echo "4. Verificar validaciones frontend y backend\n";
echo "5. Confirmar carga dinámica de provincias\n";

echo "\n" . str_repeat("=", 60) . "\n";
echo "Verificación completada: " . date('Y-m-d H:i:s') . "\n";
?>
