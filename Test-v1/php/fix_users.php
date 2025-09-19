<?php
/**
 * Script corregido para crear usuarios con roles válidos
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "🔧 CREANDO USUARIOS CON ROLES CORRECTOS\n";
echo "=======================================\n\n";

try {
    // Verificar si ya existe el admin
    $adminExists = User::where('email', 'admin@powergyma.com')->first();
    
    if (!$adminExists) {
        $adminUser = User::create([
            'name' => 'Administrador',
            'email' => 'admin@powergyma.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        
        echo "✅ Usuario administrador creado:\n";
        echo "Email: admin@powergyma.com\n";
        echo "Password: admin123\n";
        echo "Rol: admin\n\n";
    } else {
        echo "ℹ️ Usuario administrador ya existe\n\n";
    }
    
    // Crear usuario demo si no existe
    $demoExists = User::where('email', 'demo@powergyma.com')->first();
    
    if (!$demoExists) {
        $demoUser = User::create([
            'name' => 'Usuario Demo',
            'email' => 'demo@powergyma.com', 
            'password' => Hash::make('demo123'),
            'role' => 'demo',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        
        echo "✅ Usuario demo creado:\n";
        echo "Email: demo@powergyma.com\n";
        echo "Password: demo123\n";
        echo "Rol: demo\n\n";
    } else {
        echo "ℹ️ Usuario demo ya existe\n\n";
    }
    
    // Crear usuario cliente si no existe
    $clienteExists = User::where('email', 'cliente@powergyma.com')->first();
    
    if (!$clienteExists) {
        $clienteUser = User::create([
            'name' => 'Cliente Test',
            'email' => 'cliente@powergyma.com', 
            'password' => Hash::make('cliente123'),
            'role' => 'cliente',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        
        echo "✅ Usuario cliente creado:\n";
        echo "Email: cliente@powergyma.com\n";
        echo "Password: cliente123\n";
        echo "Rol: cliente\n\n";
    } else {
        echo "ℹ️ Usuario cliente ya existe\n\n";
    }
    
    echo "🎯 CREDENCIALES PARA USAR:\n";
    echo "==========================\n\n";
    echo "👑 ADMINISTRADOR:\n";
    echo "Email: admin@powergyma.com\n";
    echo "Password: admin123\n\n";
    
    echo "🎭 USUARIO DEMO:\n";
    echo "Email: demo@powergyma.com\n";
    echo "Password: demo123\n\n";
    
    echo "👤 CLIENTE:\n";
    echo "Email: cliente@powergyma.com\n";
    echo "Password: cliente123\n\n";
    
    // Listar todos los usuarios
    $allUsers = User::all(['id', 'name', 'email', 'role', 'is_active']);
    echo "📋 TODOS LOS USUARIOS:\n";
    echo "======================\n";
    foreach ($allUsers as $user) {
        $status = $user->is_active ? '🟢 Activo' : '🔴 Inactivo';
        echo "ID: {$user->id} | {$user->name} | {$user->email} | {$user->role} | {$status}\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n🚀 AHORA PUEDES INICIAR SESIÓN EN:\n";
echo "http://127.0.0.1:8000/login\n";
?>
