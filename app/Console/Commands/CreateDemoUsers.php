<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateDemoUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create-demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear usuarios de demostración';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creando usuarios de demostración...');
        
        $users = [
            [
                'name' => 'Admin Power GYMA',
                'email' => 'admin@powergyma.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true
            ],
            [
                'name' => 'Cliente Demo',
                'email' => 'cliente@powergyma.com',
                'password' => Hash::make('password123'),
                'role' => 'cliente',
                'is_active' => true
            ],
            [
                'name' => 'Usuario Demo',
                'email' => 'demo@powergyma.com',
                'password' => Hash::make('password123'),
                'role' => 'demo',
                'is_active' => true,
                'expires_at' => now()->addDays(30)
            ]
        ];
        
        foreach ($users as $userData) {
            $existing = User::where('email', $userData['email'])->first();
            
            if ($existing) {
                $this->line("✅ Usuario ya existe: {$userData['email']}");
                // Actualizar contraseña por si acaso
                $existing->update(['password' => $userData['password']]);
                $this->line("   Contraseña actualizada");
            } else {
                User::create($userData);
                $this->line("✅ Usuario creado: {$userData['email']} ({$userData['role']})");
            }
        }
        
        $this->info("\n📋 Credenciales de acceso:");
        $this->line("🔧 Admin: admin@powergyma.com / password123");
        $this->line("👤 Cliente: cliente@powergyma.com / password123");
        $this->line("🎯 Demo: demo@powergyma.com / password123");
        
        return 0;
    }
}
