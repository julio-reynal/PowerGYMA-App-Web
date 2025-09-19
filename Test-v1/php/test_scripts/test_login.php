<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Simulate login test
echo "Testing login system...\n";

$user = App\Models\User::where('email', 'cliente@powergyma.com')->first();

if ($user) {
    echo "User found: {$user->email}\n";
    echo "Role: {$user->role}\n";
    echo "Active: " . ($user->is_active ? 'Yes' : 'No') . "\n";
    
    $passwordCheck = password_verify('cliente123', $user->password);
    echo "Password check: " . ($passwordCheck ? 'PASS' : 'FAIL') . "\n";
    
    // Test Auth attempt
    $credentials = ['email' => 'cliente@powergyma.com', 'password' => 'cliente123'];
    $authAttempt = Auth::attempt($credentials);
    echo "Auth attempt: " . ($authAttempt ? 'SUCCESS' : 'FAILED') . "\n";
    
    if ($authAttempt) {
        echo "Authenticated user: " . Auth::user()->email . "\n";
    }
} else {
    echo "User NOT found!\n";
}

echo "\nTesting web request simulation...\n";

// Create a test request to login endpoint
$request = Illuminate\Http\Request::create('/login', 'POST', [
    'email' => 'cliente@powergyma.com',
    'password' => 'cliente123',
    '_token' => 'test-token'
]);

$controller = new App\Http\Controllers\Auth\LoginController();

try {
    echo "Login controller test completed\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
