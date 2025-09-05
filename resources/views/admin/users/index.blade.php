<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestión de Usuarios - Power GYMA Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { 
            --bg: #f1f5f9; 
            --bg-secondary: #e2e8f0;
            --text: #0f172a; 
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --primary-light: #dbeafe;
            --success: #10b981;
            --success-light: #d1fae5;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --info: #06b6d4;
            --info-light: #cffafe;
            --border: #e2e8f0;
            --border-light: #f1f5f9;
            --card: #ffffff;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius: 12px;
            --radius-sm: 8px;
        }
        
        * { box-sizing: border-box; }
        
        html, body { 
            height: 100%; 
            margin: 0; 
            background: var(--bg); 
            color: var(--text); 
            font-family: 'Inter', system-ui, sans-serif; 
            line-height: 1.6;
        }
        
        /* Header moderno */
        .header { 
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); 
            border-bottom: 1px solid var(--border); 
            padding: 1rem 2rem; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(10px);
            border-radius: 0 0 16px 16px;
        }
        
        .logo { 
            font-size: 1.5rem; 
            font-weight: 700; 
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .logo:hover {
            transform: translateY(-1px);
        }
        
        .logo svg {
            transition: all 0.3s ease;
        }
        
        .logo:hover svg {
            transform: scale(1.05);
        }
        
        .user-info { 
            display: flex; 
            align-items: center; 
            gap: 1rem; 
            flex-wrap: wrap;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            background: linear-gradient(135deg, var(--primary-light), rgba(59, 130, 246, 0.1));
            border-radius: var(--radius);
            font-weight: 500;
            border: 1px solid rgba(59, 130, 246, 0.2);
            transition: all 0.3s ease;
        }
        
        .user-profile:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }
        
        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
        }
        
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        /* Botones */
        .btn { 
            padding: 0.75rem 1.5rem; 
            border-radius: var(--radius-sm); 
            text-decoration: none; 
            font-weight: 600; 
            border: none; 
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }
        
        .btn:hover {
            transform: translateY(-1px);
            text-decoration: none;
        }
        
        .btn-primary { 
            background: linear-gradient(135deg, var(--primary), var(--primary-dark)); 
            color: white; 
        }
        
        .btn-primary:hover {
            box-shadow: var(--shadow-lg);
        }
        
        .btn-success { 
            background: linear-gradient(135deg, var(--success), #059669); 
            color: white; 
        }
        
        .btn-info { 
            background: linear-gradient(135deg, var(--info), #0891b2); 
            color: white; 
        }
        
        .btn-warning { 
            background: linear-gradient(135deg, var(--warning), #d97706); 
            color: white; 
        }
        
        .btn-danger { 
            background: linear-gradient(135deg, var(--danger), #dc2626); 
            color: white; 
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #d97706);
            color: white;
        }
        
        .btn-danger { 
            background: linear-gradient(135deg, var(--danger), #dc2626); 
            color: white; 
        }
        
        .btn-info {
            background: linear-gradient(135deg, var(--info), #0891b2);
            color: white;
        }
        
        .btn-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid;
            color: inherit;
        }
        
        .btn-outline.btn-success {
            border-color: var(--success);
            color: var(--success);
        }
        
        .btn-outline.btn-warning {
            border-color: var(--warning);
            color: var(--warning);
        }
        
        .btn-outline.btn-danger {
            border-color: var(--danger);
            color: var(--danger);
        }
        
        .container { 
            max-width: 1400px; 
            margin: 2rem auto; 
            padding: 0 2rem; 
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 2rem;
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--info));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .page-subtitle {
            color: var(--text-muted);
            margin-top: 0.5rem;
            font-size: 1rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        /* Alertas */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.5rem;
            border: 1px solid;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .alert-success {
            background: var(--success-light);
            color: #065f46;
            border-color: var(--success);
        }
        
        .alert-danger {
            background: var(--danger-light);
            color: #991b1b;
            border-color: var(--danger);
        }
        
        .alert-close {
            margin-left: auto;
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: inherit;
            opacity: 0.7;
        }
        
        .alert-close:hover {
            opacity: 1;
        }
        
        /* Stats cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: var(--card);
            padding: 1.5rem;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .stat-label {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
        
        /* Tabla */
        .table-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        
        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, var(--primary-light), var(--info-light));
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .table-title {
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }
        
        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-light);
        }
        
        .table th {
            background: var(--bg);
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.05em;
        }
        
        .table tbody tr:hover {
            background: var(--border-light);
        }
        
        /* User avatar */
        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 0.75rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        /* Badges */
        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.025em;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .badge-admin { background: var(--danger-light); color: #991b1b; }
        .badge-cliente { background: var(--success-light); color: #065f46; }
        .badge-demo { background: var(--warning-light); color: #92400e; }
        .badge-entrenador { background: var(--info-light); color: #0c4a6e; }
        .badge-active { background: var(--success-light); color: #065f46; }
        .badge-inactive { background: var(--danger-light); color: #991b1b; }
        .badge-expired { background: var(--warning-light); color: #92400e; }
        .badge-current { background: var(--info-light); color: #0c4a6e; }
        
        /* Action buttons group */
        .btn-group {
            display: flex;
            gap: 0.5rem;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }
        
        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            border-radius: var(--radius-sm);
            text-decoration: none;
            border: 1px solid var(--border);
            color: var(--text);
        }
        
        .pagination .active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }
            
            .user-info {
                flex-direction: column;
                width: 100%;
                gap: 0.5rem;
            }
            
            .page-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .action-buttons {
                justify-content: center;
            }
            
            .container {
                padding: 0 1rem;
            }
            
            .table-container {
                font-size: 0.8rem;
            }
            
            .btn {
                font-size: 0.8rem;
                padding: 0.6rem 1rem;
            }
        }
        
        /* Animaciones */
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="logo">
            <img src="/Img/Ico/Ico-Pw.svg" alt="Power GYMA Logo" style="height: 48px;">
            <span style="font-size: 0.8rem; font-weight: 500; color: var(--primary); background: var(--primary-light); padding: 0.25rem 0.5rem; border-radius: 4px; margin-left: 0.5rem;">Admin</span>
        </div>
        <div class="user-info">
            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-info">
                <i class="fas fa-chart-pie"></i>
                Dashboard
            </a>
            <a href="{{ route('admin.excel.index') }}" class="btn btn-info">
                <i class="fas fa-file-excel"></i>
                Gestión Excel
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    Salir
                </button>
            </form>
        </div>
    </header>

    <div class="container fade-in">
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-users-cog"></i>
                    Gestión de Usuarios
                </h1>
                <p class="page-subtitle">Administra todos los usuarios del sistema Power GYMA</p>
            </div>
            <div class="action-buttons">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Crear Usuario
                </a>
                <a href="{{ route('admin.demo.create') }}" class="btn btn-warning">
                    <i class="fas fa-user-clock"></i>
                    Crear Demo
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
                <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Estadísticas rápidas -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-number">{{ $users->total() }}</div>
                <div class="stat-label">Total Usuarios</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $users->where('role', 'admin')->count() }}</div>
                <div class="stat-label">Administradores</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $users->where('role', 'cliente')->count() }}</div>
                <div class="stat-label">Clientes</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $users->where('role', 'demo')->count() }}</div>
                <div class="stat-label">Demos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $users->where('is_active', true)->count() }}</div>
                <div class="stat-label">Activos</div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <div class="table-title">
                    <i class="fas fa-list"></i>
                    Lista de Usuarios
                </div>
                <span class="badge badge-info">{{ $users->total() }} usuarios</span>
            </div>
            
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-user"></i> Usuario</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-user-tag"></i> Rol</th>
                            <th><i class="fas fa-toggle-on"></i> Estado</th>
                            <th><i class="fas fa-clock"></i> Expira</th>
                            <th><i class="fas fa-calendar-plus"></i> Creado</th>
                            <th><i class="fas fa-cog"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td><strong>#{{ $user->id }}</strong></td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar" style="background: {{ $user->role === 'admin' ? 'var(--danger)' : ($user->role === 'cliente' ? 'var(--success)' : 'var(--warning)') }};">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge badge-{{ $user->role }}">
                                        <i class="fas fa-{{ $user->role === 'admin' ? 'user-shield' : ($user->role === 'cliente' ? 'user-check' : ($user->role === 'demo' ? 'user-clock' : 'user-tie')) }}"></i>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->isActiveAndNotExpired())
                                        <span class="badge badge-active">
                                            <i class="fas fa-check-circle"></i> Activo
                                        </span>
                                    @elseif(!$user->is_active)
                                        <span class="badge badge-inactive">
                                            <i class="fas fa-times-circle"></i> Inactivo
                                        </span>
                                    @elseif($user->expires_at && $user->expires_at->isPast())
                                        <span class="badge badge-expired">
                                            <i class="fas fa-clock"></i> Expirado
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-hourglass-half"></i> Pendiente
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->expires_at)
                                        <div style="font-size: 0.85rem;">
                                            {{ $user->expires_at->format('d/m/Y') }}
                                            <div style="color: {{ $user->expires_at->isPast() ? 'var(--danger)' : 'var(--success)' }}; font-size: 0.75rem;">
                                                @if($user->expires_at->isPast())
                                                    <i class="fas fa-exclamation-triangle"></i> Expirado
                                                @else
                                                    <i class="fas fa-check"></i> {{ $user->expires_at->diffForHumans() }}
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span style="color: var(--text-muted); font-size: 0.85rem;">
                                            <i class="fas fa-infinity"></i> Sin expiración
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">
                                        {{ $user->created_at->format('d/m/Y') }}
                                        <div style="color: var(--text-muted); font-size: 0.75rem;">
                                            {{ $user->created_at->format('H:i') }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->id !== auth()->id())
                                        <div class="btn-group">
                                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline btn-sm btn-{{ $user->is_active ? 'warning' : 'success' }}" 
                                                        title="{{ $user->is_active ? 'Desactivar' : 'Activar' }}">
                                                    <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            
                                            <form method="POST" action="{{ route('admin.users.delete', $user) }}" style="display: inline;" 
                                                  onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario?\n\nEsta acción no se puede deshacer.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline btn-sm btn-danger" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="badge badge-current">
                                            <i class="fas fa-user-check"></i> Tu cuenta
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                    <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                                    <div style="font-size: 1.1rem; margin-bottom: 0.5rem;">No hay usuarios registrados</div>
                                    <div style="font-size: 0.9rem;">Crea el primer usuario para comenzar</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div style="padding: 1.5rem; border-top: 1px solid var(--border); background: var(--border-light);">
                    <div class="pagination">
                        {{ $users->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>
