<?php
/**
 * Script para verificar usuarios y crear credenciales de prueba
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "🔍 VERIFICANDO USUARIOS EN LA BASE DE DATOS\n";
echo "==========================================\n\n";

try {
    $users = User::all(['id', 'name', 'email', 'role']);
    
    echo "📊 Total de usuarios encontrados: " . $users->count() . "\n\n";
    
    if ($users->count() > 0) {
        echo "👥 USUARIOS EXISTENTES:\n";
        echo "----------------------\n";
        foreach ($users as $user) {
            echo "ID: {$user->id}\n";
            echo "Nombre: {$user->name}\n";
            echo "Email: {$user->email}\n";
            echo "Rol: " . ($user->role ?? 'usuario') . "\n";
            echo "------------------------\n";
        }
    } else {
        echo "❌ No se encontraron usuarios en la base de datos.\n";
        echo "🔧 CREANDO USUARIO DE PRUEBA...\n\n";
        
        $adminUser = User::create([
            'name' => 'Administrador',
            'email' => 'admin@powergyma.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        
        echo "✅ Usuario administrador creado:\n";
        echo "Email: admin@powergyma.com\n";
        echo "Password: admin123\n";
        echo "Rol: admin\n\n";
        
        $demoUser = User::create([
            'name' => 'Usuario Demo',
            'email' => 'demo@powergyma.com', 
            'password' => Hash::make('demo123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
        
        echo "✅ Usuario demo creado:\n";
        echo "Email: demo@powergyma.com\n";
        echo "Password: demo123\n";
        echo "Rol: user\n\n";
    }
    
    echo "🎯 CREDENCIALES PARA USAR:\n";
    echo "==========================\n";
    
    $adminExists = User::where('email', 'admin@powergyma.com')->exists();
    $demoExists = User::where('email', 'demo@powergyma.com')->exists();
    
    if ($adminExists) {
        echo "👑 ADMINISTRADOR:\n";
        echo "Email: admin@powergyma.com\n";
        echo "Password: admin123\n\n";
    }
    
    if ($demoExists) {
        echo "👤 USUARIO DEMO:\n";
        echo "Email: demo@powergyma.com\n";
        echo "Password: demo123\n\n";
    }
    
    if (!$adminExists && !$demoExists && $users->count() > 0) {
        echo "📝 Usar las credenciales de los usuarios listados arriba\n";
        echo "💡 Si no conoces las contraseñas, puedes resetearlas con:\n";
        echo "php artisan tinker\n";
        echo ">>> \$user = User::find(1);\n";
        echo ">>> \$user->password = Hash::make('nueva_password');\n";
        echo ">>> \$user->save();\n\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "💡 Asegúrate de que la base de datos esté configurada correctamente.\n";
}

echo "🚀 PARA INICIAR EL SERVIDOR:\n";
echo "php artisan serve\n";
echo "Luego abrir: http://127.0.0.1:8000\n";
?>
