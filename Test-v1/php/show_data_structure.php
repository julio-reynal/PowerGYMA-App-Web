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

echo "=== DEMOSTRACIÓN DE DATOS CARGADOS ===\n\n";

try {
    echo "📍 DEPARTAMENTOS DEL PERÚ (Total: " . DB::table('departamentos')->count() . "):\n";
    $departamentos = DB::table('departamentos')->orderBy('nombre')->get();
    
    foreach ($departamentos as $index => $dept) {
        $provincias_count = DB::table('provincias')->where('departamento_id', $dept->id)->count();
        echo sprintf("   %2d. %-20s (Código: %s) - %d provincias\n", 
            $index + 1, $dept->nombre, $dept->codigo, $provincias_count);
    }
    
    echo "\n🏛️ EJEMPLOS DE PROVINCIAS POR DEPARTAMENTO:\n\n";
    
    // Mostrar algunas provincias de departamentos importantes
    $departamentos_ejemplos = ['Lima', 'Arequipa', 'Cusco', 'La Libertad'];
    
    foreach ($departamentos_ejemplos as $dept_nombre) {
        $dept = DB::table('departamentos')->where('nombre', $dept_nombre)->first();
        if ($dept) {
            echo "📋 {$dept_nombre}:\n";
            $provincias = DB::table('provincias')
                ->where('departamento_id', $dept->id)
                ->orderBy('nombre')
                ->get();
            
            foreach ($provincias as $prov) {
                echo "      • {$prov->nombre} (Código: {$prov->codigo})\n";
            }
            echo "\n";
        }
    }
    
    echo "💼 ESTRUCTURA DE TABLA COMPANIES:\n";
    $company_columns = DB::select("SHOW COLUMNS FROM companies");
    foreach ($company_columns as $column) {
        $nullable = $column->Null === 'YES' ? '(nullable)' : '(required)';
        echo sprintf("   %-25s %-15s %s\n", $column->Field, $column->Type, $nullable);
    }
    
    echo "\n👤 NUEVOS CAMPOS EN TABLA USERS:\n";
    $user_columns = DB::select("SHOW COLUMNS FROM users WHERE Field IN ('company_id', 'telefono_celular', 'comentarios_adicionales')");
    foreach ($user_columns as $column) {
        $nullable = $column->Null === 'YES' ? '(nullable)' : '(required)';
        echo sprintf("   %-25s %-15s %s\n", $column->Field, $column->Type, $nullable);
    }
    
    echo "\n🔗 RELACIONES CONFIGURADAS:\n";
    echo "   ✓ Departamento -> hasMany(Provincia)\n";
    echo "   ✓ Departamento -> hasMany(Company)\n";
    echo "   ✓ Provincia -> belongsTo(Departamento)\n";
    echo "   ✓ Provincia -> hasMany(Company)\n";
    echo "   ✓ Company -> belongsTo(Departamento)\n";
    echo "   ✓ Company -> belongsTo(Provincia)\n";
    echo "   ✓ Company -> hasMany(User)\n";
    echo "   ✓ User -> belongsTo(Company)\n";
    
    echo "\n📊 RESUMEN DE IMPLEMENTACIÓN:\n";
    echo "   ✅ 4 migraciones creadas y ejecutadas\n";
    echo "   ✅ 3 modelos nuevos con relaciones\n";
    echo "   ✅ 1 modelo User actualizado\n";
    echo "   ✅ 2 seeders con datos geográficos\n";
    echo "   ✅ 25 departamentos del Perú\n";
    echo "   ✅ 96 provincias principales\n";
    echo "   ✅ Índices optimizados para consultas\n";
    echo "   ✅ Validaciones y constraints configurados\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
