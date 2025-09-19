<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Panel de Administración') - Power GYMA</title>
    
    {{-- Favicon y PWA meta tags --}}
    @include('components.favicon')
    
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
  
  // Configuración Tailwind para modo oscuro por clase
  window.tailwind = window.tailwind || {};
  window.tailwind.config = { 
    darkMode: 'class',
    theme: {
      extend: {
        colors: {
          dark: {
            50: '#18181b',
            100: '#27272a', 
            200: '#3f3f46',
            300: '#52525b',
            400: '#71717a',
            500: '#a1a1aa',
            600: '#d4d4d8',
            700: '#e4e4e7',
            800: '#f4f4f5',
            900: '#fafafa'
          }
        }
      }
    }
  };
</script>
<script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .btn-loading {
            opacity: 0.7;
            cursor: not-allowed;
        }
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 300px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            animation: slideIn 0.3s ease-out;
        }
        .notification-success { background-color: #10b981; }
        .notification-error { background-color: #ef4444; }
        .notification-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .notification-close {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 5px;
            margin-left: 10px;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        /* Modo oscuro mejorado y más profundo */
        [data-theme="dark"] {
            --bg-primary: #0f0f0f;
            --bg-secondary: #1a1a1a;
            --bg-tertiary: #2a2a2a;
            --bg-elevated: #333333;
            --text-primary: #ffffff;
            --text-secondary: #e0e0e0;
            --text-muted: #a0a0a0;
            --border-color: #404040;
            --shadow-color: rgba(0, 0, 0, 0.5);
            --accent-blue: #3b82f6;
            --accent-green: #10b981;
            --accent-yellow: #f59e0b;
            --accent-red: #ef4444;
            --accent-purple: #8b5cf6;
        }

        [data-theme="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --bg-elevated: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --accent-blue: #2563eb;
            --accent-green: #059669;
            --accent-yellow: #d97706;
            --accent-red: #dc2626;
            --accent-purple: #7c3aed;
        }

        /* Aplicación de variables CSS */
        html[data-theme="dark"] body { 
            background-color: var(--bg-primary) !important; 
            color: var(--text-primary) !important;
        }
        
        html[data-theme="light"] body { 
            background-color: #f0f2f5 !important; 
            color: #1f2937 !important;
        }
        
        html[data-theme="dark"] .bg-white { 
            background-color: var(--bg-secondary) !important; 
            border: 1px solid var(--border-color) !important;
        }
        
        html[data-theme="light"] .bg-white { 
            background-color: #ffffff !important; 
            border: 1px solid #e5e7eb !important;
        }
        
        html[data-theme="dark"] .bg-gray-50 { 
            background-color: var(--bg-tertiary) !important; 
        }
        
        html[data-theme="light"] .bg-gray-50 { 
            background-color: #f9fafb !important; 
        }
        
        html[data-theme="dark"] .bg-gray-100 { 
            background-color: var(--bg-primary) !important; 
        }
        
        html[data-theme="light"] .bg-gray-100 { 
            background-color: #f3f4f6 !important; 
        }
        
        html[data-theme="dark"] .text-gray-900,
        html[data-theme="dark"] .text-gray-800,
        html[data-theme="dark"] .text-gray-700 { 
            color: var(--text-primary) !important; 
        }
        
        html[data-theme="dark"] .text-gray-600 { 
            color: var(--text-secondary) !important; 
        }
        
        html[data-theme="dark"] .text-gray-500 { 
            color: var(--text-muted) !important; 
        }
        
        html[data-theme="light"] .text-gray-600 { 
            color: #374151 !important; 
        }
        
        /* Mejoras en sidebar y navegación - Hover más visible */
        html[data-theme="light"] .sidebar-item:hover { 
            background-color: #dbeafe !important; /* Azul claro */
            color: #1e40af !important; /* Azul oscuro para contraste */
            border-radius: 8px;
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
            border-left: 3px solid #3b82f6;
        }
        
        html[data-theme="dark"] .sidebar-item:hover { 
            background-color: #374151 !important; 
            color: #60a5fa !important;
            border-radius: 8px;
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            border-left: 3px solid #60a5fa;
        }
        
        /* Override para elementos específicos en modo claro */
        html[data-theme="light"] .hover\\:bg-gray-200:hover { 
            background-color: #dbeafe !important; 
            color: #1e40af !important;
        }
        
        /* Estados activos y hover mejorados */
        .sidebar-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border-left: 3px solid transparent;
        }
        
        /* Hover states específicos por tema */
        [data-theme="light"] .sidebar-item:not(.active):hover {
            background-color: #dbeafe !important;
            color: #1e40af !important;
            border-left-color: #3b82f6 !important;
            transform: translateX(6px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }
        
        [data-theme="dark"] .sidebar-item:not(.active):hover {
            background-color: #374151 !important;
            color: #60a5fa !important;
            border-left-color: #60a5fa !important;
            transform: translateX(6px);
            box-shadow: 0 4px 12px rgba(96, 165, 250, 0.2);
        }
        
        /* Estado activo */
        .sidebar-item.active {
            background: linear-gradient(90deg, #3b82f6, #2563eb) !important;
            color: white !important;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.4);
            border-left-color: #60a5fa !important;
        }
        
        .sidebar-item.active::before {
            content: '';
            position: absolute;
            left: -19px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 32px;
            background: #fbbf24;
            border-radius: 0 2px 2px 0;
            box-shadow: 0 0 8px rgba(251, 191, 36, 0.6);
        }
        
        /* Botón de toggle mejorado */
        .theme-toggle {
            position: relative;
            background: var(--bg-elevated);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            overflow: hidden;
        }
        
        .theme-toggle:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px var(--shadow-color);
        }
        
        .theme-toggle::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }
        
        .theme-toggle:hover::before {
            transform: translateX(100%);
        }
        
        /* Menu móvil mejorado */
        @media (max-width: 767px) {
            .mobile-menu {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                display: flex !important;
            }
            
            .mobile-menu.open {
                transform: translateX(0);
            }
        }
        
        .mobile-overlay {
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .mobile-overlay.open {
            opacity: 1;
            visibility: visible;
        }
        
        .hamburger {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            width: 24px;
            height: 18px;
            cursor: pointer;
        }
        
        .hamburger span {
            display: block;
            height: 2px;
            width: 100%;
            background: currentColor;
            border-radius: 1px;
            transition: all 0.3s ease;
        }
        
        .hamburger.open span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        .hamburger.open span:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger.open span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        @yield('additional-styles')
</style>

@include('layouts.admin-styles-fix')
</head>
<body class="antialiased">
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Mobile Overlay -->
        <div id="mobile-overlay" class="mobile-overlay fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden" onclick="toggleMobileMenu()"></div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="mobile-menu md:transform-none fixed md:relative top-0 left-0 z-30 md:z-auto hidden md:flex flex-col w-64 h-full bg-white dark:bg-gray-800 dark:text-gray-100 shadow-lg">
            <div class="flex items-center justify-center h-20 border-b dark:border-gray-700">
                <img src="/Img/Ico/Ico-Pw.svg" alt="Power GYMA Logo" class="h-12">
            </div>
            <div class="flex flex-col flex-grow p-4">
                <nav class="flex-grow">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center px-4 py-3 text-gray-600 dark:text-gray-300 rounded-lg">
                        <i class="fas fa-tachometer-alt w-6 text-center"></i>
                        <span class="mx-4 font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="sidebar-item {{ request()->routeIs('admin.users*') ? 'active' : '' }} flex items-center px-4 py-3 mt-4 text-gray-600 dark:text-gray-300 rounded-lg">
                        <i class="fas fa-users w-6 text-center"></i>
                        <span class="mx-4 font-medium">Usuarios</span>
                    </a>
                    <a href="{{ route('admin.demo-requests.index') }}" class="sidebar-item {{ request()->routeIs('admin.demo-requests*') ? 'active' : '' }} flex items-center px-4 py-3 mt-4 text-gray-600 dark:text-gray-300 rounded-lg">
                        <i class="fas fa-clipboard-list w-6 text-center"></i>
                        <span class="mx-4 font-medium">Solicitudes Demo</span>
                        @php
                            $pendingDemos = \App\Models\DemoRequest::where('estado', 'pendiente')->count();
                        @endphp
                        @if($pendingDemos > 0)
                            <span class="ml-auto text-xs font-semibold text-white bg-red-500 rounded-full w-5 h-5 flex items-center justify-center">{{ $pendingDemos }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.excel.index') }}" class="sidebar-item {{ request()->routeIs('admin.excel*') ? 'active' : '' }} flex items-center px-4 py-3 mt-4 text-gray-600 dark:text-gray-300 rounded-lg">
                        <i class="fas fa-file-excel w-6 text-center"></i>
                        <span class="mx-4 font-medium">Gestión Excel</span>
                    </a>
                </nav>
                <div class="mt-auto">
                     <a href="{{ route('admin.users.create') }}" class="block w-full text-center py-3 px-4 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200">
                        <i class="fas fa-user-plus mr-2"></i>
                        Crear Usuario
                    </a>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-y-auto">
            <header class="flex items-center justify-between h-20 px-6 bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                <div class="flex items-center">
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="hamburger mr-4 text-gray-600 dark:text-gray-300 md:hidden" onclick="toggleMobileMenu()" aria-label="Menú de navegación">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">@yield('page-title', 'Panel de Administración')</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">@yield('page-description', 'Gestiona y administra el sistema Power GYMA')</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <button id="theme-toggle" class="theme-toggle mr-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" onclick="toggleTheme()" aria-label="Cambiar tema" title="Cambiar tema">
                        <div class="flex items-center justify-center w-6 h-6 relative">
                            <span id="light-icon" class="absolute transition-all duration-300 transform">
                                <i class="fas fa-moon text-gray-600 dark:text-gray-400 text-lg"></i>
                            </span>
                            <span id="dark-icon" class="absolute transition-all duration-300 transform opacity-0 rotate-180">
                                <i class="fas fa-sun text-yellow-500 text-lg"></i>
                            </span>
                        </div>
                    </button>
                    <div class="relative">
                        <button class="flex items-center text-left focus:outline-none" onclick="document.getElementById('user-menu').classList.toggle('hidden')">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Administrador</p>
                            </div>
                        </button>
                        <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl hidden z-10">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Salir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-6 sm:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Funciones del tema y menú móvil
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

        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            const hamburger = document.getElementById('mobile-menu-btn');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
            hamburger.classList.toggle('open');
            
            if (sidebar.classList.contains('open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        // Inicializar tema al cargar
        document.addEventListener('DOMContentLoaded', function() {
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
        });

        // Cerrar menús al hacer clic fuera
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('#user-menu');
            const userButton = document.querySelector('[onclick*="user-menu"]');
            
            if (!userButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });

        // Cerrar menú móvil al cambiar tamaño
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('mobile-overlay');
                const hamburger = document.getElementById('mobile-menu-btn');
                
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
                hamburger.classList.remove('open');
                document.body.style.overflow = '';
            }
        });

        @yield('additional-scripts')
    </script>
</body>
</html>