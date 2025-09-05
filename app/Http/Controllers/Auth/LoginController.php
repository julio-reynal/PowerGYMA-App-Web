<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        Log::info('Login attempt started', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();
            
            Log::info('Login successful', ['email' => $credentials['email']]);
            
            // Verificar si el usuario está activo y no ha expirado
            $user = Auth::user();
            if (!$user->isActiveAndNotExpired()) {
                Log::warning('User account inactive or expired', ['email' => $credentials['email']]);
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => __('Tu cuenta ha expirado o está inactiva.'),
                ]);
            }
            
            // Redirigir al dashboard según el rol
            return redirect()->intended(route('dashboard'));
        }

        Log::warning('Login failed - invalid credentials', ['email' => $credentials['email']]);
        throw ValidationException::withMessages([
            'email' => __('Estas credenciales no coinciden con nuestros registros.'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
