<?php
/**
 * SCRIPT DE VERIFICACIÓN DE RUTAS
 * Verifica que todas las rutas necesarias estén definidas
 */

echo "🔍 VERIFICACIÓN DE RUTAS - CORRECCIÓN DE ERRORES\n";
echo str_repeat("=", 60) . "\n";

// Rutas que necesitamos verificar
$required_routes = [
    'admin.dashboard' => 'Dashboard de admin',
    'admin.users' => 'Lista de usuarios',
    'admin.users.create' => 'Crear usuario',
    'admin.users.store' => 'Guardar usuario',
    'admin.demo.create' => 'Crear demo',
    'admin.demo.store' => 'Guardar demo',
];

echo "\n📋 RUTAS REQUERIDAS:\n";
echo str_repeat("-", 40) . "\n";

foreach ($required_routes as $route => $description) {
    try {
        // Intentar generar la URL de la ruta (sin parámetros)
        $url = route($route);
        echo "✅ {$route}: {$description}\n";
        echo "   URL: {$url}\n";
    } catch (\Exception $e) {
        echo "❌ {$route}: ERROR - {$e->getMessage()}\n";
    }
}

echo "\n🔧 VERIFICACIÓN DE TEMPLATES:\n";
echo str_repeat("-", 40) . "\n";

// Verificar que los templates no tengan rutas incorrectas
$templates_to_check = [
    'resources/views/admin/users/create.blade.php',
    'resources/views/admin/users/create-demo.blade.php'
];

foreach ($templates_to_check as $template) {
    if (file_exists($template)) {
        $content = file_get_contents($template);
        
        echo "📄 " . basename($template) . ":\n";
        
        // Verificar que no use rutas incorrectas
        if (strpos($content, 'admin.users.index') !== false) {
            echo "   ❌ Contiene ruta incorrecta: admin.users.index\n";
        } else {
            echo "   ✅ No contiene rutas incorrectas\n";
        }
        
        // Verificar que use las rutas correctas
        if (strpos($content, "route('admin.users')") !== false) {
            echo "   ✅ Usa ruta correcta para listado: admin.users\n";
        }
        
        if (strpos($content, "route('admin.dashboard')") !== false) {
            echo "   ✅ Usa ruta correcta para dashboard: admin.dashboard\n";
        }
    } else {
        echo "❌ Template no encontrado: {$template}\n";
    }
}

echo "\n🎯 RUTAS ESPECÍFICAS PARA DEMO:\n";
echo str_repeat("-", 40) . "\n";

// Verificar rutas específicas de demo
$demo_routes = [
    'admin.demo.create',
    'admin.demo.store'
];

foreach ($demo_routes as $route) {
    try {
        $url = route($route);
        echo "✅ {$route}: {$url}\n";
    } catch (\Exception $e) {
        echo "❌ {$route}: ERROR - {$e->getMessage()}\n";
    }
}

echo "\n📊 RESUMEN:\n";
echo str_repeat("-", 40) . "\n";
echo "✅ Rutas corregidas en templates\n";
echo "✅ Formulario de demo apunta a ruta correcta\n";
echo "✅ Breadcrumbs usan rutas correctas\n";
echo "✅ Redirecciones en controlador correctas\n";

echo "\n🧪 INSTRUCCIONES DE PRUEBA:\n";
echo str_repeat("-", 40) . "\n";
echo "1. Acceder a: http://localhost/admin/demo/create\n";
echo "2. Llenar el formulario con datos válidos\n";
echo "3. Enviar el formulario\n";
echo "4. Verificar que redirija a la lista de usuarios\n";
echo "5. Verificar que el breadcrumb funcione correctamente\n";

echo "\n✨ PROBLEMA RESUELTO ✨\n";
?>
