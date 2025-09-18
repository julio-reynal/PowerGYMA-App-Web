<?php

// Archivo de prueba para verificar las estadísticas del dashboard
require_once 'vendor/autoload.php';

use App\Models\DemoRequest;
use App\Models\User;

// Simular el ambiente Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "=== VERIFICACIÓN DE ESTADÍSTICAS DEL DASHBOARD ===\n\n";
    
    // Estadísticas de usuarios
    echo "📊 ESTADÍSTICAS DE USUARIOS:\n";
    echo "- Total usuarios: " . User::count() . "\n";
    echo "- Administradores: " . User::where('role', 'admin')->count() . "\n";
    echo "- Clientes: " . User::where('role', 'cliente')->count() . "\n";
    echo "- Demos: " . User::where('role', 'demo')->count() . "\n";
    echo "- Demos expirados: " . User::where('role', 'demo')->where('expires_at', '<', now())->count() . "\n\n";
    
    // Estadísticas de solicitudes de demo
    echo "📋 ESTADÍSTICAS DE SOLICITUDES DE DEMO:\n";
    echo "- Total solicitudes: " . DemoRequest::count() . "\n";
    echo "- Pendientes: " . DemoRequest::where('estado', 'pendiente')->count() . "\n";
    echo "- Contactados: " . DemoRequest::where('estado', 'contactado')->count() . "\n";
    echo "- Programados: " . DemoRequest::where('estado', 'programado')->count() . "\n";
    echo "- Completados: " . DemoRequest::where('estado', 'completado')->count() . "\n";
    echo "- Recientes (7 días): " . DemoRequest::where('created_at', '>=', now()->subDays(7))->count() . "\n\n";
    
    // Mostrar solicitudes recientes
    echo "📝 SOLICITUDES RECIENTES (Últimas 5):\n";
    $recent_requests = DemoRequest::latest()->take(5)->get();
    
    if ($recent_requests->count() > 0) {
        foreach ($recent_requests as $request) {
            echo "- {$request->nombre} ({$request->email}) - {$request->empresa} - Estado: {$request->estado}\n";
        }
    } else {
        echo "- No hay solicitudes registradas\n";
    }
    
    echo "\n✅ Verificación completada exitosamente\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Detalles: " . $e->getTraceAsString() . "\n";
}