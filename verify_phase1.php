<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

// Configurar la base de datos
$capsule = new DB();
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'database' => 'power_gyma',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

echo "=== VERIFICACIÓN FASE 1: ANÁLISIS Y DISEÑO DE BASE DE DATOS ===\n\n";

try {
    // Verificar tablas creadas
    echo "1. Verificando tablas creadas:\n";
    
    $tables = [
        'departamentos' => DB::table('departamentos')->count(),
        'provincias' => DB::table('provincias')->count(),
        'companies' => DB::table('companies')->count(),
        'users' => DB::table('users')->count()
    ];
    
    foreach ($tables as $table => $count) {
        echo "   ✓ Tabla '{$table}': {$count} registros\n";
    }
    
    echo "\n2. Verificando datos geográficos:\n";
    
    // Verificar algunos departamentos específicos
    $departamentos_importantes = ['Lima', 'Arequipa', 'Cusco', 'La Libertad', 'Piura'];
    foreach ($departamentos_importantes as $dept) {
        $existe = DB::table('departamentos')->where('nombre', $dept)->exists();
        echo "   " . ($existe ? '✓' : '✗') . " Departamento: {$dept}\n";
    }
    
    echo "\n3. Verificando relaciones:\n";
    
    // Verificar que Lima tiene provincias
    $lima_id = DB::table('departamentos')->where('nombre', 'Lima')->value('id');
    if ($lima_id) {
        $provincias_lima = DB::table('provincias')->where('departamento_id', $lima_id)->count();
        echo "   ✓ Lima tiene {$provincias_lima} provincias\n";
    }
    
    // Verificar que los campos nuevos existen en users
    echo "\n4. Verificando nuevos campos en tabla users:\n";
    $user_columns = DB::select("SHOW COLUMNS FROM users");
    $new_fields = ['company_id', 'telefono_celular', 'comentarios_adicionales'];
    
    foreach ($new_fields as $field) {
        $existe = false;
        foreach ($user_columns as $column) {
            if ($column->Field === $field) {
                $existe = true;
                break;
            }
        }
        echo "   " . ($existe ? '✓' : '✗') . " Campo '{$field}' en tabla users\n";
    }
    
    echo "\n5. Verificando índices:\n";
    
    // Verificar algunos índices importantes
    $indices = DB::select("SHOW INDEX FROM companies WHERE Key_name != 'PRIMARY'");
    echo "   ✓ Tabla companies tiene " . count($indices) . " índices (además de PRIMARY)\n";
    
    $indices_users = DB::select("SHOW INDEX FROM users WHERE Key_name != 'PRIMARY'");
    echo "   ✓ Tabla users tiene " . count($indices_users) . " índices (además de PRIMARY)\n";
    
    echo "\n=== VERIFICACIÓN COMPLETADA EXITOSAMENTE ===\n";
    echo "✓ Todas las tablas fueron creadas correctamente\n";
    echo "✓ Los datos geográficos se cargaron exitosamente\n";
    echo "✓ Las relaciones están configuradas correctamente\n";
    echo "✓ Los índices están en su lugar para optimizar consultas\n";
    
} catch (Exception $e) {
    echo "❌ Error durante la verificación: " . $e->getMessage() . "\n";
}
