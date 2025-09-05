<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TestLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test login functionality and user credentials';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing login system...');
        
        // Check if users exist
        $users = User::all();
        $this->info("Total users: " . $users->count());
        
        foreach ($users as $user) {
            $this->line("User: {$user->email} | Role: {$user->role} | Active: " . ($user->is_active ? 'Yes' : 'No'));
        }
        
        // Test specific user
        $email = 'cliente@powergyma.com';
        $password = 'cliente123';
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User {$email} not found!");
            return;
        }
        
        $this->info("Found user: {$user->email}");
        $this->info("Role: {$user->role}");
        $this->info("Active: " . ($user->is_active ? 'Yes' : 'No'));
        $this->info("Expires: " . ($user->expires_at ? $user->expires_at->format('Y-m-d H:i:s') : 'Never'));
        
        // Test password
        $passwordCheck = Hash::check($password, $user->password);
        $this->info("Password check for '{$password}': " . ($passwordCheck ? 'PASS' : 'FAIL'));
        
        // Test Auth::attempt
        $credentials = ['email' => $email, 'password' => $password];
        $authAttempt = Auth::attempt($credentials);
        $this->info("Auth::attempt result: " . ($authAttempt ? 'SUCCESS' : 'FAILED'));
        
        if ($authAttempt) {
            $this->info("Authenticated as: " . Auth::user()->email);
            Auth::logout();
        }
        
        // Test isActiveAndNotExpired
        $this->info("isActiveAndNotExpired: " . ($user->isActiveAndNotExpired() ? 'Yes' : 'No'));
    }
}
