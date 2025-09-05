<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Mostrar dashboard según el rol del usuario
     */
    public function index()
    {
        $user = auth()->user();

        // Verificar si el usuario está activo y no ha expirado
        if (!$user->isActiveAndNotExpired()) {
            auth()->logout();
            return redirect()->route('login')
                           ->with('error', 'Tu cuenta ha expirado o está inactiva.');
        }

    // Redirigir según el rol (insensible a mayúsculas)
    switch (strtolower((string)$user->role)) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            
            case 'cliente':
                return redirect()->route('cliente.dashboard');
            
            case 'demo':
                $daysLeft = $user->expires_at ? now()->diffInDays($user->expires_at) : null;
                return view('dashboard.demo', compact('user', 'daysLeft'));
            
            default:
                return view('dashboard.default', compact('user'));
        }
    }
}
