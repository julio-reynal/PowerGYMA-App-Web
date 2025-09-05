<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios de prueba para Power GYMA
        
        // Usuario administrador
        User::factory()->create([
            'name' => 'Admin Power GYMA',
            'email' => 'admin@powergyma.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // Usuario cliente demo
        User::factory()->create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@powergyma.com',
            'password' => bcrypt('cliente123'),
            'role' => 'cliente',
        ]);

        // Usuario entrenador
        User::factory()->create([
            'name' => 'Entrenador Juan',
            'email' => 'entrenador@powergyma.com',
            'password' => bcrypt('entrenador123'),
            'role' => 'cliente',
        ]);

        // Usuarios adicionales para pruebas
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'demo',
            'expires_at' => now()->addDays(7),
        ]);

        // Semillas de datos mínimos para pruebas rápidas (2–3 días)
        $this->call(QuickTestSeeder::class);
    }
}
