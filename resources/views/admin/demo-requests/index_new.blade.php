<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestión de Solicitudes Demo - Power GYMA Admin</title>
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
        }
        
        .logo { 
            font-size: 1.5rem; 
            font-weight: 700; 
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .breadcrumb-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .breadcrumb-container a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .breadcrumb-container a:hover {
            color: var(--primary-dark);
        }
        
        .user-info { 
            display: flex; 
            align-items: center; 
            gap: 1rem; 
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
            text-decoration: none;
        }
        
        .btn-primary { 
            background: linear-gradient(135deg, var(--primary), var(--primary-dark)); 
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
        
        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text);
        }
        
        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
        
        /* Container */
        .container { 
            max-width: 1400px; 
            margin: 0 auto; 
            padding: 2rem; 
        }
        
        .page-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 1rem;
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
        
        .page-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }
        
        /* Stats cards mejoradas */
        .stats { 
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
        }
        
        .stat-card.stat-primary::before { background: var(--primary); }
        .stat-card.stat-warning::before { background: var(--warning); }
        .stat-card.stat-info::before { background: var(--info); }
        .stat-card.stat-success::before { background: var(--success); }
        .stat-card.stat-danger::before { background: var(--danger); }
        .stat-card.stat-secondary::before { background: var(--text-muted); }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
        }
        
        .stat-number { 
            font-size: 2rem; 
            font-weight: 700; 
            color: var(--text);
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        
        .stat-label { 
            color: var(--text-muted); 
            font-weight: 500;
            font-size: 0.9rem;
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
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .card-body { 
            padding: 1.5rem; 
        }
        
        /* Filtros modernos */
        .filter-section {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
        }
        
        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--text);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-control {
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            transition: all 0.2s ease;
            background: var(--card);
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .filter-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
        }
        
        /* Tabla moderna */
        .table-container {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        
        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, var(--primary-light), var(--info-light));
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .table { 
            width: 100%; 
            border-collapse: collapse;
            font-size: 0.9rem;
            margin: 0;
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
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .table tbody tr {
            transition: background-color 0.2s ease;
        }
        
        .table tbody tr:hover {
            background: var(--border-light);
        }
        
        /* Badges mejorados */
        .badge { 
            padding: 0.4rem 0.8rem; 
            border-radius: 50px; 
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.025em;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .badge-primary { background: var(--primary-light); color: var(--primary-dark); }
        .badge-warning { background: var(--warning-light); color: #92400e; }
        .badge-info { background: var(--info-light); color: #0c4a6e; }
        .badge-success { background: var(--success-light); color: #065f46; }
        .badge-danger { background: var(--danger-light); color: #991b1b; }
        .badge-secondary { background: var(--border); color: var(--text-muted); }
        
        /* Action buttons */
        .action-group {
            display: flex;
            gap: 0.25rem;
            align-items: center;
        }
        
        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        
        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }
        
        .action-btn.view { background: var(--primary-light); color: var(--primary-dark); }
        .action-btn.edit { background: var(--warning-light); color: #92400e; }
        .action-btn.delete { background: var(--danger-light); color: #991b1b; }
        
        /* Avatar */
        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.8rem;
            color: white;
        }
        
        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
        }
        
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }
        
        /* Pagination */
        .pagination-container {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border);
            background: var(--border-light);
            display: flex;
            justify-content: center;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .stats {
                grid-template-columns: 1fr;
            }
            
            .filter-grid {
                grid-template-columns: 1fr;
            }
            
            .table th, .table td {
                padding: 0.5rem;
                font-size: 0.8rem;
            }
            
            .action-group {
                flex-direction: column;
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
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal.show {
            display: flex;
        }
        
        .modal-dialog {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 500px;
            margin: 1rem;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .modal-close:hover {
            background: var(--border-light);
            color: var(--text);
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group:last-child {
            margin-bottom: 0;
        }
        
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }
        
        /* Notifications */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1100;
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 300px;
            box-shadow: var(--shadow-lg);
            animation: slideIn 0.3s ease-out;
        }
        
        .notification.success { background: var(--success); }
        .notification.error { background: var(--danger); }
        .notification.warning { background: var(--warning); }
        .notification.info { background: var(--info); }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="/Img/Ico/Ico-Pw.svg" alt="Power GYMA Logo" style="height: 40px;">
            <div>
                <div style="font-size: 1.2rem;">Power GYMA</div>
                <div class="breadcrumb-container">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i>
                    <span>Solicitudes Demo</span>
                </div>
            </div>
        </div>
        <div class="user-info">
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-outline btn-sm">
                    <i class="fas fa-sign-out-alt"></i>
                    Salir
                </button>
            </form>
        </div>
    </header>

    <div class="container fade-in">
        <div class="page-header">
            <div>
                <h1 class="page-title">Gestión de Solicitudes Demo</h1>
                <p class="page-subtitle">Administra y gestiona todas las solicitudes de demostración</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.demo-requests.export') }}" class="btn btn-success">
                    <i class="fas fa-download"></i>
                    Exportar CSV
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i>
                    Volver al Dashboard
                </a>
            </div>
        </div>

        <!-- Estadísticas mejoradas -->
        <div class="stats">
            <div class="stat-card stat-primary">
                <div class="stat-header">
                    <div class="stat-icon" style="background: var(--primary);">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $demo_requests->count() }}</div>
                <div class="stat-label">Total Solicitudes</div>
            </div>
            
            <div class="stat-card stat-warning">
                <div class="stat-header">
                    <div class="stat-icon" style="background: var(--warning);">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $demo_requests->where('estado', 'pendiente')->count() }}</div>
                <div class="stat-label">Pendientes</div>
            </div>
            
            <div class="stat-card stat-info">
                <div class="stat-header">
                    <div class="stat-icon" style="background: var(--info);">
                        <i class="fas fa-phone"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $demo_requests->where('estado', 'contactado')->count() }}</div>
                <div class="stat-label">Contactados</div>
            </div>
            
            <div class="stat-card stat-success">
                <div class="stat-header">
                    <div class="stat-icon" style="background: var(--success);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $demo_requests->where('estado', 'programado')->count() }}</div>
                <div class="stat-label">Programadas</div>
            </div>
            
            <div class="stat-card stat-danger">
                <div class="stat-header">
                    <div class="stat-icon" style="background: var(--danger);">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $demo_requests->where('estado', 'cancelado')->count() }}</div>
                <div class="stat-label">Canceladas</div>
            </div>
            
            <div class="stat-card stat-secondary">
                <div class="stat-header">
                    <div class="stat-icon" style="background: var(--text-muted);">
                        <i class="fas fa-calendar"></i>
                    </div>
                </div>
                <div class="stat-number">{{ $demo_requests->where('created_at', '>=', now()->startOfWeek())->count() }}</div>
                <div class="stat-label">Esta Semana</div>
            </div>
        </div>

        <!-- Filtros modernos -->
        <div class="filter-section">
            <div class="filter-header">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">
                    <i class="fas fa-filter"></i>
                    Filtros de Búsqueda
                </h3>
                <button class="btn btn-outline btn-sm" onclick="resetFilters()">
                    <i class="fas fa-undo"></i>
                    Limpiar Filtros
                </button>
            </div>
            
            <form method="GET" action="{{ route('admin.demo-requests.index') }}" id="filterForm">
                <div class="filter-grid">
                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-control" onchange="document.getElementById('filterForm').submit();">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="contactado" {{ request('estado') == 'contactado' ? 'selected' : '' }}>Contactado</option>
                            <option value="programado" {{ request('estado') == 'programado' ? 'selected' : '' }}>Programado</option>
                            <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                            <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tipo de Demo</label>
                        <select name="tipo_demo" class="form-control" onchange="document.getElementById('filterForm').submit();">
                            <option value="">Todos los tipos</option>
                            <option value="gimnasio" {{ request('tipo_demo') == 'gimnasio' ? 'selected' : '' }}>Gimnasio</option>
                            <option value="nutricion" {{ request('tipo_demo') == 'nutricion' ? 'selected' : '' }}>Nutrición</option>
                            <option value="ambos" {{ request('tipo_demo') == 'ambos' ? 'selected' : '' }}>Ambos</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Buscar</label>
                        <input type="text" name="search" class="form-control" 
                               value="{{ request('search') }}" 
                               placeholder="Nombre, email, teléfono, empresa..."
                               onkeypress="if(event.key === 'Enter') document.getElementById('filterForm').submit();">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Fecha Desde</label>
                        <input type="date" name="fecha_desde" class="form-control" 
                               value="{{ request('fecha_desde') }}" 
                               onchange="document.getElementById('filterForm').submit();">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Fecha Hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control" 
                               value="{{ request('fecha_hasta') }}" 
                               onchange="document.getElementById('filterForm').submit();">
                    </div>
                </div>
                
                <div class="filter-actions">
                    <span class="text-muted" style="color: var(--text-muted);">
                        Mostrando {{ $demo_requests->count() }} de {{ $demo_requests->count() }} solicitudes
                    </span>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-search"></i>
                        Buscar
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla moderna de solicitudes -->
        <div class="table-container">
            <div class="table-header">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">
                    <i class="fas fa-table"></i>
                    Lista de Solicitudes
                </h3>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <span style="color: var(--text-muted); font-size: 0.9rem;">
                        {{ $demo_requests->count() }} solicitudes encontradas
                    </span>
                </div>
            </div>
            
            <div class="table-responsive">
                @if($demo_requests->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Contacto</th>
                            <th>Empresa</th>
                            <th>Tipo Demo</th>
                            <th>Estado</th>
                            <th>Fecha Solicitud</th>
                            <th>Fecha Preferida</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($demo_requests as $request)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div class="avatar" style="background: {{ ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'][array_rand(['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'])] }};">
                                        {{ strtoupper(substr($request->nombre, 0, 1)) }}{{ strtoupper(substr($request->apellido ?? '', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600;">{{ $request->nombre }} {{ $request->apellido }}</div>
                                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $request->cargo ?? 'Sin cargo' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div style="font-size: 0.9rem;">{{ $request->email }}</div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $request->telefono }}</div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div style="font-weight: 500;">{{ $request->empresa ?? 'Sin empresa' }}</div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $request->tamaño_empresa ?? 'Tamaño no especificado' }}</div>
                                </div>
                            </td>
                            <td>
                                @if($request->tipo_demo == 'gimnasio')
                                    <span class="badge badge-primary">
                                        <i class="fas fa-dumbbell"></i>
                                        Gimnasio
                                    </span>
                                @elseif($request->tipo_demo == 'nutricion')
                                    <span class="badge badge-success">
                                        <i class="fas fa-apple-alt"></i>
                                        Nutrición
                                    </span>
                                @else
                                    <span class="badge badge-info">
                                        <i class="fas fa-star"></i>
                                        Ambos
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($request->estado == 'pendiente')
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i>
                                        Pendiente
                                    </span>
                                @elseif($request->estado == 'contactado')
                                    <span class="badge badge-info">
                                        <i class="fas fa-phone"></i>
                                        Contactado
                                    </span>
                                @elseif($request->estado == 'programado')
                                    <span class="badge badge-primary">
                                        <i class="fas fa-calendar-check"></i>
                                        Programado
                                    </span>
                                @elseif($request->estado == 'completado')
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i>
                                        Completado
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times-circle"></i>
                                        Cancelado
                                    </span>
                                @endif
                            </td>
                            <td style="font-size: 0.9rem; color: var(--text-muted);">
                                {{ $request->created_at->format('d/m/Y') }}
                                <br>
                                <small>{{ $request->created_at->format('H:i') }}</small>
                            </td>
                            <td style="font-size: 0.9rem; color: var(--text-muted);">
                                {{ $request->fecha_preferida ? \Carbon\Carbon::parse($request->fecha_preferida)->format('d/m/Y') : 'No especificada' }}
                                <br>
                                <small>{{ $request->hora_preferida ?? '--:--' }}</small>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.demo-requests.show', $request->id) }}" 
                                       class="action-btn view" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="action-btn edit" 
                                            onclick="editRequest({{ $request->id }}, '{{ $request->estado }}')" 
                                            title="Cambiar estado">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="action-btn delete" 
                                            onclick="deleteRequest({{ $request->id }})" 
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3 style="margin-bottom: 0.5rem; color: var(--text-muted);">No hay solicitudes</h3>
                    <p style="color: var(--text-light);">No se encontraron solicitudes de demo con los filtros aplicados.</p>
                    <button class="btn btn-outline" onclick="resetFilters()">
                        <i class="fas fa-undo"></i>
                        Limpiar filtros
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal para editar estado -->
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Cambiar Estado de Solicitud</h3>
                <button type="button" class="modal-close" onclick="closeModal('editModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nuevo Estado</label>
                        <select name="estado" class="form-control" id="editEstado" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="contactado">Contactado</option>
                            <option value="programado">Programado</option>
                            <option value="completado">Completado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notas (opcional)</label>
                        <textarea name="notas" class="form-control" rows="3" 
                                  placeholder="Agregar notas sobre el cambio de estado..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('editModal')">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para confirmación de eliminación -->
    <div class="modal" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Confirmar Eliminación</h3>
                <button type="button" class="modal-close" onclick="closeModal('deleteModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div style="text-align: center; padding: 2rem 0;">
                        <div style="font-size: 3rem; color: var(--danger); margin-bottom: 1rem;">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h4 style="margin-bottom: 1rem;">¿Estás seguro?</h4>
                        <p style="color: var(--text-muted);">
                            Esta acción no se puede deshacer. La solicitud de demo será eliminada permanentemente.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('deleteModal')">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                        Eliminar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Función para resetear filtros
        function resetFilters() {
            window.location.href = '{{ route("admin.demo-requests.index") }}';
        }

        // Función para abrir modal de edición
        function editRequest(id, currentEstado) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            const estadoSelect = document.getElementById('editEstado');
            
            form.action = `/admin/demo-requests/${id}`;
            estadoSelect.value = currentEstado;
            
            modal.classList.add('show');
        }

        // Función para abrir modal de eliminación
        function deleteRequest(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            
            form.action = `/admin/demo-requests/${id}`;
            
            modal.classList.add('show');
        }

        // Función para cerrar modales
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('show');
        }

        // Cerrar modales al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
            }
        });

        // Manejar tecla ESC para cerrar modales
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('.modal.show');
                modals.forEach(modal => modal.classList.remove('show'));
            }
        });

        // Mostrar notificaciones si hay mensajes
        @if(session('success'))
            showNotification('success', '{{ session('success') }}');
        @endif

        @if(session('error'))
            showNotification('error', '{{ session('error') }}');
        @endif

        // Función para mostrar notificaciones
        function showNotification(type, message) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                ${message}
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        // Auto-submit para algunos campos
        document.addEventListener('DOMContentLoaded', function() {
            // Animación fade-in para las cards
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            document.querySelectorAll('.stat-card, .card, .table-container').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
</body>
</html>