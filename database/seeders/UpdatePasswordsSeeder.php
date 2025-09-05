<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdatePasswordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Actualizar contraseñas con hash Bcrypt correcto
        $users = [
            [
                'email' => 'admin@powergyma.com',
                'password' => 'password123'
            ],
            [
                'email' => 'cliente@powergyma.com', 
                'password' => 'password123'
            ],
            [
                'email' => 'entrenador@powergyma.com',
                'password' => 'password123'
            ],
            [
                'email' => 'demo@test.com',
                'password' => 'password123'
            ]
        ];

        foreach ($users as $userData) {
            \App\Models\User::where('email', $userData['email'])
                ->update([
                    'password' => \Illuminate\Support\Facades\Hash::make($userData['password'])
                ]);
        }

        $this->command->info('Contraseñas actualizadas correctamente con Bcrypt.');
    }
}
