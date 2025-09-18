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

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pendientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['pendientes'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Contactados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['contactados'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-phone fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Programados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['programados'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['completados'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Últimos 7 días</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['recientes'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.demo-requests.index') }}" class="row">
                <div class="col-md-3 mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="">Todos los estados</option>
                        @foreach(\App\Models\DemoRequest::ESTADOS as $key => $label)
                            <option value="{{ $key }}" {{ request('estado') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="tipo_demo" class="form-label">Tipo de Demo</label>
                    <select name="tipo_demo" id="tipo_demo" class="form-control">
                        <option value="">Todos los tipos</option>
                        @foreach(\App\Models\DemoRequest::TIPOS_DEMO as $key => $label)
                            <option value="{{ $key }}" {{ request('tipo_demo') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           value="{{ request('search') }}" placeholder="Nombre, email, empresa o RUC">
                </div>

                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('admin.demo-requests.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTable -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Solicitudes de Demo ({{ $solicitudes->total() }} registros)
            </h6>
        </div>
        <div class="card-body">
            @if($solicitudes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Empresa</th>
                                <th>Tipo Demo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($solicitudes as $solicitud)
                                <tr>
                                    <td>{{ $solicitud->id }}</td>
                                    <td>
                                        <small>{{ $solicitud->created_at->format('d/m/Y') }}</small><br>
                                        <small class="text-muted">{{ $solicitud->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $solicitud->nombre }}</strong><br>
                                        <small class="text-muted">{{ $solicitud->telefono_celular ?: $solicitud->telefono }}</small>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $solicitud->email }}" class="text-decoration-none">
                                            {{ $solicitud->email }}
                                        </a>
                                    </td>
                                    <td>
                                        <strong>{{ $solicitud->empresa }}</strong><br>
                                        @if($solicitud->ruc_empresa)
                                            <small class="text-muted">RUC: {{ $solicitud->ruc_empresa }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $solicitud->tipo_demo_label }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = match($solicitud->estado) {
                                                'pendiente' => 'warning',
                                                'contactado' => 'info',
                                                'programado' => 'secondary',
                                                'completado' => 'success',
                                                'rechazado' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge badge-{{ $badgeClass }}">{{ $solicitud->estado_label }}</span>
                                        
                                        @if($solicitud->fecha_demo_programada)
                                            <br><small class="text-muted">
                                                Demo: {{ $solicitud->fecha_demo_programada->format('d/m/Y H:i') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.demo-requests.show', $solicitud) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <button type="button" class="btn btn-sm btn-outline-warning" 
                                                    data-bs-toggle="modal" data-bs-target="#estadoModal{{ $solicitud->id }}"
                                                    title="Cambiar estado">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <form action="{{ route('admin.demo-requests.destroy', $solicitud) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de eliminar esta solicitud?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal para cambiar estado -->
                                <div class="modal fade" id="estadoModal{{ $solicitud->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Actualizar Estado - {{ $solicitud->nombre }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.demo-requests.update-estado', $solicitud) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="estado{{ $solicitud->id }}" class="form-label">Estado</label>
                                                        <select name="estado" id="estado{{ $solicitud->id }}" class="form-control" required>
                                                            @foreach(\App\Models\DemoRequest::ESTADOS as $key => $label)
                                                                <option value="{{ $key }}" {{ $solicitud->estado == $key ? 'selected' : '' }}>
                                                                    {{ $label }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="fecha_demo_programada{{ $solicitud->id }}" class="form-label">
                                                            Fecha del Demo (solo para estado "Programado")
                                                        </label>
                                                        <input type="datetime-local" 
                                                               name="fecha_demo_programada" 
                                                               id="fecha_demo_programada{{ $solicitud->id }}" 
                                                               class="form-control"
                                                               value="{{ $solicitud->fecha_demo_programada?->format('Y-m-d\TH:i') }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="notas_internas{{ $solicitud->id }}" class="form-label">Notas Internas</label>
                                                        <textarea name="notas_internas" 
                                                                  id="notas_internas{{ $solicitud->id }}" 
                                                                  class="form-control" 
                                                                  rows="4">{{ $solicitud->notas_internas }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $solicitudes->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500">No se encontraron solicitudes de demo con los filtros aplicados.</p>
                    <a href="{{ route('admin.demo-requests.index') }}" class="btn btn-primary">Ver todas las solicitudes</a>
                </div>
            @endif
        </div>
    </div>
</div>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            alert('{{ session('success') }}');
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            alert('{{ session('error') }}');
        });
    </script>
@endif
@endsection