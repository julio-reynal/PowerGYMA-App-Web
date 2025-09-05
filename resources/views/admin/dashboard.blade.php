<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Panel de Administración - Power GYMA</title>
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
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(59, 130, 246, 0.05));
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }
        
        .user-avatar {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
        }
        
        /* Botones mejorados */
        .btn { 
            padding: 0.75rem 1.5rem; 
            border-radius: var(--radius-sm); 
            text-decoration: none; 
            font-weight: 500; 
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
            box-shadow: var(--shadow-lg);
        }
        
        .btn-primary { 
            background: linear-gradient(135deg, var(--primary), var(--primary-dark)); 
            color: white; 
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
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
        
        .btn-info {
            background: linear-gradient(135deg, var(--info), #0891b2);
            color: white;
        }
        
        /* Container responsivo */
        .container { 
            max-width: 1400px; 
            margin: 2rem auto; 
            padding: 0 2rem; 
        }
        
        .page-header {
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--info));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
        }
        
        .page-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
            margin-top: 0.5rem;
        }
        
        /* Stats cards mejoradas */
        .stats { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
            gap: 1.5rem; 
            margin-bottom: 2rem; 
        }
        
        .stat-card { 
            background: var(--card); 
            padding: 2rem; 
            border-radius: var(--radius); 
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--info));
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        
        .stat-number { 
            font-size: 2.5rem; 
            font-weight: 700; 
            color: var(--text);
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        
        .stat-label { 
            color: var(--text-muted); 
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .stat-change {
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 0.5rem;
        }
        
        .stat-change.positive {
            color: var(--success);
        }
        
        .stat-change.negative {
            color: var(--danger);
        }
        
        /* Cards mejoradas */
        .card { 
            background: var(--card); 
            border-radius: var(--radius); 
            border: 1px solid var(--border); 
            overflow: hidden;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }
        
        .card-header { 
            padding: 1.5rem; 
            border-bottom: 1px solid var(--border); 
            font-weight: 600;
            font-size: 1.1rem;
            background: linear-gradient(135deg, var(--primary-light), var(--info-light));
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-body { 
            padding: 1.5rem; 
        }
        
        /* Tabla moderna */
        .table-container {
            overflow-x: auto;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
        }
        
        .table { 
            width: 100%; 
            border-collapse: collapse;
            font-size: 0.9rem;
        }
        
        .table th, .table td { 
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
        
        /* Badges mejorados */
        .badge { 
            padding: 0.4rem 0.8rem; 
            border-radius: 50px; 
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.025em;
        }
        
        .badge-admin { background: var(--primary-light); color: var(--primary-dark); }
        .badge-cliente { background: var(--success-light); color: #065f46; }
        .badge-demo { background: var(--warning-light); color: #92400e; }
        .badge-active { background: var(--success-light); color: #065f46; }
        .badge-inactive { background: var(--danger-light); color: #991b1b; }
        
        /* Progress bar */
        .progress-container {
            background: var(--border-light);
            height: 12px;
            border-radius: 6px;
            overflow: hidden;
            position: relative;
        }
        
        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--success), var(--info));
            border-radius: 6px;
            transition: width 0.6s ease;
            position: relative;
        }
        
        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        /* Action buttons container */
        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }
        
        /* Grid de contenido */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }
        
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }
            
            .user-info {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .container {
                padding: 0 1rem;
            }
            
            .stats {
                grid-template-columns: 1fr;
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
        
        /* Efectos hover para cards */
        .hoverable {
            transition: all 0.3s ease;
        }
        
        .hoverable:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
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
            <a href="{{ route('admin.excel.index') }}" class="btn btn-info">
                <i class="fas fa-file-excel"></i>
                Gestión Excel
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                <i class="fas fa-user-plus"></i>
                Crear Usuario
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
            <h1 class="page-title">Dashboard de Administración</h1>
            <p class="page-subtitle">Panel de control completo para la gestión de Power GYMA</p>
        </div>
        
        <!-- Estadísticas de Usuarios -->
        <div class="stats">
            <div class="stat-card hoverable">
                <div class="stat-header">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark));">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Total de Usuarios</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> +12% este mes
                </div>
            </div>
            
            <div class="stat-card hoverable">
                <div class="stat-header">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--success), #059669);">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $stats['admins'] }}</div>
                <div class="stat-label">Administradores</div>
                <div class="stat-change">
                    <i class="fas fa-minus"></i> Sin cambios
                </div>
            </div>
            
            <div class="stat-card hoverable">
                <div class="stat-header">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--info), #0891b2);">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $stats['clientes'] }}</div>
                <div class="stat-label">Clientes Activos</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> +8% este mes
                </div>
            </div>
            
            <div class="stat-card hoverable">
                <div class="stat-header">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--warning), #d97706);">
                        <i class="fas fa-user-clock"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $stats['demos'] }}</div>
                <div class="stat-label">Usuarios Demo</div>
                <div class="stat-change {{ $stats['expired_demos'] > 0 ? 'negative' : 'positive' }}">
                    @if($stats['expired_demos'] > 0)
                        <i class="fas fa-exclamation-triangle"></i> {{ $stats['expired_demos'] }} expirados
                    @else
                        <i class="fas fa-check"></i> Todos activos
                    @endif
                </div>
            </div>
        </div>

        <!-- Estadísticas de Datos de Riesgo -->
        <div class="stats">
            <div class="stat-card hoverable">
                <div class="stat-header">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--primary), var(--info));">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $data_stats['evaluations_today'] ?? 0 }}</div>
                <div class="stat-label">Evaluaciones Hoy</div>
                <div class="stat-change {{ ($data_stats['evaluations_today'] ?? 0) > 0 ? 'positive' : 'negative' }}">
                    @if(($data_stats['evaluations_today'] ?? 0) > 0)
                        <i class="fas fa-check-circle"></i> Evaluado
                    @else
                        <i class="fas fa-clock"></i> Pendiente
                    @endif
                </div>
            </div>
            
            <div class="stat-card hoverable">
                <div class="stat-header">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--success), var(--info));">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $data_stats['monthly_entries'] ?? 0 }}</div>
                <div class="stat-label">Datos del Mes</div>
                <div class="stat-change positive">
                    <i class="fas fa-database"></i> Base de datos
                </div>
            </div>
            
            <div class="stat-card hoverable">
                <div class="stat-header">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--danger), #dc2626);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $data_stats['high_risk_days'] ?? 0 }}</div>
                <div class="stat-label">Días de Alto Riesgo</div>
                <div class="stat-change {{ ($data_stats['high_risk_days'] ?? 0) > 0 ? 'negative' : 'positive' }}">
                    @if(($data_stats['high_risk_days'] ?? 0) > 0)
                        <i class="fas fa-bell"></i> Requiere atención
                    @else
                        <i class="fas fa-shield-check"></i> Todo seguro
                    @endif
                </div>
            </div>
            
            <div class="stat-card hoverable">
                <div class="stat-header">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--warning), #d97706);">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $data_stats['pending_days'] ?? 0 }}</div>
                <div class="stat-label">Días Pendientes</div>
                <div class="stat-change {{ ($data_stats['pending_days'] ?? 0) > 0 ? 'negative' : 'positive' }}">
                    @if(($data_stats['pending_days'] ?? 0) > 0)
                        <i class="fas fa-tasks"></i> Por procesar
                    @else
                        <i class="fas fa-check-double"></i> Todo al día
                    @endif
                </div>
            </div>
            
            <div class="stat-card hoverable">
                <div class="stat-header">
                    <div class="stat-icon" style="background: linear-gradient(135deg, var(--info), #0891b2);">
                        <i class="fas fa-file-upload"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $data_stats['excel_uploads'] ?? 0 }}</div>
                <div class="stat-label">Archivos Subidos</div>
                <div class="stat-change positive">
                    <i class="fas fa-cloud-upload-alt"></i> Almacenados
                </div>
            </div>
        </div>

        <div class="content-grid">
            <!-- Usuarios Recientes -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <i class="fas fa-users-cog"></i>
                        Usuarios Recientes
                    </div>
                    <span class="badge badge-info">{{ count($recent_users) }} usuarios</span>
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-user"></i> Usuario</th>
                                    <th><i class="fas fa-envelope"></i> Email</th>
                                    <th><i class="fas fa-user-tag"></i> Rol</th>
                                    <th><i class="fas fa-toggle-on"></i> Estado</th>
                                    <th><i class="fas fa-calendar-plus"></i> Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_users as $user)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <strong>{{ $user->name }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge badge-{{ $user->role }}">
                                            <i class="fas fa-{{ $user->role === 'admin' ? 'user-shield' : ($user->role === 'cliente' ? 'user-check' : 'user-clock') }}"></i>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->isActiveAndNotExpired())
                                            <span class="badge badge-active">
                                                <i class="fas fa-check-circle"></i> Activo
                                            </span>
                                        @else
                                            <span class="badge badge-inactive">
                                                <i class="fas fa-times-circle"></i> Inactivo
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="{{ route('admin.users') }}" class="btn btn-primary">
                            <i class="fas fa-list"></i>
                            Ver Todos los Usuarios
                        </a>
                        <a href="{{ route('admin.demo.create') }}" class="btn btn-warning">
                            <i class="fas fa-user-plus"></i>
                            Crear Usuario Demo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sistema de Riesgo -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <i class="fas fa-shield-alt"></i>
                        Sistema de Riesgo
                    </div>
                    <span class="badge badge-primary">Estado actual</span>
                </div>
                <div class="card-body">
                    <?php 
                        $currentEval = \App\Models\RiskEvaluation::today();
                        $lastEval = \App\Models\RiskEvaluation::latest('evaluation_date')->first();
                        $monthlyComplete = \App\Models\MonthlyRiskData::where('year', now()->year)
                                                                       ->where('month', now()->month)
                                                                       ->where('status', 'evaluado')
                                                                       ->count();
                        $monthlyTotal = \App\Models\MonthlyRiskData::where('year', now()->year)
                                                                    ->where('month', now()->month)
                                                                    ->count();
                        $progressPercent = $monthlyTotal > 0 ? round(($monthlyComplete / $monthlyTotal) * 100) : 0;
                    ?>
                    
                    <!-- Evaluación del Día -->
                    <div style="padding: 1.5rem; margin-bottom: 1.5rem; border: 2px solid var(--border); border-radius: var(--radius); background: linear-gradient(135deg, var(--card), var(--border-light));">
                        <h4 style="margin-top: 0; color: var(--primary); display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-calendar-check"></i>
                            Evaluación del Día Actual
                        </h4>
                        @if($currentEval)
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                <span class="badge" style="background: 
                                    @if($currentEval->risk_level == 'Alto' || $currentEval->risk_level == 'Crítico') var(--danger)
                                    @elseif($currentEval->risk_level == 'Moderado') var(--warning)
                                    @else var(--success) @endif; color: white; font-size: 1rem; padding: 0.5rem 1rem;">
                                    <i class="fas fa-{{ $currentEval->risk_level == 'Alto' || $currentEval->risk_level == 'Crítico' ? 'exclamation-triangle' : ($currentEval->risk_level == 'Moderado' ? 'exclamation-circle' : 'check-circle') }}"></i>
                                    {{ $currentEval->risk_level }}
                                </span>
                            </div>
                            @if($currentEval->start_time && $currentEval->end_time)
                                <p><i class="fas fa-clock"></i> <strong>Horario:</strong> {{ $currentEval->start_time }} - {{ $currentEval->end_time }}</p>
                            @endif
                            <p><i class="fas fa-calendar"></i> <strong>Fecha:</strong> {{ $currentEval->evaluation_date->format('d/m/Y') }}</p>
                        @else
                            <div style="padding: 1rem; background: var(--warning-light); border-radius: var(--radius-sm); color: var(--warning); margin-bottom: 1rem;">
                                <i class="fas fa-exclamation-triangle"></i> No hay evaluación para hoy
                            </div>
                            <small style="color: var(--text-muted);">
                                <i class="fas fa-history"></i> Última evaluación: {{ $lastEval ? $lastEval->evaluation_date->format('d/m/Y') : 'Ninguna' }}
                            </small>
                        @endif
                    </div>

                    <!-- Progreso Mensual -->
                    <div style="padding: 1.5rem; border: 2px solid var(--border); border-radius: var(--radius); background: linear-gradient(135deg, var(--card), var(--border-light));">
                        <h4 style="margin-top: 0; color: var(--primary); display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-chart-pie"></i>
                            Progreso del Mes
                        </h4>
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <div style="flex: 1;">
                                <div class="progress-container">
                                    <div class="progress-bar" style="width: {{ $progressPercent }}%;"></div>
                                </div>
                            </div>
                            <span style="font-weight: bold; font-size: 1.1rem;">{{ $monthlyComplete }}/{{ $monthlyTotal }}</span>
                        </div>
                        <p style="margin: 0; font-size: 0.9rem; color: var(--text-muted);">
                            <i class="fas fa-percentage"></i> {{ $progressPercent }}% del mes completado
                        </p>
                    </div>

                    <!-- Acciones Rápidas -->
                    <div class="action-buttons">
                        <a href="{{ route('admin.excel.index') }}" class="btn btn-primary">
                            <i class="fas fa-file-excel"></i>
                            Gestionar Excel
                        </a>
                        <a href="{{ route('admin.excel.template') }}" class="btn btn-success">
                            <i class="fas fa-download"></i>
                            Descargar Plantilla
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Animaciones y efectos interactivos
        document.addEventListener('DOMContentLoaded', function() {
            // Animar contadores
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(stat => {
                const finalValue = parseInt(stat.textContent);
                let currentValue = 0;
                const increment = finalValue / 30;
                
                const timer = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= finalValue) {
                        stat.textContent = finalValue;
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.floor(currentValue);
                    }
                }, 50);
            });
            
            // Efecto de hover para las tarjetas
            const hoverableCards = document.querySelectorAll('.hoverable');
            hoverableCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });
    </script>
</body>
</html>
