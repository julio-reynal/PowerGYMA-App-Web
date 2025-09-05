<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Verificar si el usuario está activo y no ha expirado
        if (!$user->isActiveAndNotExpired()) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Tu cuenta ha expirado o está inactiva.');
        }

    // Verificar si el usuario tiene el rol requerido (insensible a mayúsculas)
    if (strtolower($user->role) !== strtolower($role)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
