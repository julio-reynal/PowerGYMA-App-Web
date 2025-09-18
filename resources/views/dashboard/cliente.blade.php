<!DOCTYPE html>
<html lang="es" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SmartPeak - Cliente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    
    <!-- Google Fonts para una tipografía limpia -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Iconos de Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        :root {
            --bg-body: #1E293B;
            --bg-sidebar: #0F172A;
            --bg-card: #283447;
            --bg-search: #334155;
            --bg-hover: #3b4a61;
            --bg-active-nav: #334155;
            --border-color: #334155;
            --text-primary: #E2E8F0;
            --text-secondary: #94A3B8;
            --text-headings: #ffffff;
            --chart-doughnut-bg: #334155;
        }

        html.light {
            --bg-body: #f8fafc;
            --bg-sidebar: #ffffff;
            --bg-card: #ffffff;
            --bg-search: #f1f5f9;
            --bg-hover: #e2e8f0;
            --bg-active-nav: #ddd6fe;
            --border-color: #d1d5db;
            --text-primary: #111827;
            --text-secondary: #4b5563;
            --text-headings: #000000;
            --chart-doughnut-bg: #f3f4f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-primary);
            transition: background-color 0.3s, color 0.3s;
        }
        .sidebar {
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            width: 16rem; /* Expandido a 256px */
            transition: width 0.3s ease-in-out;
        }
        
        .sidebar.collapsed {
            width: 4rem; /* 64px cuando está colapsado */
        }
        .main-content {
            margin-left: 16rem; /* 256px en rem (64 * 4px) */
            transition: margin-left 0.3s ease-in-out;
        }
        
        .main-content.sidebar-collapsed {
            margin-left: 4rem; /* 64px cuando sidebar está colapsado */
        }
        .header {
            position: sticky;
            top: 0;
            background-color: transparent;
            z-index: 999;
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        html.light .header {
            background-color: transparent;
        }

        html:not(.light) .header {
            background-color: rgba(30, 41, 59, 0);
        }
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
        }

        /* Fondo especial para la card de evaluación de riesgo */
        .risk-evaluation-card {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, rgba(245, 158, 11, 0.05) 50%, rgba(34, 197, 94, 0.05) 100%);
            border: 1px solid rgba(239, 68, 68, 0.1);
        }

        html.light .risk-evaluation-card {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.03) 0%, rgba(245, 158, 11, 0.03) 50%, rgba(34, 197, 94, 0.03) 100%);
            border: 1px solid rgba(239, 68, 68, 0.08);
        }
        .calendar-day {
            text-align: center;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .nav-link.active {
            background-color: var(--bg-active-nav);
            color: #4f46e5;
        }
        .nav-link:hover {
            background-color: var(--bg-hover);
        }
        .action-button:hover {
             background-color: var(--bg-hover);
        }
        
        /* Dropdown styles */
        .group:hover .group-hover\\:opacity-100 {
            opacity: 1;
        }
        .group:hover .group-hover\\:visible {
            visibility: visible;
        }

        /* Nuevos estilos para el medidor de riesgo mejorado */
        .risk-gauge-container {
            position: relative;
            width: 100%;
            padding-top: 50%; /* Aspect ratio 2:1 */
            margin: 0 auto;
        }

        .risk-gauge-svg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: visible;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.4));
        }
        
        #risk-needle {
            transform-origin: 50% 100%;
            transition: transform 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            stroke: #e2e8f0; /* slate-200 */
            stroke-width: 3;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
        }
        
        .legend-item {
            transition: transform 0.3s ease, opacity 0.3s ease, color 0.3s ease;
            opacity: 0.6;
        }
        .legend-item.active {
            transform: scale(1.1);
            opacity: 1;
            font-weight: 700;
        }

        /* Contenedor de evaluación de riesgo adaptativo */
        .risk-evaluation-container {
            background: transparent;
            border: none;
            box-shadow: none;
        }

        html.light .risk-evaluation-container {
            background: transparent;
            border: none;
            box-shadow: none;
        }

        /* Modo oscuro */
        html:not(.light) .risk-evaluation-container {
            background: transparent;
            border: none;
            box-shadow: none;
        }

        /* Mejoras específicas para texto en modo claro */
        html.light .risk-evaluation-container h2 {
            color: #111827 !important;
            text-shadow: none;
            font-weight: 700;
        }

        html.light .risk-evaluation-container p {
            color: #374151 !important;
        }

        html.light .risk-evaluation-container .text-white {
            color: #111827 !important;
        }

        /* Mejoras generales para modo claro */
        html.light .card {
            background: #ffffff;
            border: 1px solid #d1d5db;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        }

        html.light .sidebar {
            background: #ffffff;
            border-right: 1px solid #d1d5db;
            box-shadow: 4px 0 6px rgba(0, 0, 0, 0.05);
        }

        html.light .header {
            background: rgba(255, 255, 255, 0) !important;
            border-bottom: 1px solid #d1d5db00;
            box-shadow: 0 2px 4px rgb(0 0 0 / 0%);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        /* Mejoras para navegación y elementos interactivos */
        html.light nav a {
            color: #374151 !important;
        }

        html.light nav a:hover {
            color: #111827 !important;
            background-color: #f3f4f6;
        }

        html.light .btn {
            color: #111827;
            border: 1px solid #d1d5db;
        }

        html.light .btn:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
        }

        /* Mejoras para estadísticas y métricas */
        html.light .metric-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            color: #111827;
        }

        html.light .metric-value {
            color: #111827 !important;
            font-weight: 700;
        }

        html.light .metric-label {
            color: #6b7280 !important;
        }

        /* Estilos específicos para el medidor de riesgo diario mejorado */
        .risk-daily-container {
            background: transparent;
            border: none;
            box-shadow: none;
        }

        html.light .risk-daily-container {
            background: transparent;
            border: none;
            box-shadow: none;
        }

        html:not(.light) .risk-daily-container {
            background: transparent;
            border: none;
            box-shadow: none;
        }

        .risk-table-color {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
        }

        .risk-daily-container h1 {
            color: var(--text-headings);
        }

        .risk-daily-container h2 {
            color: var(--text-headings);
        }

        .risk-daily-container p {
            color: var(--text-secondary);
        }

        .risk-daily-container .text-white {
            color: var(--text-headings) !important;
        }

        html.light .risk-daily-container h1,
        html.light .risk-daily-container h2 {
            color: #111827 !important;
            text-shadow: none;
            font-weight: 700;
        }

        html.light .risk-daily-container p {
            color: #374151 !important;
        }

        html.light .risk-daily-container .text-white {
            color: #111827 !important;
        }

        html.light .risk-daily-container .text-slate-400 {
            color: #6b7280 !important;
        }

        html.light .risk-daily-container .text-slate-300 {
            color: #4b5563 !important;
        }

        .risk-gauge-legend {
            color: var(--text-secondary);
        }

        html.light .risk-gauge-legend {
            color: #6b7280;
        }

        /* Estilos mejorados para el gráfico de evaluación de riesgo */
        .risk-chart-container {
            position: relative;
            background: transparent;
            border-radius: 12px;
            padding: 16px;
            border: none;
        }

        html.light .risk-chart-container {
            background: transparent;
            border: none;
        }

        .risk-chart-header {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
        }

        html.light .risk-chart-header {
            background: rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .risk-legend-enhanced {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            padding: 12px;
            margin-top: 12px;
        }

        html.light .risk-legend-enhanced {
            background: rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .risk-time-indicator {
            background: linear-gradient(45deg, rgba(239, 68, 68, 0.1), rgba(245, 158, 11, 0.1));
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 600;
            color: #f59e0b;
        }

        html.light .risk-time-indicator {
            background: linear-gradient(45deg, rgba(239, 68, 68, 0.08), rgba(245, 158, 11, 0.08));
            border: 1px solid rgba(239, 68, 68, 0.15);
            color: #d97706;
        }

        /* Animación de pulso para alertas críticas */
        .pulse-animation {
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.7;
                transform: scale(1.1);
            }
        }

        /* Mejoras para las alertas de riesgo */
        .risk-alert-card {
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }

        .risk-alert-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        html.light .risk-alert-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Estilos específicos para cada nivel de riesgo */
        .risk-critical {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.1) 100%);
            border: 2px solid rgba(239, 68, 68, 0.4);
        }

        .risk-high {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.12) 0%, rgba(245, 158, 11, 0.1) 100%);
            border: 2px solid rgba(239, 68, 68, 0.3);
        }

        .risk-moderate {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(251, 191, 36, 0.1) 100%);
            border: 2px solid rgba(245, 158, 11, 0.4);
        }

        .risk-low {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.12) 0%, rgba(16, 185, 129, 0.1) 100%);
            border: 2px solid rgba(34, 197, 94, 0.4);
        }

        html.light .risk-critical {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.08) 0%, rgba(220, 38, 38, 0.05) 100%);
            border: 2px solid rgba(239, 68, 68, 0.25);
        }

        html.light .risk-high {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.06) 0%, rgba(245, 158, 11, 0.05) 100%);
            border: 2px solid rgba(239, 68, 68, 0.2);
        }

        html.light .risk-moderate {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(251, 191, 36, 0.05) 100%);
            border: 2px solid rgba(245, 158, 11, 0.25);
        }

        html.light .risk-low {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.08) 0%, rgba(16, 185, 129, 0.05) 100%);
            border: 2px solid rgba(34, 197, 94, 0.25);
        }

        /* Responsive sidebar for mobile */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 16rem;
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .main-content.sidebar-collapsed {
                margin-left: 0;
            }
            
            .mobile-sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }
            
            .mobile-sidebar-overlay.active {
                display: block;
            }
        }

        /* Estilos para elementos del sidebar cuando está colapsado */
        .sidebar.collapsed .nav-text {
            display: none;
        }
        
        .sidebar.collapsed .logo-main {
            display: none;
        }
        
        .sidebar.collapsed .logo-small {
            display: block;
        }
        
        .sidebar .logo-small {
            display: none;
        }
        
        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem;
        }
        
        .sidebar.collapsed .toggle-btn {
            justify-content: center;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
        }
        
        /* Logo container cuando sidebar está expandido */
        .sidebar:not(.collapsed) .logo-container {
            width: 180px;
            /* height: 300px; */
            padding: 4px;
        }
        /* Logo container cuando sidebar está colapsado */
        .sidebar.collapsed .logo-container {
            width: 40px;
            height: 40px;
            padding: 2px;
        }
        
        .logo-main {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .logo-small {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
</head>
<body class="bg-[var(--bg-body)]">

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar flex flex-col py-7 px-4">
        <!-- Toggle Button -->
        <button id="sidebar-toggle" class="toggle-btn flex items-center justify-between mb-6 p-2 rounded-lg hover:bg-[var(--bg-hover)] transition-colors">
            <div class="flex items-center">
                <div class="logo-container">
                    <img src="{{ asset('Img/Ico/Ico-Pw.svg') }}" alt="Power GYMA Logo" class="logo-main">
                    <img src="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}" alt="Power GYMA Logo" class="logo-small">
                </div>
            </div>
            <svg id="sidebar-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[var(--text-secondary)] transition-transform">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </button>
        
        <!-- Navigation -->
        <nav class="flex flex-col space-y-2">
            <a href="{{ route('cliente.dashboard') }}" class="nav-link flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('cliente.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"/>
                    <path d="M22 12A10 10 0 0 0 12 2v10z"/>
                </svg>
                <span class="nav-text ml-3 text-sm font-medium">Dashboard</span>
            </a>
            
            <a href="#" class="nav-link flex items-center px-3 py-2.5 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                    <line x1="8" y1="21" x2="16" y2="21"></line>
                    <line x1="12" y1="17" x2="12" y2="21"></line>
                </svg>
                <span class="nav-text ml-3 text-sm font-medium">Jobs</span>
            </a>
            
            <a href="#" class="nav-link flex items-center px-3 py-2.5 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14,2 14,8 20,8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10,9 9,9 8,9"></polyline>
                </svg>
                <span class="nav-text ml-3 text-sm font-medium">Applications</span>
            </a>
            
            <a href="#" class="nav-link flex items-center px-3 py-2.5 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span class="nav-text ml-3 text-sm font-medium">Team</span>
            </a>
            
            <a href="{{ route('cliente.reportes') }}" class="nav-link flex items-center px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('cliente.reportes*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                    <path d="M9 12l2 2 4-4"></path>
                    <path d="M21 12c.552 0 1-.448 1-1s-.448-1-1-1-1 .448-1 1 .448 1 1 1z"></path>
                    <path d="M3 12c.552 0 1-.448 1-1s-.448-1-1-1-1 .448-1 1 .448 1 1 1z"></path>
                    <path d="M12 3c.552 0 1-.448 1-1s-.448-1-1-1-1 .448-1 1 .448 1 1 1z"></path>
                    <path d="M12 21c.552 0 1-.448 1-1s-.448-1-1-1-1 .448-1 1 .448 1 1 1z"></path>
                    <path d="M5.636 18.364c.39.39 1.024.39 1.414 0s.39-1.024 0-1.414-.39-1.024-1.414 0-1.024.39 0 1.414z"></path>
                    <path d="M18.364 5.636c.39.39 1.024.39 1.414 0s.39-1.024 0-1.414-.39-1.024-1.414 0-1.024.39 0 1.414z"></path>
                </svg>
                <span class="nav-text ml-3 text-sm font-medium">Reports</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main id="main-content" class="main-content min-h-screen">
        <!-- Header -->
        <header class="header flex flex-col md:flex-row justify-between items-center mb-6 py-4 px-6 lg:px-10">
            <div class="flex items-center space-x-4 w-full md:w-auto">
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-secondary)] hover:text-[var(--text-primary)]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                
                <div class="flex flex-col">
                    <h1 class="text-2xl font-bold text-[var(--text-headings)] leading-tight">Plataforma SmartPeak</h1>
                    <p class="text-[var(--text-secondary)] text-sm">Vista general de tu consumo energético</p>
                </div>
            </div>
            <div class="flex items-center space-x-4 mt-4 md:mt-0">
                <!-- Action Buttons -->
                <div class="hidden md:flex items-center space-x-2">
                    <!-- Actualizar información -->
                    <form method="POST" action="{{ route('cliente.dashboard.refresh') }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] transition-colors" title="Actualizar información">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                                <path d="M21 3v5h-5"/>
                                <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                                <path d="M3 21v-5h5"/>
                            </svg>
                            <span class="text-sm font-medium">Actualizar</span>
                        </button>
                    </form>
                    
                    <!-- Generar informe detallado -->
                    <a href="{{ route('cliente.dashboard.export') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] transition-colors" title="Generar informe detallado">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                        <span class="text-sm font-medium">PDF</span>
                    </a>
                    
                    <!-- Ver históricos -->
                    <a href="{{ route('cliente.reportes') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] transition-colors" title="Ver históricos">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                            <line x1="1" y1="10" x2="23" y2="10"/>
                        </svg>
                        <span class="text-sm font-medium">Históricos</span>
                    </a>
                    
                    <div class="h-6 w-px bg-[var(--border-color)]"></div>
                </div>
                
                <!-- Mobile Action Menu -->
                <div class="md:hidden relative group">
                    <button class="p-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-secondary)] hover:text-[var(--text-primary)]" title="Opciones">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="1"/>
                            <circle cx="12" cy="5" r="1"/>
                            <circle cx="12" cy="19" r="1"/>
                        </svg>
                    </button>
                    
                    <!-- Mobile Dropdown -->
                    <div class="absolute right-0 top-full mt-2 w-56 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <form method="POST" action="{{ route('cliente.dashboard.refresh') }}" class="block">
                                @csrf
                                <button type="submit" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-primary)] w-full text-left">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                                        <path d="M21 3v5h-5"/>
                                        <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                                        <path d="M3 21v-5h5"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Actualizar información</p>
                                        <p class="text-xs text-[var(--text-secondary)]">Refrescar datos del dashboard</p>
                                    </div>
                                </button>
                            </form>
                            <a href="{{ route('cliente.dashboard.export') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-primary)]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                    <polyline points="10 9 9 9 8 9"/>
                                </svg>
                                <div>
                                    <p class="font-medium">Generar informe detallado</p>
                                    <p class="text-xs text-[var(--text-secondary)]">Descargar reporte en PDF</p>
                                </div>
                            </a>
                            <a href="{{ route('cliente.reportes') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-primary)]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                    <line x1="1" y1="10" x2="23" y2="10"/>
                                </svg>
                                <div>
                                    <p class="font-medium">Ver históricos</p>
                                    <p class="text-xs text-[var(--text-secondary)]">Consultar datos anteriores</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <button id="theme-toggle" class="p-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-secondary)] hover:text-[var(--text-primary)]">
                    <svg id="theme-toggle-dark-icon" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>
                <button class="p-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-secondary)] hover:text-[var(--text-primary)]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                </button>
                <div class="relative group">
                    <div class="flex items-center space-x-2 cursor-pointer">
                        <img src="https://placehold.co/40x40/0f172a/ffffff?text={{ strtoupper(substr(auth()->user()->name, 0, 2)) }}" alt="User" class="w-10 h-10 rounded-full">
                        <span class="font-medium text-[var(--text-headings)]">{{ auth()->user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[var(--text-secondary)]">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 top-full mt-2 w-48 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-3 border-b border-[var(--border-color)]">
                            <p class="font-medium text-[var(--text-headings)]">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-[var(--text-secondary)]">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="p-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-primary)] text-left">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                        <polyline points="16 17 21 12 16 7"/>
                                        <line x1="21" y1="12" x2="9" y2="12"/>
                                    </svg>
                                    <span>Cerrar sesión</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Scrollable Content Area -->
        <div class="px-6 pb-6 lg:px-10">
            @if(session('success'))
                <div style="padding:.75rem; background:#ecfeff; color:#155e75; border:1px solid #a5f3fc; border-radius:6px; margin-bottom:1rem;">
                    {{ session('success') }}
                </div>
            @endif
            @if(!empty($pendingUpdateSince))
                <div id="pendingBannerStatic" role="status" aria-live="polite" style="padding:.75rem; background:#fffbeb; color:#92400e; border:1px solid #fcd34d; border-radius:6px; margin-bottom:1rem; display:flex; align-items:center; justify-content:space-between; gap:.75rem;">
                    <div>
                        Hay nuevos datos procesados desde <strong>{{ \Carbon\Carbon::parse($pendingUpdateSince)->format('d/m/Y H:i') }}</strong>. Actualiza para reflejarlos en el dashboard.
                    </div>
                    <form id="refreshFormBanner" method="POST" action="{{ route('cliente.dashboard.refresh') }}">
                        @csrf
                        <button type="submit" class="btn" title="Aplicar cambios">Actualizar ahora</button>
                    </form>
                </div>
            @endif

        <?php 
            // Usar datos reales de la base de datos o del snapshot
            use Carbon\Carbon; 
            $s = $snapshot ?? null;
            if ($s) {
                $riskLevel = $s['riskLevel'] ?? 'No procede';
                $riskPercent = $s['riskPercent'] ?? 0;
                $originalLabels = $s['labels'] ?? [];
                $originalSeries = $s['series'] ?? [];
                $peakFrom = $s['peakFrom'] ?? null;
                $peakTo = $s['peakTo'] ?? null;
                $todayEvalDate = $s['todayEvalDate'] ?? null;
                $hasToday = (bool)($s['hasToday'] ?? false);
                $isFromToday = (bool)($s['isFromToday'] ?? false);
                $dataSource = $s['dataSource'] ?? 'sin_datos';
                $hasMonthly = (bool)($s['hasMonthly'] ?? false);
                $monthYear = $s['monthYear'] ?? ['year' => now()->year, 'month' => now()->month];
                $monthData = $s['monthData'] ?? [];
                
                // Filtrar para mostrar solo horas de 17:00 a 00:00
                $hoursToShow = [17, 18, 19, 20, 21, 22, 23, 0];
                $labels = [];
                $series = [];
                
                foreach($hoursToShow as $h){
                    $key = sprintf('%02d:00',$h);
                    $labels[] = $key;
                    
                    // Buscar el índice correspondiente en los datos originales
                    $originalIndex = array_search($key, $originalLabels);
                    if ($originalIndex !== false && isset($originalSeries[$originalIndex])) {
                        $series[] = $originalSeries[$originalIndex];
                    } else {
                        // Valor por defecto si no se encuentra
                        $series[] = $riskPercent;
                    }
                }
            } else {
                // Obtener datos reales de la base de datos
                $todayEval = \App\Models\RiskEvaluation::whereDate('evaluation_date', today())->first();
                $isFromToday = $todayEval !== null;
                
                // Si no hay datos de hoy, buscar la evaluación más reciente
                if (!$todayEval) {
                    $todayEval = \App\Models\RiskEvaluation::orderBy('evaluation_date', 'desc')->first();
                }
                
                $map = config('risk.percentages');
                $riskLevel = $todayEval?->risk_level ?? null;
                $latestMonth = null;
                if (!$riskLevel) {
                    $latestMonth = \App\Models\MonthlyRiskData::orderBy('year','desc')->orderBy('month','desc')->orderBy('day','desc')->first();
                    $riskLevel = $latestMonth?->risk_level ?? 'No procede';
                }
                $todayEvalDate = $todayEval?->evaluation_date?->toDateString();
                $hasToday = $isFromToday;
                $dataSource = $isFromToday ? 'hoy' : ($todayEval ? 'último_disponible' : 'sin_datos');
                $hasMonthly = $latestMonth !== null;
                $riskPercent = $map[$riskLevel] ?? 0;
                $startH = $todayEval?->start_time ? (int)Carbon::parse($todayEval->start_time)->format('H') : null;
                $endH = $todayEval?->end_time ? (int)Carbon::parse($todayEval->end_time)->format('H') : null;
                $labels = [];$series=[]; $low=20; $mid=50; $high=80;
                $hourly = $todayEval?->hourly_data ?? null;
                
                // Modificación: Solo mostrar horas de 17:00 a 00:00 (17 a 23 + 0)
                $hoursToShow = [17, 18, 19, 20, 21, 22, 23, 0];
                
                foreach($hoursToShow as $h){
                    $key = sprintf('%02d:00',$h);
                    $labels[] = $key;
                    if (is_array($hourly) && isset($hourly[$key])) {
                        $series[] = (int)$hourly[$key];
                    } else if($startH!==null && $endH!==null){
                        if($h < $startH) $series[]=$low;
                        elseif($h == $startH) $series[]=$mid;
                        elseif($h >= $startH+1 && $h <= $endH+1) $series[]=$high;
                        elseif($h == $endH+2) $series[]=$mid;
                        else $series[]=$low;
                    } else { $series[]=$riskPercent; }
                }
                $peakFrom = $startH!==null ? sprintf('%02d:00',$startH+1) : null;
                $peakTo = $endH!==null ? sprintf('%02d:00',$endH+1) : null;
                // Construir monthData como mapa día->nivel (para fallback)
                $monthCollection = \App\Models\MonthlyRiskData::currentMonth();
                $monthData = [];
                foreach ($monthCollection as $m) { $monthData[(int)$m->day] = $m->risk_level; }
                $monthYear = ['year' => now()->year, 'month' => now()->month];
            }
        ?>
        <!-- Dashboard Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Risk Evaluation -->
            <div class="lg:col-span-2 card risk-evaluation-card p-6">
                <div class="risk-chart-container">
                    <div class="risk-chart-header">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h2 class="text-xl font-semibold text-[var(--text-headings)] flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-400">
                                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                        <line x1="12" y1="9" x2="12" y2="13"/>
                                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                                    </svg>
                                    Evaluación de Riesgo
                                </h2>
                                
                                <!-- Alerta de Riesgo Mejorada y Más Visible -->
                                @if($riskLevel && $riskLevel !== 'No procede')
                                    <div class="mt-4 p-4 rounded-xl shadow-lg risk-alert-card
                                        {{ $riskLevel === 'Crítico' ? 'risk-critical' : 
                                           ($riskLevel === 'Alto' ? 'risk-high' : 
                                           ($riskLevel === 'Moderado' ? 'risk-moderate' : 'risk-low')) }}
                                    ">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="p-2 rounded-full
                                                    {{ $riskLevel === 'Crítico' ? 'bg-red-500' : 
                                                       ($riskLevel === 'Alto' ? 'bg-red-400' : 
                                                       ($riskLevel === 'Moderado' ? 'bg-yellow-400' : 'bg-green-400')) }}
                                                ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        @if($riskLevel === 'Crítico' || $riskLevel === 'Alto')
                                                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                                            <line x1="12" y1="9" x2="12" y2="13"/>
                                                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                                                        @elseif($riskLevel === 'Moderado')
                                                            <circle cx="12" cy="12" r="10"/>
                                                            <line x1="12" y1="8" x2="12" y2="12"/>
                                                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                                                        @else
                                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                                            <polyline points="22,4 12,14.01 9,11.01"/>
                                                        @endif
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-start justify-between">
                                                        <div>
                                                            <p class="text-lg font-bold 
                                                                {{ $riskLevel === 'Crítico' ? 'text-red-600' : 
                                                                   ($riskLevel === 'Alto' ? 'text-red-500' : 
                                                                   ($riskLevel === 'Moderado' ? 'text-yellow-600' : 'text-green-600')) }}
                                                                html.light:{{ $riskLevel === 'Crítico' ? 'text-red-700' : 
                                                                             ($riskLevel === 'Alto' ? 'text-red-600' : 
                                                                             ($riskLevel === 'Moderado' ? 'text-yellow-700' : 'text-green-700')) }}
                                                            ">
                                                                NIVEL {{ strtoupper($riskLevel) }}
                                                            </p>
                                                            @if($peakFrom && $peakTo)
                                                                <p class="text-sm font-semibold 
                                                                    {{ $riskLevel === 'Crítico' ? 'text-red-500' : 
                                                                       ($riskLevel === 'Alto' ? 'text-red-400' : 
                                                                       ($riskLevel === 'Moderado' ? 'text-yellow-500' : 'text-green-500')) }}
                                                                    html.light:{{ $riskLevel === 'Crítico' ? 'text-red-600' : 
                                                                                 ($riskLevel === 'Alto' ? 'text-red-500' : 
                                                                                 ($riskLevel === 'Moderado' ? 'text-yellow-600' : 'text-green-600')) }}
                                                                ">
                                                                    Horario: {{ $peakFrom }} - {{ $peakTo }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <!-- Recomendaciones al costado -->
                                                        <div class="ml-4 text-xs">
                                                            @if($riskLevel === 'Crítico')
                                                                <div class="space-y-1">
                                                                    <p class="text-red-500">• Reducir consumo inmediatamente</p>
                                                                    <p class="text-red-500">• Protocolo de emergencia</p>
                                                                    <p class="text-red-500">• Contactar proveedor urgente</p>
                                                                </div>
                                                            @elseif($riskLevel === 'Alto')
                                                                <div class="space-y-1">
                                                                    <p class="text-red-400">• Limitar equipos no esenciales</p>
                                                                    <p class="text-red-400">• Monitorear cada 15 min</p>
                                                                    <p class="text-red-400">• Evitar nuevos equipos</p>
                                                                </div>
                                                            @elseif($riskLevel === 'Moderado')
                                                                <div class="space-y-1">
                                                                    <p class="text-yellow-500">• Optimizar horarios</p>
                                                                    <p class="text-yellow-500">• Revisar aires acondicionados</p>
                                                                    <p class="text-yellow-500">• Diferir tareas no urgentes</p>
                                                                </div>
                                                            @else
                                                                <div class="space-y-1">
                                                                    <p class="text-green-500">• Mantener patrones actuales</p>
                                                                    <p class="text-green-500">• Operaciones normales</p>
                                                                    <p class="text-green-500">• Mantenimiento preventivo</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($riskLevel === 'Crítico' || $riskLevel === 'Alto')
                                                <div class="pulse-animation">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500">
                                                        <circle cx="12" cy="12" r="10"/>
                                                        <line x1="12" y1="8" x2="12" y2="12"/>
                                                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col items-end gap-2 ml-4">
                                <!-- Indicador de fuente de datos -->
                                @if($dataSource === 'hoy')
                                    <div class="flex items-center gap-2 px-3 py-1 rounded-lg bg-green-500/20 border border-green-500/40">
                                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                        <span class="text-xs font-medium text-green-400">Datos de hoy</span>
                                    </div>
                                @elseif($dataSource === 'último_disponible')
                                    <div class="flex items-center gap-2 px-3 py-1 rounded-lg bg-yellow-500/20 border border-yellow-500/40">
                                        <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                                        <span class="text-xs font-medium text-yellow-400">Último disponible</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2 px-3 py-1 rounded-lg bg-gray-500/20 border border-gray-500/40">
                                        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                        <span class="text-xs font-medium text-gray-400">Sin datos</span>
                                    </div>
                                @endif
                                
                                <button class="text-sm bg-[var(--bg-search)] px-4 py-2 rounded-lg font-medium">
                                    {{ $todayEvalDate ? \Carbon\Carbon::parse($todayEvalDate)->format('d \d\e M') : 'Hoy' }}
                                </button>
                                <div class="text-xs text-[var(--text-secondary)] text-right">
                                    <div>Actualizado: {{ now()->format('H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="h-64 mt-4">
                        <canvas id="riskChart"></canvas>
                    </div>
                    
                    <div class="risk-legend-enhanced">
                        <div class="flex justify-center space-x-6 text-sm text-[var(--text-secondary)]">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full bg-green-500 mr-2 shadow-sm"></div>
                                <span class="font-medium">Bajo Riesgo</span>
                                <span class="ml-1 text-xs opacity-75">(0-20%)</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full bg-yellow-500 mr-2 shadow-sm"></div>
                                <span class="font-medium">Riesgo Medio</span>
                                <span class="ml-1 text-xs opacity-75">(21-50%)</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full bg-red-500 mr-2 shadow-sm"></div>
                                <span class="font-medium">Alto Riesgo</span>
                                <span class="ml-1 text-xs opacity-75">(51-100%)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EVALUACIÓN DE RIESGO DIARIO - Individual -->
            <div class="card risk-evaluation-card p-6">
                <div class="risk-daily-container w-full max-w-md mx-auto">
                    
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold mb-2" style="color: var(--text-headings);">Evaluación de Riesgo Diario</h2>
                        <p id="fullDate" class="text-sm mb-4" style="color: var(--text-secondary);">{{ \Carbon\Carbon::now('America/Lima')->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</p>
                        <div class="inline-block px-4 py-2 rounded-lg
                            {{ $riskLevel === 'Crítico' ? 'bg-red-500/20 border-2 border-red-500/40' : 
                               ($riskLevel === 'Alto' ? 'bg-red-400/20 border-2 border-red-400/40' : 
                               ($riskLevel === 'Moderado' ? 'bg-yellow-500/20 border-2 border-yellow-500/40' : 'bg-green-500/20 border-2 border-green-500/40')) }}
                        ">
                            <p class="text-lg font-bold" style="color: var(--text-headings);">
                                RIESGO: <span id="riskStatus" class="text-2xl
                                    {{ $riskLevel === 'Crítico' ? 'text-red-400' : 
                                       ($riskLevel === 'Alto' ? 'text-red-300' : 
                                       ($riskLevel === 'Moderado' ? 'text-yellow-300' : 'text-green-300')) }}
                                ">{{ strtoupper($riskLevel ?? 'N/A') }}</span>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Medidor de riesgo con Canvas -->
                    <div class="relative w-full max-w-xs mx-auto h-48 mt-4 mb-20">
                        <canvas id="riskGauge" width="300" height="192"></canvas>
                        <!-- Valor del porcentaje debajo del medidor -->
                        <div class="absolute left-1/2 -translate-x-1/2 text-center" style="bottom: -58px;">
                            <div id="riskValue" class="text-4xl font-bold" style="color: var(--text-headings);">{{ $riskPercent ?? 0 }}%</div>
                            <div class="text-sm font-bold" style="color: var(--text-secondary);">RIESGO</div>
                        </div>
                    </div>

                    <!-- Leyenda y hora de mayor riesgo -->
                    <div class="mt-6 space-y-4">
                        <div id="riskLegend" class="flex flex-wrap justify-center items-center gap-x-4 gap-y-2 text-xs risk-gauge-legend">
                            <!-- La leyenda se genera con JavaScript -->
                        </div>
                        <div class="text-center p-4 rounded-lg bg-gradient-to-r from-red-500/10 to-orange-500/10 border border-red-500/20">
                            <p class="text-xs uppercase tracking-wider font-medium mb-2" style="color: var(--text-secondary);">Hora de Mayor Riesgo</p>
                            <p id="riskHour" class="text-2xl font-bold text-red-400">{{ $peakFrom && $peakTo ? "$peakFrom - $peakTo" : 'N/A' }}</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- CALENDARIO MENSUAL - Individual -->
            <div class="card p-6">
                <h2 class="text-xl font-semibold text-[var(--text-headings)] mb-4">
                    Previsión {{ ucfirst(\Carbon\Carbon::now('America/Lima')->locale('es')->monthName) }} {{ \Carbon\Carbon::now('America/Lima')->year }}
                </h2>
                <div class="grid grid-cols-7 gap-y-2 text-center text-sm">
                    <div class="font-bold text-[var(--text-secondary)]">L</div><div class="font-bold text-[var(--text-secondary)]">M</div><div class="font-bold text-[var(--text-secondary)]">X</div><div class="font-bold text-[var(--text-secondary)]">J</div><div class="font-bold text-[var(--text-secondary)]">V</div><div class="font-bold text-[var(--text-secondary)]">S</div><div class="font-bold text-[var(--text-secondary)]">D</div>
                    
                    @php
                        $currentDate = \Carbon\Carbon::now('America/Lima');
                        $daysInMonth = $currentDate->daysInMonth;
                        $firstDayOfWeek = $currentDate->copy()->startOfMonth()->dayOfWeek;
                        $firstDayOfWeek = $firstDayOfWeek == 0 ? 7 : $firstDayOfWeek; // Convertir domingo de 0 a 7
                        
                        // Espacios en blanco al inicio
                        for($i = 1; $i < $firstDayOfWeek; $i++) {
                            echo '<div class="calendar-day"></div>';
                        }
                    @endphp
                    
                    @for($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $dayData = $monthData[$day] ?? null;
                            $color = '';
                            $isToday = $day == $currentDate->day;
                            
                            if ($dayData === 'Crítico' || $dayData === 'Alto') {
                                $color = 'bg-red-500/30 text-red-300';
                            } elseif ($dayData === 'Moderado') {
                                $color = 'bg-yellow-500/30 text-yellow-300';
                            } elseif ($dayData === 'Bajo' || $dayData === 'Muy Bajo') {
                                $color = 'bg-green-500/30 text-green-300';
                            } else {
                                $color = '';
                            }
                            
                            if ($isToday) {
                                $color .= ' ring-2 ring-blue-400 bg-blue-500/20 text-blue-300';
                            }
                        @endphp
                        <div class="calendar-day {{ $color }}">{{ $day }}</div>
                    @endfor
                </div>
            </div>
            
            <!-- PREDICCIÓN DETALLADA Y ALERTAS - Combinado -->
            <div class="card p-6">
                <!-- Encabezado combinado -->
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-[var(--text-headings)]">Predicción y Alertas</h2>
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-400">
                            <path d="M9 11H1v3h8v3l8-8-8-8v3z"/>
                        </svg>
                        <span class="text-sm text-[var(--text-secondary)]">Próximos eventos</span>
                    </div>
                </div>

                <!-- Sección de Predicción Detallada -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-[var(--text-headings)] mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-amber-400">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12,6 12,12 16,14"/>
                        </svg>
                        Predicción de Consumo
                    </h3>
                    <ul class="space-y-3 text-sm">
                        @if($peakFrom && $peakTo)
                            <li class="flex justify-between items-center p-2 bg-[var(--bg-hover)] rounded-lg">
                                <span class="flex items-center">
                                    <div class="inline-block w-2 h-2 rounded-full bg-red-500 mr-3"></div>
                                    <span class="font-medium">Hoy</span>
                                </span>
                                <span class="text-[var(--text-secondary)]">{{ $peakFrom }} - {{ $peakTo }}</span>
                            </li>
                        @endif
                        <li class="flex justify-between items-center p-2 bg-[var(--bg-hover)] rounded-lg">
                            <span class="flex items-center">
                                <div class="inline-block w-2 h-2 rounded-full bg-yellow-500 mr-3"></div>
                                <span class="font-medium">Mañana</span>
                            </span>
                            <span class="text-[var(--text-secondary)]">7:30 p.m. - 9:00 p.m.</span>
                        </li>
                        <li class="flex justify-between items-center p-2 bg-[var(--bg-hover)] rounded-lg">
                            <span class="flex items-center">
                                <div class="inline-block w-2 h-2 rounded-full bg-yellow-500 mr-3"></div>
                                <span class="font-medium">Próximo período</span>
                            </span>
                            <span class="text-[var(--text-secondary)]">6:45 p.m. - 8:15 p.m.</span>
                        </li>
                    </ul>
                </div>

                <!-- Sección de Alertas de Consumo -->
                <div>
                    <h3 class="text-lg font-medium text-[var(--text-headings)] mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-red-400">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        Alertas Activas
                    </h3>
                    <div class="space-y-3">
                        @if($riskLevel === 'Crítico' || $riskLevel === 'Alto')
                        <div class="flex items-start space-x-3 p-3 bg-red-500/10 border border-red-500/20 rounded-lg">
                            <div class="p-2 bg-red-500/20 rounded-lg text-red-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-[var(--text-headings)]">Pico de consumo detectado</p>
                                <p class="text-sm text-[var(--text-secondary)]">Se detectó un nivel {{ $riskLevel }} de riesgo energético.</p>
                            </div>
                        </div>
                        @endif
                        <div class="flex items-start space-x-3 p-3 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                            <div class="p-2 bg-yellow-500/20 rounded-lg text-yellow-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"/>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-[var(--text-headings)]">Recomendación de optimización</p>
                                <p class="text-sm text-[var(--text-secondary)]">Programa mantenimientos en horas de menor riesgo.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3 p-3 bg-green-500/10 border border-green-500/20 rounded-lg">
                            <div class="p-2 bg-green-500/20 rounded-lg text-green-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-[var(--text-headings)]">Ahorro verificado</p>
                                <p class="text-sm text-[var(--text-secondary)]">Sistema optimizado para máximo ahorro.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accumulated Savings -->
            <div class="card p-6 flex flex-col items-center">
                <h2 class="text-xl font-semibold text-[var(--text-headings)]">Ahorro Acumulado</h2>
                <div class="relative w-40 h-40 my-4">
                    <canvas id="savingsChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-bold text-[var(--text-headings)]">32%</span>
                        <span class="text-sm text-[var(--text-secondary)]">de ahorro</span>
                    </div>
                </div>
                <p class="text-3xl font-bold text-[var(--text-headings)]">S/. 12,540</p>
                <p class="text-sm text-[var(--text-secondary)] mb-6">Ahorro total acumulado</p>
                <div class="w-full space-y-2 text-sm text-[var(--text-secondary)]">
                    <div class="flex justify-between items-center text-[var(--text-primary)]"><span>Sin SmartPeak</span><span>S/. 38,000</span></div>
                    <div class="w-full bg-[var(--bg-search)] h-2 rounded-full"><div class="bg-red-500 h-2 rounded-full" style="width: 100%"></div></div>
                    <div class="flex justify-between items-center text-[var(--text-primary)]"><span>Con SmartPeak</span><span>S/. 25,460</span></div>
                    <div class="w-full bg-[var(--bg-search)] h-2 rounded-full"><div class="bg-green-500 h-2 rounded-full" style="width: 67%"></div></div>
                </div>
            </div>

        </div>
        </div>
    </main>

    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-sidebar-overlay" class="mobile-sidebar-overlay"></div>

    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed bottom-4 right-4 z-[9999] space-y-2"></div>

    <script>
        // Global chart instances
        let riskChart, savingsChart;

        // Notification System
        function showNotification(message, type = 'success', duration = 3000) {
            const container = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            
            notification.className = `${bgColor} text-white px-6 py-4 rounded-lg shadow-lg flex items-center justify-between min-w-80 transform translate-y-full transition-transform duration-300`;
            notification.innerHTML = `
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${type === 'success' ? 
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>'
                        }
                    </svg>
                    <span class="font-medium">${message}</span>
                </div>
                <button onclick="closeNotification(this)" class="ml-4 hover:bg-white hover:bg-opacity-20 rounded-full p-1 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            
            container.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-y-full');
            }, 100);
            
            // Auto remove after duration
            if (duration > 0) {
                setTimeout(() => {
                    closeNotification(notification.querySelector('button'));
                }, duration);
            }
        }

        function closeNotification(button) {
            const notification = button.closest('div');
            notification.classList.add('translate-y-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }

        // Handle all refresh forms
        function handleRefreshForm(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading notification
                showNotification('Actualizando información...', 'info', 5000);
                
                fetch('{{ route("cliente.dashboard.refresh") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded',
                    }
                })
                .then(response => {
                    // Close loading notification
                    const loadingNotification = document.querySelector('#notificationContainer div');
                    if (loadingNotification) {
                        closeNotification(loadingNotification.querySelector('button'));
                    }
                    
                    if (response.ok) {
                        showNotification('Información actualizada correctamente', 'success', 5000);
                        // Optionally reload the page after a short delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showNotification('❌ Error al actualizar la información', 'error', 5000);
                    }
                })
                .catch(error => {
                    // Close loading notification
                    const loadingNotification = document.querySelector('#notificationContainer div');
                    if (loadingNotification) {
                        closeNotification(loadingNotification.querySelector('button'));
                    }
                    
                    showNotification('❌ Error de conexión', 'error', 5000);
                    console.error('Error:', error);
                });
            });
        }

        function updateChartColors() {
            const isLightMode = document.documentElement.classList.contains('light');
            const gridColor = isLightMode ? '#e2e8f0' : '#334155';
            const tickColor = isLightMode ? '#64748b' : '#94A3B8';
            const tooltipBg = isLightMode ? '#ffffff' : '#0F172A';
            const tooltipTitle = isLightMode ? '#0f172a' : '#E2E8F0';
            const tooltipBody = isLightMode ? '#64748b' : '#94A3B8';
            const savingsBg = isLightMode ? '#e2e8f0' : '#334155';
            
            // Update Risk Chart
            if (riskChart) {
                riskChart.options.scales.y.grid.color = gridColor;
                riskChart.options.scales.y.ticks.color = tickColor;
                riskChart.options.scales.x.ticks.color = tickColor;
                riskChart.options.plugins.tooltip.backgroundColor = tooltipBg;
                riskChart.options.plugins.tooltip.titleColor = tooltipTitle;
                riskChart.options.plugins.tooltip.bodyColor = tooltipBody;
                riskChart.update();
            }

            // Update Savings Chart
            if (savingsChart) {
                savingsChart.data.datasets[0].backgroundColor[1] = savingsBg;
                savingsChart.update();
            }
        }

        function initializeCharts() {
            // Risk Chart
            const riskCtx = document.getElementById('riskChart').getContext('2d');
            const riskData = @json($series);
            const riskLabels = @json($labels);
            
            // DEBUG: Mostrar datos en consola para verificar
            console.log('📈 RISK CHART - CURVA GRADUAL:', {
                nivel_excel: '{{ $snapshot["riskLevel"] ?? "N/A" }}',
                valor_maximo: '{{ $snapshot["riskPercent"] ?? 0 }}%',
                curva_datos: riskData,
                inicio: riskData[0] + '%',
                maximo: Math.max(...riskData) + '%',
                version: 'v4.0 - Curva gradual desde 0%'
            });
            
            riskChart = new Chart(riskCtx, {
                type: 'line', 
                data: { 
                    labels: riskLabels, 
                    datasets: [{ 
                        label: 'Nivel de Riesgo (%)',
                        data: riskData, 
                        borderColor: '#EF4444', 
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 3, 
                        pointBackgroundColor: function(context) {
                            const value = context.parsed.y;
                            if (value >= 51) return '#EF4444'; // Rojo para alto riesgo (51-100%)
                            if (value >= 21) return '#0bf51fff'; // Amarillo para medio riesgo (21-50%)
                            return '#22C55E'; // Verde para bajo riesgo (0-20%)
                        },
                        pointBorderColor: function(context) {
                            const value = context.parsed.y;
                            if (value >= 51) return '#DC2626';
                            if (value >= 21) return '#0cff0cff';
                            return '#16A34A';
                        },
                        pointRadius: 4, 
                        pointHoverRadius: 6, 
                        tension: 0.5, // Curva más suave y natural 
                        fill: true,
                        segment: {
                            borderColor: function(ctx) {
                                const value = ctx.p1.parsed.y;
                                if (value >= 51) return '#EF4444'; // Rojo - Alto Riesgo (51-100%)
                                if (value >= 21) return '#0bf546ff'; // Amarillo - Riesgo Medio (21-50%)
                                return '#22C55E'; // Verde
                            }
                        }
                    }] 
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: { 
                        legend: { display: false }, 
                        tooltip: {
                            backgroundColor: '#0F172A',
                            titleColor: '#E2E8F0',
                            bodyColor: '#94A3B8',
                            borderColor: '#334155',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                title: function(context) {
                                    return 'Hora: ' + context[0].label;
                                },
                                label: function(context) {
                                    const value = context.parsed.y;
                                    let level = 'Bajo';
                                    if (value >= 66) level = 'Alto';
                                    else if (value >= 36) level = 'Medio';
                                    return `Riesgo ${level}: ${value}%`;
                                }
                            }
                        } 
                    }, 
                    scales: { 
                        y: { 
                            beginAtZero: true, 
                            max: 100,
                            grid: { 
                                color: '#334155',
                                drawBorder: false 
                            }, 
                            ticks: { 
                                color: '#94A3B8',
                                callback: function(value) {
                                    return value + '%';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Nivel de Riesgo (%)',
                                color: '#94A3B8',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }, 
                        x: { 
                            grid: { 
                                display: false 
                            }, 
                            ticks: { 
                                color: '#94A3B8',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Horario Crítico (17:00 - 00:00)',
                                color: '#94A3B8',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        } 
                    } 
                }
            });
            
            // Savings Chart
            const savingsCtx = document.getElementById('savingsChart').getContext('2d');
            savingsChart = new Chart(savingsCtx, {
                type: 'doughnut', 
                data: { 
                    datasets: [{ 
                        data: [32, 68], 
                        backgroundColor: ['#F59E0B', '#334155'], 
                        borderWidth: 0, 
                        borderRadius: 5, 
                        cutout: '75%' 
                    }] 
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    plugins: { 
                        legend: { display: false }, 
                        tooltip: { enabled: false } 
                    } 
                }
            });

            // Set initial colors
            updateChartColors();
        }

        // Theme Toggling Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        function toggleTheme() {
            document.documentElement.classList.toggle('light');
            darkIcon.classList.toggle('hidden');
            lightIcon.classList.toggle('hidden');
            
            const isLight = document.documentElement.classList.contains('light');
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
            
            updateChartColors();
        }

        themeToggleBtn.addEventListener('click', toggleTheme);

        // On page load, set the theme from localStorage
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.add('light');
            darkIcon.classList.add('hidden');
            lightIcon.classList.remove('hidden');
        } else {
            darkIcon.classList.remove('hidden');
            lightIcon.classList.add('hidden');
        }
        
        // Función para actualizar la fecha automáticamente en español (zona horaria de Perú)
        function updateDateAndTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                timeZone: 'America/Lima'
            };
            
            const dateFormatter = new Intl.DateTimeFormat('es-PE', options);
            const formattedDate = dateFormatter.format(now);
            
            // Capitalizar la primera letra y formatear correctamente
            const finalDate = formattedDate.charAt(0).toUpperCase() + formattedDate.slice(1);
            
            const fullDateElement = document.getElementById('fullDate');
            if (fullDateElement) {
                fullDateElement.textContent = finalDate;
            }
        }
        
        // Initialize charts after the DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
            initializeRiskGauge();
            initializeSidebarToggle();
            
            // Actualizar fecha inmediatamente
            updateDateAndTime();
            
            // Actualizar fecha cada minuto
            setInterval(updateDateAndTime, 60000);
            
            // Handle all refresh forms
            const refreshForms = document.querySelectorAll('form[action*="refresh"]');
            refreshForms.forEach(form => {
                handleRefreshForm(form);
            });
        });

        // Sidebar Toggle Functionality
        function initializeSidebarToggle() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleBtn = document.getElementById('sidebar-toggle');
            const arrow = document.getElementById('sidebar-arrow');

            if (toggleBtn && sidebar && mainContent && arrow) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('sidebar-collapsed');
                    
                    // Rotate arrow
                    if (sidebar.classList.contains('collapsed')) {
                        arrow.style.transform = 'rotate(180deg)';
                    } else {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                });
            }
        }

        // Nueva funcionalidad para el medidor de riesgo mejorado
        function initializeRiskGauge() {
            const canvas = document.getElementById('riskGauge');
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');
            const riskValueDisplay = document.getElementById('riskValue');
            const riskStatusDisplay = document.getElementById('riskStatus');
            const riskLegendContainer = document.getElementById('riskLegend');
            const riskHourDisplay = document.getElementById('riskHour');

            const riskLevels = [
                { limit: 10, display: 10, label: 'Muy Bajo', color: '#22c55e' }, 
                { limit: 20, display: 20, label: 'Bajo', color: '#22c55e' },      // CORREGIDO: Bajo = 20%
                { limit: 50, display: 50, label: 'Moderado', color: '#f97316' },
                { limit: 80, display: 80, label: 'Alto', color: '#ef4444' },      // CORREGIDO: Alto = 80%
                { limit: 100, display: 95, label: 'Crítico', color: '#dc2626' }   // CORREGIDO: Crítico = 95%
            ];
            
            function findCategoryMiddlePoint(value) {
                let lowerBound = 0;
                for (const level of riskLevels) {
                    if (value <= level.limit) {
                        return (lowerBound + level.limit) / 2;
                    }
                    lowerBound = level.limit;
                }
                return (lowerBound + 100) / 2;
            }

            let currentRisk = 0;
            const actualRiskValue = {{ $riskPercent ?? 0 }};
            let targetRisk = actualRiskValue; // Usar valor exacto del porcentaje, no el punto medio
            console.log('🔧 GAUGE DEBUG:', {
                riskLevel: '{{ $riskLevel }}',
                actualRiskValue: actualRiskValue,
                targetRisk: targetRisk
            });
            let animationFrameId = null;

            // Crear leyenda
            if (riskLegendContainer) {
                riskLegendContainer.innerHTML = '';
                riskLevels.forEach(level => {
                    const item = document.createElement('span');
                    item.className = 'flex items-center';
                    item.innerHTML = `
                        <span class="risk-table-color" style="background-color: ${level.color};"></span>
                        <span class="text-slate-300">${level.label} <span class="text-slate-400 font-medium">(${level.display}%)</span></span>
                    `;
                    riskLegendContainer.appendChild(item);
                });
            }

            function resizeCanvas() {
                const container = canvas.parentElement;
                canvas.width = container.clientWidth;
                canvas.height = container.clientHeight;
                draw();
            }

            function valueToAngle(value) {
                return (value / 100) * Math.PI - Math.PI;
            }

            function drawGaugeArc() {
                const centerX = canvas.width / 2;
                const centerY = canvas.height - 10;
                const radius = Math.max(0, Math.min(centerX, centerY) * 0.85);
                const lineWidth = 50;
                
                ctx.lineCap = 'butt';
                
                let lastLimit = 0;
                riskLevels.forEach(level => {
                    ctx.beginPath();
                    const startAngle = valueToAngle(lastLimit);
                    const endAngle = valueToAngle(level.limit);
                    ctx.arc(centerX, centerY, radius, startAngle, endAngle, false);
                    ctx.strokeStyle = level.color;
                    ctx.lineWidth = lineWidth;
                    ctx.stroke();
                    lastLimit = level.limit;
                });
            }
            
            function drawNeedle(value) {
                const centerX = canvas.width / 2;
                const centerY = canvas.height - 10;
                const radius = Math.max(0, Math.min(centerX, centerY) * 0.85 - 5);
                const angle = valueToAngle(value);

                ctx.save();
                ctx.translate(centerX, centerY);
                ctx.rotate(angle + Math.PI / 2);
                
                ctx.beginPath();
                ctx.moveTo(0, -radius);
                ctx.lineTo(-7, 15);
                ctx.lineTo(7, 15);
                ctx.closePath();
                
                ctx.fillStyle = '#ffffff';
                ctx.shadowColor = 'rgba(0, 0, 0, 0.5)';
                ctx.shadowBlur = 10;
                ctx.shadowOffsetY = 3;
                ctx.fill();
                
                ctx.restore();

                ctx.beginPath();
                ctx.arc(centerX, centerY, 8, 0, 2 * Math.PI);
                ctx.fillStyle = '#ffffff';
                ctx.fill();
            }

            function getLevelColor(value) {
                return (riskLevels.find(l => value <= l.limit) || riskLevels[riskLevels.length - 1]).color;
            }

            function updateDisplay(value) {
                const roundedValue = Math.round(value);
                const level = riskLevels.find(l => roundedValue <= l.limit) || riskLevels[riskLevels.length - 1];
                
                if (riskValueDisplay) {
                    riskValueDisplay.textContent = `${actualRiskValue}%`;
                }
                
                if (riskStatusDisplay) {
                    // Usar el nivel real de la base de datos
                    const realLevel = "{{ $riskLevel ?? 'N/A' }}";
                    riskStatusDisplay.textContent = realLevel.toUpperCase();
                    riskStatusDisplay.style.color = level.color;
                }

                updateRiskHour(actualRiskValue, level.color);
            }
            
            function updateRiskHour(value, color) {
                if (!riskHourDisplay) return;
                
                // Usar datos reales si están disponibles
                @if($peakFrom && $peakTo)
                    riskHourDisplay.textContent = "{{ $peakFrom }} - {{ $peakTo }}";
                    riskHourDisplay.style.color = color;
                @else
                    // Fallback: calcular hora basada en el valor de riesgo
                    let hour = "06:00 - 08:00";
                    if (value > 20) hour = "09:00 - 11:00";
                    if (value > 35) hour = "12:00 - 14:00";
                    if (value > 50) hour = "16:00 - 18:00";
                    if (value > 65) hour = "19:00 - 20:00";
                    if (value === 0) hour = "N/A";
                    riskHourDisplay.textContent = hour;
                    riskHourDisplay.style.color = color;
                @endif
            }

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                drawGaugeArc();
                drawNeedle(currentRisk);
            }
            
            function animate() {
                if (Math.abs(targetRisk - currentRisk) < 0.1) {
                    currentRisk = targetRisk;
                    cancelAnimationFrame(animationFrameId);
                    animationFrameId = null;
                } else {
                    currentRisk += (targetRisk - currentRisk) * 0.1;
                    animationFrameId = requestAnimationFrame(animate);
                }
                draw();
                updateDisplay(currentRisk);
            }

            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();
            animate();
        }

        // Handle refresh forms (legacy support)
        const refreshFormBanner = document.getElementById('refreshFormBanner');
        if (refreshFormBanner) {
            handleRefreshForm(refreshFormBanner);
        }

        // Mobile Menu Functionality
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.querySelector('.sidebar');
        const mobileOverlay = document.getElementById('mobile-sidebar-overlay');

        if (mobileMenuBtn && sidebar && mobileOverlay) {
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
                mobileOverlay.classList.toggle('active');
            });

            mobileOverlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-open');
                mobileOverlay.classList.remove('active');
            });

            // Close mobile menu when clicking sidebar links
            const sidebarLinks = sidebar.querySelectorAll('a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-open');
                    mobileOverlay.classList.remove('active');
                });
            });
        }

    </script>
</body>
</html>
