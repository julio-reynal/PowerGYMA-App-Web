<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Panel de Administración') - Power GYMA Admin</title>
    <script>
  // Inicialización de tema mejorada (por defecto: oscuro)
  (function() {
    try {
      const stored = localStorage.getItem('admin-theme');
      const isDark = stored ? stored === 'dark' : true;
      
      if (isDark) {
        document.documentElement.classList.add('dark');
        document.documentElement.setAttribute('data-theme', 'dark');
      } else {
        document.documentElement.classList.remove('dark');
        document.documentElement.setAttribute('data-theme', 'light');
      }
      
      document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';
    } catch (e) {
      document.documentElement.classList.add('dark');
      document.documentElement.setAttribute('data-theme', 'dark');
      document.documentElement.style.colorScheme = 'dark';
    }
  })();
</script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Variables base por defecto (tema claro) */
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

        /* Override para tema oscuro */
        html[data-theme="dark"] { 
            --bg: #0f0f0f; 
            --bg-secondary: #1a1a1a;
            --text: #ffffff; 
            --text-muted: #a0a0a0;
            --text-light: #d0d0d0;
            --primary-light: rgba(59, 130, 246, 0.2);
            --success-light: rgba(16, 185, 129, 0.2);
            --warning-light: rgba(245, 158, 11, 0.2);
            --danger-light: rgba(239, 68, 68, 0.2);
            --info-light: rgba(6, 182, 212, 0.2);
            --border: #404040;
            --border-light: #2a2a2a;
            --card: #1a1a1a;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.5), 0 1px 2px 0 rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.5), 0 4px 6px -2px rgba(0, 0, 0, 0.3);
        }
        
        * { box-sizing: border-box; }
        
        html, body { 
            height: 100%; 
            margin: 0; 
            background: var(--bg); 
            color: var(--text); 
            font-family: 'Inter', system-ui, sans-serif; 
            line-height: 1.6;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Layout principal */
        .admin-layout {
            display: flex;
            min-height: 100vh;
            background: var(--bg);
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--card);
            border-right: 1px solid var(--border);
            box-shadow: var(--shadow);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 50;
            transition: all 0.3s ease;
        }

        .sidebar-mobile {
            transform: translateX(-100%);
        }

        .sidebar-mobile.open {
            transform: translateX(0);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            background: var(--primary-light);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }

        .sidebar-nav {
            padding: 1rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: var(--radius-sm);
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-left-color: var(--primary);
            transform: translateX(4px);
        }

        .nav-item.active {
            background: var(--primary);
            color: white;
            border-left-color: var(--primary-dark);
        }

        .nav-item i {
            width: 20px;
            text-align: center;
        }

        /* Main content area */
        .main-content {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header { 
            background: var(--card); 
            border-bottom: 1px solid var(--border); 
            padding: 1rem 2rem; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text);
            cursor: pointer;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text);
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Theme toggle */
        .theme-toggle {
            position: relative;
            background: var(--card);
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            overflow: hidden;
        }
        
        .theme-toggle:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        /* User menu */
        .user-menu {
            position: relative;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: var(--primary-light);
            border-radius: var(--radius);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-info:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .user-avatar {
            width: 2rem;
            height: 2rem;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            min-width: 200px;
            z-index: 50;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .user-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text);
            text-decoration: none;
            transition: background 0.2s ease;
        }

        .dropdown-item:hover {
            background: var(--border-light);
        }

        /* Content area */
        .content {
            flex: 1;
            padding: 2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block;
            }

            .content {
                padding: 1rem;
            }
        }

        /* Overlay para móvil */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 45;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Botones comunes */
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

        /* Badge con notificación */
        .nav-badge {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 1.25rem;
            height: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
        }

        @yield('additional-styles')
    </style>
</head>
<body>
    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="mobile-overlay" onclick="toggleMobileMenu()"></div>

    <div class="admin-layout">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <img src="/Img/Ico/Ico-Pw.svg" alt="Power GYMA Logo" style="height: 32px;">
                    <span>Power GYMA</span>
                </div>
            </div>
            
            <div class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Usuarios</span>
                </a>
                
                <a href="{{ route('admin.demo-requests.index') }}" class="nav-item {{ request()->routeIs('admin.demo-requests*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Solicitudes Demo</span>
                    @if(isset($pendingDemos) && $pendingDemos > 0)
                        <span class="nav-badge">{{ $pendingDemos }}</span>
                    @endif
                </a>
                
                <a href="{{ route('admin.excel.index') }}" class="nav-item {{ request()->routeIs('admin.excel*') ? 'active' : '' }}">
                    <i class="fas fa-file-excel"></i>
                    <span>Gestión Excel</span>
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <button id="mobile-menu-btn" class="mobile-menu-btn" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">@yield('page-title', 'Panel de Administración')</h1>
                </div>
                
                <div class="header-right">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="theme-toggle" onclick="toggleTheme()" aria-label="Cambiar tema" title="Cambiar tema">
                        <div style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; position: relative;">
                            <span id="light-icon" style="position: absolute; transition: all 0.3s;">
                                <i class="fas fa-moon" style="color: var(--text-muted);"></i>
                            </span>
                            <span id="dark-icon" style="position: absolute; transition: all 0.3s; opacity: 0; transform: rotate(180deg);">
                                <i class="fas fa-sun" style="color: #f59e0b;"></i>
                            </span>
                        </div>
                    </button>

                    <!-- User Menu -->
                    <div class="user-menu">
                        <div class="user-info" onclick="toggleUserMenu()">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <span>{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
                        </div>
                        
                        <div id="user-dropdown" class="user-dropdown">
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                <i class="fas fa-chart-pie"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('admin.users.create') }}" class="dropdown-item">
                                <i class="fas fa-user-plus"></i>
                                <span>Crear Usuario</span>
                            </a>
                            <hr style="margin: 0.5rem 0; border: none; border-top: 1px solid var(--border);">
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="dropdown-item" style="width: 100%; background: none; border: none; text-align: left;">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Cerrar Sesión</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Inicializar tema al cargar
        document.addEventListener('DOMContentLoaded', function() {
            updateThemeToggleIcons();
        });

        // Toggle de tema
        function toggleTheme() {
            try {
                const html = document.documentElement;
                const isDark = html.classList.contains('dark');
                const lightIcon = document.getElementById('light-icon');
                const darkIcon = document.getElementById('dark-icon');
                
                if (isDark) {
                    darkIcon.style.opacity = '0';
                    darkIcon.style.transform = 'rotate(180deg) scale(0.5)';
                    
                    setTimeout(() => {
                        html.classList.remove('dark');
                        html.setAttribute('data-theme', 'light');
                        html.style.colorScheme = 'light';
                        
                        lightIcon.style.opacity = '1';
                        lightIcon.style.transform = 'rotate(0deg) scale(1)';
                    }, 150);
                } else {
                    lightIcon.style.opacity = '0';
                    lightIcon.style.transform = 'rotate(-180deg) scale(0.5)';
                    
                    setTimeout(() => {
                        html.classList.add('dark');
                        html.setAttribute('data-theme', 'dark');
                        html.style.colorScheme = 'dark';
                        
                        darkIcon.style.opacity = '1';
                        darkIcon.style.transform = 'rotate(0deg) scale(1)';
                    }, 150);
                }
                
                localStorage.setItem('admin-theme', isDark ? 'light' : 'dark');
            } catch (e) {
                console.error('Error al cambiar tema:', e);
            }
        }

        function updateThemeToggleIcons() {
            try {
                const isDark = document.documentElement.classList.contains('dark');
                const lightIcon = document.getElementById('light-icon');
                const darkIcon = document.getElementById('dark-icon');
                
                if (isDark) {
                    lightIcon.style.opacity = '0';
                    lightIcon.style.transform = 'rotate(-180deg) scale(0.5)';
                    darkIcon.style.opacity = '1';
                    darkIcon.style.transform = 'rotate(0deg) scale(1)';
                } else {
                    lightIcon.style.opacity = '1';
                    lightIcon.style.transform = 'rotate(0deg) scale(1)';
                    darkIcon.style.opacity = '0';
                    darkIcon.style.transform = 'rotate(180deg) scale(0.5)';
                }
            } catch (e) {
                console.error('Error al actualizar iconos:', e);
            }
        }

        // Toggle menú móvil
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
            
            if (sidebar.classList.contains('open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        // Toggle menú usuario
        function toggleUserMenu() {
            const dropdown = document.getElementById('user-dropdown');
            dropdown.classList.toggle('show');
        }

        // Cerrar menús al hacer clic fuera
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu');
            const userDropdown = document.getElementById('user-dropdown');
            
            if (!userMenu.contains(event.target)) {
                userDropdown.classList.remove('show');
            }
        });

        // Cerrar menú móvil al cambiar tamaño
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('mobile-overlay');
                
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        });

        @yield('additional-scripts')
    </script>
</body>
</html>