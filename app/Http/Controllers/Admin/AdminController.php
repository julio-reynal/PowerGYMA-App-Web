<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Dashboard del administrador
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'clientes' => User::where('role', 'cliente')->count(),
            'demos' => User::where('role', 'demo')->count(),
            'expired_demos' => User::where('role', 'demo')
                                ->where('expires_at', '<', now())
                                ->count(),
        ];

        // Estadísticas de datos de riesgo
        $today = now();
        $data_stats = [
            'evaluations_today' => \App\Models\RiskEvaluation::whereDate('evaluation_date', $today)->count(),
            'monthly_entries' => \App\Models\MonthlyRiskData::where('year', $today->year)
                                                              ->where('month', $today->month)
                                                              ->count(),
            'high_risk_days' => \App\Models\MonthlyRiskData::where('year', $today->year)
                                                             ->where('month', $today->month)
                                                             ->whereIn('risk_level', ['Alto', 'Crítico'])
                                                             ->count(),
            'pending_days' => \App\Models\MonthlyRiskData::where('year', $today->year)
                                                          ->where('month', $today->month)
                                                          ->where('status', 'pendiente')
                                                          ->count(),
            'excel_uploads' => \App\Models\ExcelUpload::count(),
        ];

        $recent_users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'data_stats', 'recent_users'));
    }

    /**
     * Lista de usuarios
     */
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Formulario de creación de usuario
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Guardar nuevo usuario
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'cliente', 'demo'])],
            'expires_at' => 'nullable|date|after:today',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ];

        // Si es demo y tiene fecha de expiración
        if ($request->role === 'demo' && $request->expires_at) {
            $userData['expires_at'] = $request->expires_at;
        }

        User::create($userData);

        return redirect()->route('admin.users')
                        ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Crear usuario demo con expiración
     */
    public function createDemo()
    {
        return view('admin.users.create-demo');
    }

    /**
     * Guardar usuario demo
     */
    public function storeDemo(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'expires_at' => 'required|date|after:today',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'demo',
            'expires_at' => $request->expires_at,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users')
                        ->with('success', 'Usuario demo creado exitosamente.');
    }

    /**
     * Desactivar usuario
     */
    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activado' : 'desactivado';
        return redirect()->back()
                        ->with('success', "Usuario {$status} exitosamente.");
    }

    /**
     * Eliminar usuario
     */
    public function deleteUser(User $user)
    {
        // No permitir eliminar el propio usuario
        if ($user->id === auth()->id()) {
            return redirect()->back()
                            ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();
        return redirect()->back()
                        ->with('success', 'Usuario eliminado exitosamente.');
    }
}
