<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Panel de Administración') - Power GYMA</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --bg-primary: #f8fafc;
            --text-primary: #0f172a;
            --primary-color: #1d4ed8;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --border-color: #e2e8f0;
            --card-bg: #ffffff;
            --navbar-bg: #1e293b;
            --sidebar-bg: #334155;
        }

        body {
            background-color: var(--bg-primary);
            font-family: 'Figtree', sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #ffffff !important;
        }

        .navbar-dark {
            background-color: var(--navbar-bg) !important;
        }

        .navbar-nav .nav-link {
            color: #cbd5e1 !important;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            color: #ffffff !important;
        }

        .main-content {
            min-height: calc(100vh - 76px);
            padding-top: 2rem;
        }

        .card {
            border: none;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s ease;
        }
        
        .card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .card-header {
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(241, 245, 249, 0.8) 100%);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            font-weight: 600;
            border-radius: 12px 12px 0 0;
            padding: 1rem 1.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-title {
            margin-bottom: 0.5rem;
            color: #1e293b;
            font-weight: 600;
        }
        
        .card-text {
            color: #64748b;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #1e40af;
            border-color: #1e40af;
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .alert {
            border: none;
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
        }
        
        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: #1e40af;
        }
        
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #15803d;
        }
        
        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.2);
            color: #d97706;
        }
        
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #dc2626;
        }
        
        .table {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table th {
            background: rgba(248, 250, 252, 0.8);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            font-weight: 600;
            color: #475569;
            padding: 1rem;
        }
        
        .table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.3);
        }
        
        .table-hover tbody tr:hover {
            background: rgba(241, 245, 249, 0.5);
        }
        
        /* Stats Cards */
        .stats-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
            border: 1px solid rgba(226, 232, 240, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        }
        
        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .stats-card .icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .stats-card .number {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }
        
        .stats-card .label {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
        }
        }

        .form-label {
            font-weight: 600;
            color: #374151;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(29, 78, 216, 0.25);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
            background-color: #f8fafc;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: #6b7280;
        }

        /* Loading Spinner */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation moderno -->
    <header style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); 
                   border-bottom: 1px solid #e2e8f0; 
                   padding: 1rem 2rem; 
                   display: flex; 
                   justify-content: space-between; 
                   align-items: center;
                   box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                   position: sticky;
                   top: 0;
                   z-index: 50;
                   backdrop-filter: blur(10px);
                   border-radius: 0 0 16px 16px;">
        <div style="font-size: 1.5rem; 
                    font-weight: 700; 
                    color: #3b82f6;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    transition: all 0.3s ease;">
            <img src="/Img/Ico/Ico-Pw.svg" alt="Power GYMA Logo" style="height: 48px;">
            <span style="font-size: 0.8rem; font-weight: 500; color: #3b82f6; background: #dbeafe; padding: 0.25rem 0.5rem; border-radius: 4px; margin-left: 0.5rem;">Admin</span>
        </div>
        <div style="display: flex; 
                    align-items: center; 
                    gap: 1rem; 
                    flex-wrap: wrap;">
            <div style="display: flex;
                       align-items: center;
                       gap: 0.75rem;
                       padding: 0.75rem 1.25rem;
                       background: linear-gradient(135deg, #dbeafe, rgba(59, 130, 246, 0.1));
                       border-radius: 12px;
                       font-weight: 500;
                       border: 1px solid rgba(59, 130, 246, 0.2);
                       transition: all 0.3s ease;">
                <div style="width: 2.5rem;
                           height: 2.5rem;
                           background: linear-gradient(135deg, #3b82f6, #2563eb);
                           border-radius: 50%;
                           display: flex;
                           align-items: center;
                           justify-content: center;
                           color: white;
                           font-weight: 600;
                           font-size: 0.875rem;
                           box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <a href="{{ route('admin.dashboard') }}" style="padding: 0.75rem 1.5rem; 
                                                           border-radius: 8px; 
                                                           text-decoration: none; 
                                                           font-weight: 600; 
                                                           border: none; 
                                                           cursor: pointer;
                                                           display: inline-flex;
                                                           align-items: center;
                                                           gap: 0.5rem;
                                                           transition: all 0.2s ease;
                                                           font-size: 0.9rem;
                                                           background: linear-gradient(135deg, #06b6d4, #0891b2);
                                                           color: white;">
                <i class="fas fa-chart-pie"></i>
                Dashboard
            </a>
            <a href="{{ route('admin.excel.index') }}" style="padding: 0.75rem 1.5rem; 
                                                             border-radius: 8px; 
                                                             text-decoration: none; 
                                                             font-weight: 600; 
                                                             border: none; 
                                                             cursor: pointer;
                                                             display: inline-flex;
                                                             align-items: center;
                                                             gap: 0.5rem;
                                                             transition: all 0.2s ease;
                                                             font-size: 0.9rem;
                                                             background: linear-gradient(135deg, #06b6d4, #0891b2);
                                                             color: white;">
                <i class="fas fa-file-excel"></i>
                Gestión Excel
            </a>
            <a href="{{ route('admin.users.create') }}" style="padding: 0.75rem 1.5rem; 
                                                              border-radius: 8px; 
                                                              text-decoration: none; 
                                                              font-weight: 600; 
                                                              border: none; 
                                                              cursor: pointer;
                                                              display: inline-flex;
                                                              align-items: center;
                                                              gap: 0.5rem;
                                                              transition: all 0.2s ease;
                                                              font-size: 0.9rem;
                                                              background: linear-gradient(135deg, #10b981, #059669);
                                                              color: white;">
                <i class="fas fa-user-plus"></i>
                Crear Usuario
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="padding: 0.75rem 1.5rem; 
                                           border-radius: 8px; 
                                           text-decoration: none; 
                                           font-weight: 600; 
                                           border: none; 
                                           cursor: pointer;
                                           display: inline-flex;
                                           align-items: center;
                                           gap: 0.5rem;
                                           transition: all 0.2s ease;
                                           font-size: 0.9rem;
                                           background: linear-gradient(135deg, #ef4444, #dc2626);
                                           color: white;">
                    <i class="fas fa-sign-out-alt"></i>
                    Salir
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });

        // Confirm delete actions
        function confirmDelete(message = '¿Estás seguro de que quieres eliminar este elemento?') {
            return confirm(message);
        }

        // Loading state for buttons
        function setButtonLoading(button, loading = true) {
            if (loading) {
                button.disabled = true;
                const originalText = button.innerHTML;
                button.setAttribute('data-original-text', originalText);
                button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';
            } else {
                button.disabled = false;
                const originalText = button.getAttribute('data-original-text');
                if (originalText) {
                    button.innerHTML = originalText;
                }
            }
        }
    </script>
    
    @stack('scripts')
</body>
</html>
