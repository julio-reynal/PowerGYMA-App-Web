<!DOCTYPE html>
<html lang="es" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SmartPeak - Demo ({{ date('His') }})</title>
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
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 40;
            width: 16rem; /* Expandido a 256px */
            transition: width 0.3s ease-in-out;
        }
        
        .sidebar.collapsed {
            width: 4rem; /* 64px cuando está colapsado */
        }
        .header {
            background-color: transparent;
            border-bottom: transparent;
            position: sticky;
            top: 0;
            z-index: 30;
        }
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            transition: box-shadow 0.3s;
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
        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .nav-item:hover {
            background-color: var(--bg-hover);
        }
        .nav-item.active {
            background-color: var(--bg-active-nav);
        }
        .calendar-day {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 12px;
        }
        .action-button {
            background-color: var(--bg-hover);
            border: 1px solid var(--border-color);
            transition: all 0.2s;
        }
        .action-button:hover {
            background-color: var(--bg-search);
            transform: translateY(-1px);
        }
        .action-button-disabled {
            background-color: var(--bg-hover);
            border: 1px solid var(--border-color);
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        /* Nav item styles */
        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .nav-link:hover {
            background-color: var(--bg-hover);
            color: var(--text-primary);
        }
        .nav-link.active {
            background-color: var(--bg-active-nav);
            color: #4f46e5;
        }
        
        /* Header styles */
        .header {
            background-color: transparent;
            border-bottom: transparent;
            position: sticky;
            top: 0;
            z-index: 30;
            backdrop-filter: blur(10px);
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
            background-color:transparent;
            border-bottom: transparent;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
        }

        /* Ajuste para el contenido principal con sidebar fijo */
        .main-content {
            margin-left: 16rem; /* 256px = w-64 */
            transition: margin-left 0.3s ease-in-out;
        }
        
        .main-content.sidebar-collapsed {
            margin-left: 4rem; /* 64px cuando sidebar está colapsado */
        }

        /* Responsive para móviles */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -16rem;
                transition: left 0.3s ease;
                width: 16rem;
            }
            .sidebar.mobile-open {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .main-content.sidebar-collapsed {
                margin-left: 0;
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

        .demo-badge {
            background: linear-gradient(45deg, #f59e0b, #d97706);
            color: white;
            font-weight: bold;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Estilos para el modal premium mejorado */
        .premium-modal-card {
            background-color: var(--bg-card);
            border-radius: 1.5rem;
            position: relative;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05), 0 0 30px -10px rgba(59, 130, 246, 0.3);
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
            color: var(--text-primary);
            padding: 2px; /* Espacio para el borde */
        }

        @keyframes animated-border {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .premium-modal-card::before {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            z-index: -1;
            border-radius: inherit;
            background: linear-gradient(120deg, #f59e0b, #ef4444, #3b82f6, #f59e0b);
            background-size: 300% 300%;
            animation: animated-border 2s linear infinite;
        }

        .premium-modal-card::after {
            content: '';
            position: absolute;
            top: 2px; right: 2px; bottom: 2px; left: 2px;
            z-index: -1;
            border-radius: calc(1.5rem - 2px);
            background-color: var(--bg-card);
        }

        .btn-primary {
            background: linear-gradient(to right, #f59e0b, #fbbf24);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px -5px rgba(245, 158, 11, 0.6);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px -5px rgba(245, 158, 11, 0.7);
        }

        .btn-secondary {
            background-color: transparent;
            border: 1px solid #3b82f6;
            color: #3b82f6;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
        }

        html.light .premium-modal-card {
            background-color: #ffffff;
            color: #0f172a;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        html.light .premium-modal-card::after {
            background-color: #ffffff;
        }

        html.light .btn-secondary {
            border-color: #64748b;
            color: #64748b;
        }

        html.light .btn-secondary:hover {
            background-color: #e2e8f0;
            color: #334155;
        }

        /* Estilos para notificaciones mejoradas */
        #successNotification {
            backdrop-filter: blur(10px);
        }

        #successNotification .progress-bar {
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        /* Animaciones adicionales para las notificaciones */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .notification-enter {
            animation: slideInRight 0.5s ease-out;
        }

        .notification-exit {
            animation: slideOutRight 0.5s ease-in;
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
    </style>
</head>

<body class="min-h-screen">
    <div class="min-h-screen">
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

        <!-- Demo Badge -->
        <div class="mb-4 px-2">
            <div class="px-2 py-1 bg-orange-500 text-white text-xs rounded-full font-bold animate-pulse text-center">
                <span class="nav-text">DEMO</span>
                <span class="hidden sidebar.collapsed:block">D</span>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="flex flex-col space-y-2">
            <!-- Dashboard (activo y accesible) -->
            <a href="#" class="nav-link flex items-center px-3 py-2.5 rounded-lg transition-colors active">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"/>
                    <path d="M22 12A10 10 0 0 0 12 2v10z"/>
                </svg>
                <span class="nav-text ml-3 text-sm font-medium">Dashboard</span>
            </a>
            
            <!-- Jobs (Premium) -->
            <a href="#" class="nav-link flex items-center px-3 py-2.5 rounded-lg transition-colors relative cursor-pointer hover:bg-[var(--bg-hover)]" data-premium="true" title="Funcionalidad Premium">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                    <line x1="8" y1="21" x2="16" y2="21"></line>
                    <line x1="12" y1="17" x2="12" y2="21"></line>
                </svg>
                <span class="nav-text ml-3 text-sm font-medium">Jobs</span>
                <span class="nav-text ml-auto px-1.5 py-0.5 bg-orange-500/20 text-orange-400 text-xs rounded-full font-medium">PRO</span>
            </a>
            
            <!-- Applications (Premium) -->
            <a href="#" class="nav-link flex items-center px-3 py-2.5 rounded-lg transition-colors relative cursor-pointer hover:bg-[var(--bg-hover)]" data-premium="true" title="Funcionalidad Premium">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14,2 14,8 20,8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10,9 9,9 8,9"></polyline>
                </svg>
                <span class="nav-text ml-3 text-sm font-medium">Applications</span>
                <span class="nav-text ml-auto px-1.5 py-0.5 bg-orange-500/20 text-orange-400 text-xs rounded-full font-medium">PRO</span>
            </a>
            
            <!-- Team (Premium) -->
            <a href="#" class="nav-link flex items-center px-3 py-2.5 rounded-lg transition-colors relative cursor-pointer hover:bg-[var(--bg-hover)]" data-premium="true" title="Funcionalidad Premium">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span class="nav-text ml-3 text-sm font-medium">Team</span>
                <span class="nav-text ml-auto px-1.5 py-0.5 bg-orange-500/20 text-orange-400 text-xs rounded-full font-medium">PRO</span>
            </a>
            
            <!-- Reports (Premium) -->
            <a href="#" class="nav-link flex items-center px-3 py-2.5 rounded-lg transition-colors relative cursor-pointer hover:bg-[var(--bg-hover)]" data-premium="true" title="Funcionalidad Premium">
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
                <span class="nav-text ml-auto px-1.5 py-0.5 bg-orange-500/20 text-orange-400 text-xs rounded-full font-medium">PRO</span>
            </a>
        </nav>
    </aside>        <!-- Main Content -->
        <div id="main-content" class="main-content flex-1 flex flex-col">
            <!-- Header -->
            <header class="header flex flex-col md:flex-row justify-between items-center mb-6 py-4 px-6 lg:px-10">
                <div class="flex items-center space-x-4 w-full md:w-auto">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-bold text-[var(--text-headings)] leading-tight">Plataforma SmartPeak</h1>
                        <p class="text-[var(--text-secondary)] text-sm">Bienvenido a la versión de demostración de SmartPeak</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <!-- Premium Action Buttons -->
                    <div class="hidden md:flex items-center space-x-2">
                        <!-- Actualizar información (Premium) -->
                        <div class="relative flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] transition-colors cursor-pointer" title="Funcionalidad Premium" data-premium="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                                <path d="M21 3v5h-5"/>
                                <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                                <path d="M3 21v-5h5"/>
                            </svg>
                            <span class="text-sm font-medium">Actualizar</span>
                            <span class="absolute -top-1 -right-1 px-1 py-0.5 bg-orange-500 text-white text-xs rounded-full font-bold animate-pulse">PRO</span>
                        </div>
                        
                        <!-- Generar informe detallado (Premium) -->
                        <div class="relative flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] transition-colors cursor-pointer" title="Funcionalidad Premium" data-premium="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10 9 9 9 8 9"/>
                            </svg>
                            <span class="text-sm font-medium">PDF</span>
                            <span class="absolute -top-1 -right-1 px-1 py-0.5 bg-orange-500 text-white text-xs rounded-full font-bold animate-pulse">PRO</span>
                        </div>
                        
                        <!-- Ver históricos (Premium) -->
                        <div class="relative flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] transition-colors cursor-pointer" title="Funcionalidad Premium" data-premium="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                <line x1="1" y1="10" x2="23" y2="10"/>
                            </svg>
                            <span class="text-sm font-medium">Históricos</span>
                            <span class="absolute -top-1 -right-1 px-1 py-0.5 bg-orange-500 text-white text-xs rounded-full font-bold animate-pulse">PRO</span>
                        </div>
                        
                        <div class="h-6 w-px bg-[var(--border-color)]"></div>
                    </div>
                    
                    <!-- Mobile Premium Actions Menu -->
                    <div class="md:hidden relative group">
                        <button class="p-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-secondary)] hover:text-[var(--text-primary)]" title="Opciones Premium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="1"/>
                                <circle cx="12" cy="5" r="1"/>
                                <circle cx="12" cy="19" r="1"/>
                            </svg>
                            <span class="absolute -top-1 -right-1 px-1 py-0.5 bg-orange-500 text-white text-xs rounded-full font-bold">PRO</span>
                        </button>
                        
                        <!-- Mobile Premium Dropdown -->
                        <div class="absolute right-0 top-full mt-2 w-56 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-3 border-b border-[var(--border-color)]">
                                <p class="font-medium text-orange-400 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                        <polygon points="12 2 15.09 8.26 22 9 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9 8.91 8.26 12 2"/>
                                    </svg>
                                    Funciones Premium
                                </p>
                                <p class="text-xs text-[var(--text-secondary)]">Actualiza para desbloquear</p>
                            </div>
                            <div class="p-2">
                                <div class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-primary)] cursor-pointer" data-premium="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                                        <path d="M21 3v5h-5"/>
                                        <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                                        <path d="M3 21v-5h5"/>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="font-medium">Actualizar información</p>
                                        <p class="text-xs text-[var(--text-secondary)]">Refrescar datos del dashboard</p>
                                    </div>
                                    <span class="px-2 py-1 bg-orange-500/20 text-orange-400 text-xs rounded-full">PRO</span>
                                </div>
                                <div class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-primary)] cursor-pointer" data-premium="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                        <polyline points="10 9 9 9 8 9"/>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="font-medium">Generar informe detallado</p>
                                        <p class="text-xs text-[var(--text-secondary)]">Descargar reporte en PDF</p>
                                    </div>
                                    <span class="px-2 py-1 bg-orange-500/20 text-orange-400 text-xs rounded-full">PRO</span>
                                </div>
                                <div class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-[var(--bg-hover)] text-[var(--text-primary)] cursor-pointer" data-premium="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                        <line x1="1" y1="10" x2="23" y2="10"/>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="font-medium">Ver históricos</p>
                                        <p class="text-xs text-[var(--text-secondary)]">Consultar datos anteriores</p>
                                    </div>
                                    <span class="px-2 py-1 bg-orange-500/20 text-orange-400 text-xs rounded-full">PRO</span>
                                </div>
                                <div class="mt-3 pt-3 border-t border-[var(--border-color)]">
                                    <button class="w-full px-3 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors text-sm font-medium" onclick="showPremiumModal()">
                                        🚀 Actualizar a Premium
                                    </button>
                                </div>
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
                            <img src="https://placehold.co/40x40/f97316/ffffff?text=D" alt="Demo User" class="w-10 h-10 rounded-full">
                            <span class="font-medium text-[var(--text-headings)]">Usuario Demo</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[var(--text-secondary)]">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </div>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 top-full mt-2 w-48 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-3 border-b border-[var(--border-color)]">
                                <p class="font-medium text-[var(--text-headings)]">Usuario Demo</p>
                                <p class="text-sm text-[var(--text-secondary)]">Versión de prueba</p>
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

            <!-- Demo Expiration Warning -->
            @if(auth()->user() && auth()->user()->expiration_date)
                <div class="mx-6 mb-4 p-4 rounded-lg flex items-center space-x-3 border 
                    {{ \Carbon\Carbon::parse(auth()->user()->expiration_date)->isFuture() ? 
                       'bg-orange-500/10 border-orange-500/30 text-orange-400' : 
                       'bg-red-500/10 border-red-500/30 text-red-400' }}
                ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <div class="flex-1">
                        @if(\Carbon\Carbon::parse(auth()->user()->expiration_date)->isFuture())
                            <strong>Versión Demo.</strong> Tu acceso expira el {{ \Carbon\Carbon::parse(auth()->user()->expiration_date)->format('d/m/Y') }}.
                            <span class="block text-xs mt-1 opacity-80">Actualiza a Premium para obtener acceso completo y sin restricciones.</span>
                        @else
                            <strong>Tu cuenta ha expirado.</strong> Contacta al administrador para renovar acceso.
                            <span class="block text-xs mt-1 opacity-80">Todas las funciones premium están bloqueadas.</span>
                        @endif
                    </div>
                    @if(\Carbon\Carbon::parse(auth()->user()->expiration_date)->isFuture())
                        <button onclick="showPremiumModal()" class="px-3 py-1 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors text-sm font-medium">
                            Actualizar
                        </button>
                    @endif
                </div>
            @endif

            <!-- Demo Data Source Info - Mes Pasado -->
            @if(isset($snapshot['isDemoMode']) && $snapshot['isDemoMode'])
                <div class="mx-6 mb-4 p-4 rounded-lg flex items-center space-x-3 border bg-blue-500/10 border-blue-500/30 text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                        <path d="M8 2v4"/>
                        <path d="M16 2v4"/>
                        <rect width="18" height="18" x="3" y="4" rx="2"/>
                        <path d="M3 10h18"/>
                        <path d="M8 14h.01"/>
                        <path d="M12 14h.01"/>
                        <path d="M16 14h.01"/>
                        <path d="M8 18h.01"/>
                        <path d="M12 18h.01"/>
                    </svg>
                    <div class="flex-1">
                        <strong>Datos de {{ $snapshot['demoInfo']['month_spanish'] ?? 'Mes Anterior' }}.</strong> 
                        @if(isset($snapshot['demoInfo']['is_simulated']) && !$snapshot['demoInfo']['is_simulated'])
                            Mostrando información real del mes pasado.
                            <span class="block text-xs mt-1 opacity-80">
                                Datos reales disponibles: {{ $snapshot['demoInfo']['data_count'] ?? 0 }} registros
                            </span>
                        @else
                            Mostrando datos simulados del mes pasado para demostración.
                            <span class="block text-xs mt-1 opacity-80">
                                Los datos son simulados porque no hay información real disponible de {{ $snapshot['demoInfo']['month_spanish'] ?? 'ese período' }}
                            </span>
                        @endif
                    </div>
                    
                    <!-- Botón para refrescar datos demo -->
                    <form method="POST" action="{{ route('demo.dashboard.refresh') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-sm font-medium flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                                <path d="M21 3v5h-5"/>
                                <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                                <path d="M3 21v-5h5"/>
                            </svg>
                            <span>Refrescar</span>
                        </button>
                    </form>
                </div>
            @endif

            <!-- Main Dashboard -->
            <main class="flex-1 p-6 space-y-6">
                <?php 
                    // Usar datos reales de la base de datos o del snapshot
                    $s = $snapshot ?? null;
                    if ($s) {
                        $riskLevel = $s['riskLevel'] ?? 'No procede';
                        $riskPercent = (int)($s['riskPercent'] ?? 0);
                        $labels = $s['labels'] ?? [];
                        $series = $s['series'] ?? [];
                        $peakFrom = $s['peakFrom'] ?? null;
                        $peakTo = $s['peakTo'] ?? null;
                        $todayEvalDate = $s['todayEvalDate'] ?? null;
                        $hasToday = (bool)($s['hasToday'] ?? false);
                        $hasMonthly = (bool)($s['hasMonthly'] ?? false);
                        $monthData = $s['monthData'] ?? [];
                    } else {
                        // Obtener datos reales de la base de datos
                        $todayEval = \App\Models\RiskEvaluation::today() ?? \App\Models\RiskEvaluation::orderBy('evaluation_date','desc')->first();
                        $map = config('risk.percentages');
                        $riskLevel = $todayEval?->risk_level ?? null;
                        $latestMonth = null;
                        if (!$riskLevel) {
                            $latestMonth = \App\Models\MonthlyRiskData::orderBy('year','desc')->orderBy('month','desc')->orderBy('day','desc')->first();
                            $riskLevel = $latestMonth?->risk_level ?? 'No procede';
                        }
                        $todayEvalDate = $todayEval?->evaluation_date?->toDateString();
                        $hasToday = $todayEval !== null;
                        $hasMonthly = $latestMonth !== null;
                        $riskPercent = $map[$riskLevel] ?? 0;
                        $startH = $todayEval?->start_time ? (int)\Carbon\Carbon::parse($todayEval->start_time)->format('H') : null;
                        $endH = $todayEval?->end_time ? (int)\Carbon\Carbon::parse($todayEval->end_time)->format('H') : null;
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
                        // Construir monthData desde el snapshot del demo
                        $monthData = $snapshot['monthData'] ?? [];
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
                                            <span class="demo-badge px-2 py-1 text-xs rounded-full">DEMO</span>
                                        </h2>
                                        
                                        <!-- Alerta de Riesgo Mejorada y Más Visible - DEMO -->
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
                                                                        NIVEL {{ strtoupper($riskLevel) }} - DEMO
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
                                  
                                        <div class="text-xs text-[var(--text-secondary)] text-right">
                                            @if(isset($snapshot['isDemoMode']) && $snapshot['isDemoMode'])
                                                <div>{{ $snapshot['demoInfo']['is_simulated'] ? 'Demo: Datos simulados' : 'Demo: Datos reales' }}</div>
                                            @else
                                                <div>Demo: Datos simulados</div>
                                            @endif
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
                            
                            <!-- Badge DEMO -->
                            <div class="text-center mb-4">
                                <span class="demo-badge px-3 py-1 text-xs rounded-full font-semibold border border-orange-500/30">DEMO</span>
                            </div>
                            
                            <div class="text-center mb-6">
                                <h2 class="text-2xl font-bold mb-2" style="color: var(--text-headings);">Evaluación de Riesgo Diario</h2>
                                <p id="fullDate" class="text-sm mb-4" style="color: var(--text-secondary);">
                                    @if(isset($snapshot['isDemoMode']) && $snapshot['isDemoMode'])
                                        {{ \Carbon\Carbon::now('America/Lima')->subMonth()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }} (Demo)
                                    @else
                                        {{ \Carbon\Carbon::now('America/Lima')->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                                    @endif
                                </p>
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
                                <canvas id="riskGaugeDemo" width="300" height="192"></canvas>
                                <!-- Valor del porcentaje debajo del medidor -->
                                <div class="absolute left-1/2 -translate-x-1/2 text-center" style="bottom: -58px;">
                                    <div id="riskValueDemo" class="text-4xl font-bold" style="color: var(--text-headings);">{{ $riskPercent ?? 0 }}%</div>
                                    <div class="text-sm font-bold" style="color: var(--text-secondary);">RIESGO</div>
                                </div>
                            </div>

                            <!-- Leyenda y hora de mayor riesgo -->
                            <div class="mt-6 space-y-4">
                                <div id="riskLegendDemo" class="flex flex-wrap justify-center items-center gap-x-4 gap-y-2 text-xs risk-gauge-legend">
                                    <!-- La leyenda se genera con JavaScript -->
                                </div>
                                <div class="text-center p-4 rounded-lg bg-gradient-to-r from-red-500/10 to-orange-500/10 border border-red-500/20">
                                    <p class="text-xs uppercase tracking-wider font-medium mb-2" style="color: var(--text-secondary);">Hora de Mayor Riesgo</p>
                                    <p id="riskHourDemo" class="text-2xl font-bold text-red-400">{{ $peakFrom && $peakTo ? "$peakFrom - $peakTo" : 'N/A' }}</p>
                                </div>
                                
                                <!-- Demo Limitation Notice -->
                                <div class="p-3 rounded-lg bg-orange-500/10 border border-orange-500/20 text-xs" style="color: var(--text-secondary);">
                                    <strong>Versión Demo:</strong> Esta evaluación está basada en datos simulados. Para análisis reales, actualiza a la versión completa.
                                </div>
                            </div>

                        </div>
                    </div>

            <!-- CALENDARIO MENSUAL - Individual -->
            <div class="card p-6">
                <h2 class="text-xl font-semibold text-[var(--text-headings)] mb-4">
                    Previsión {{ $snapshot['demoInfo']['month_spanish'] ?? 'Mes Anterior' }} (Demo)
                </h2>
                <div class="grid grid-cols-7 gap-y-2 text-center text-sm">
                    <div class="font-bold text-[var(--text-secondary)]">L</div><div class="font-bold text-[var(--text-secondary)]">M</div><div class="font-bold text-[var(--text-secondary)]">X</div><div class="font-bold text-[var(--text-secondary)]">J</div><div class="font-bold text-[var(--text-secondary)]">V</div><div class="font-bold text-[var(--text-secondary)]">S</div><div class="font-bold text-[var(--text-secondary)]">D</div>                            @php
                                // En modo demo, usar fecha del mes pasado
                                if(isset($snapshot['isDemoMode']) && $snapshot['isDemoMode']) {
                                    $currentDate = \Carbon\Carbon::now('America/Lima')->subMonth();
                                } else {
                                    $currentDate = \Carbon\Carbon::now('America/Lima');
                                }
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
                    
            <!-- PREDICCIÓN DETALLADA Y ALERTAS - Combinado (Demo) -->
            <div class="card p-6">
                <!-- Encabezado combinado -->
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-[var(--text-headings)]">Predicción y Alertas (Demo)</h2>
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
                                    @if(isset($snapshot['isDemoMode']) && $snapshot['isDemoMode'])
                                        <span class="font-medium">{{ $snapshot['demoInfo']['month_spanish'] ?? 'Mes Anterior' }}</span>
                                    @else
                                        <span class="font-medium">Hoy</span>
                                    @endif
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
                
                <div class="text-xs text-[var(--text-secondary)] mt-4 text-center">
                    * Datos de demostración - Funcionalidad completa disponible en versión premium
                </div>
            </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Modal Premium Benefits -->
    <div id="premiumModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="premium-modal-card w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <div class="relative p-6 z-10">
                <!-- Botón de cerrar -->
                <button onclick="closePremiumModal()" class="absolute top-6 right-6 text-[var(--text-secondary)] hover:text-[var(--text-headings)] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 6-12 12"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>

                <!-- Encabezado -->
                <div class="text-center mb-6">
                    <h2 class="text-3xl font-bold tracking-tight text-[var(--text-headings)]">SmartPeak Premium</h2>
                    <p class="text-[var(--text-secondary)] mt-2">Desbloquea todo el potencial de tu energía.</p>
                </div>

                <!-- Lista de Características -->
                <div class="space-y-4 mb-6">
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-blue-400 mr-4 flex-shrink-0">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-[var(--text-headings)]">Análisis Avanzado en Tiempo Real</h3>
                            <p class="text-[var(--text-secondary)] text-sm">Monitoreo continuo con alertas y predicciones precisas.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-blue-400 mr-4 flex-shrink-0">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-[var(--text-headings)]">Reportes Detallados y Exportación</h3>
                            <p class="text-[var(--text-secondary)] text-sm">Genera reportes en PDF, Excel y obtén análisis históricos.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-blue-400 mr-4 flex-shrink-0">
                            <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 0 2l-.15.08a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l-.22-.38a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1 0-2l.15.08a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-[var(--text-headings)]">Configuración Avanzada</h3>
                            <p class="text-[var(--text-secondary)] text-sm">Personaliza parámetros, umbrales y alertas específicas.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-blue-400 mr-4 flex-shrink-0">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-[var(--text-headings)]">Soporte Técnico Especializado</h3>
                            <p class="text-[var(--text-secondary)] text-sm">Acceso prioritario a nuestro equipo de expertos 24/7.</p>
                        </div>
                    </div>
                </div>

                <!-- Precio -->
                <div class="text-center mb-6">
                    <span class="text-5xl font-black text-[var(--text-headings)]">S/. 299</span>
                    <span class="text-[var(--text-secondary)]">/mes</span>
                    <p class="text-sm mt-2 text-[var(--text-secondary)]">Incluye todas las funciones premium y soporte completo.</p>
                </div>

                <!-- Botones de Acción -->
                <div class="flex flex-col space-y-4">
                    <button onclick="contactSales()" class="btn-primary font-bold py-3 px-6 rounded-lg w-full">
                        Contactar Ventas
                    </button>
                    <button onclick="startTrial()" class="btn-secondary font-bold py-3 px-6 rounded-lg w-full">
                        Prueba Gratuita 30 días
                    </button>
                </div>
                
                <!-- Contacto -->
                <div class="text-center mt-6">
                    <p class="text-sm text-[var(--text-secondary)]">¿Preguntas? Contacta a nuestro equipo: <a href="mailto:ventas@powergyma.com" class="text-blue-400 hover:text-blue-300 font-medium">ventas@powergyma.com</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let riskChart;

        function updateChartColors() {
            const isLight = document.documentElement.classList.contains('light');
            const gridColor = isLight ? '#e2e8f0' : '#475569';
            const textColor = isLight ? '#64748b' : '#94a3b8';

            // Update risk chart
            if (riskChart) {
                riskChart.options.scales.x.grid.color = gridColor;
                riskChart.options.scales.y.grid.color = gridColor;
                riskChart.options.scales.x.ticks.color = textColor;
                riskChart.options.scales.y.ticks.color = textColor;
                riskChart.update();
            }
        }

        function initializeCharts() {
            // Risk Chart
            const riskCtx = document.getElementById('riskChart').getContext('2d');
            const labels = @json($labels);
            const series = @json($series);

            riskChart = new Chart(riskCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Nivel de Riesgo (%)',
                        data: series,
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: function(context) {
                            const value = context.parsed.y;
                            if (value >= 66) return '#EF4444'; // Rojo para alto riesgo
                            if (value >= 36) return '#F59E0B'; // Amarillo para medio
                            return '#22C55E'; // Verde para bajo
                        },
                        pointBorderColor: function(context) {
                            const value = context.parsed.y;
                            if (value >= 66) return '#DC2626';
                            if (value >= 36) return '#D97706';
                            return '#16A34A';
                        },
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        fill: true,
                        tension: 0.4,
                        segment: {
                            borderColor: function(ctx) {
                                const value = ctx.p1.parsed.y;
                                if (value >= 66) return '#EF4444'; // Rojo
                                if (value >= 36) return '#F59E0B'; // Amarillo
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
                                    return `Riesgo ${level}: ${value}% (DEMO)`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { 
                                color: '#475569',
                                drawBorder: false 
                            },
                            ticks: { 
                                color: '#94a3b8',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Horario Crítico (17:00 - 00:00) - DEMO',
                                color: '#94a3b8',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        y: {
                            grid: { 
                                color: '#475569',
                                drawBorder: false 
                            },
                            ticks: { 
                                color: '#94a3b8',
                                callback: function(value) {
                                    return value + '%';
                                }
                            },
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Nivel de Riesgo (%)',
                                color: '#94a3b8',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
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
            // En modo demo, usar la fecha del mes anterior
            const now = new Date();
            const demoDate = new Date(now.getFullYear(), now.getMonth() - 1, now.getDate());
            
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                timeZone: 'America/Lima'
            };
            
            const dateFormatter = new Intl.DateTimeFormat('es-PE', options);
            const formattedDate = dateFormatter.format(demoDate);
            
            // Capitalizar la primera letra y formatear correctamente
            const finalDate = formattedDate.charAt(0).toUpperCase() + formattedDate.slice(1) + ' (Demo)';
            
            const fullDateElement = document.getElementById('fullDate');
            if (fullDateElement) {
                fullDateElement.textContent = finalDate;
            }
        }
        
        // Initialize charts after the DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
            animateRiskGauge();
            initializeRiskGaugeDemo();
            
            // Actualizar fecha inmediatamente
            updateDateAndTime();
            
            // Actualizar fecha cada minuto
            setInterval(updateDateAndTime, 60000);
        });

        // Función para animar el medidor de riesgo
        function animateRiskGauge() {
            const needle = document.getElementById('risk-needle');
            const riskValue = {{ $riskPercent ?? 0 }};
            
            if (needle) {
                // Calcular el ángulo basado en el porcentaje de riesgo
                // 0% = 180° (izquierda), 100% = 0° (derecha)
                const angle = 180 - (riskValue * 1.8);
                
                // Calcular las coordenadas finales de la aguja
                const centerX = 100;
                const centerY = 75;
                const needleLength = 40;
                const finalX = centerX + needleLength * Math.cos((angle * Math.PI) / 180);
                const finalY = centerY + needleLength * Math.sin((angle * Math.PI) / 180);
                
                // Aplicar la transformación con animación
                needle.style.transformOrigin = `${centerX}px ${centerY}px`;
                needle.style.transform = `rotate(${-angle + 90}deg)`;
                
                // Actualizar las coordenadas x2 e y2 de la línea
                needle.setAttribute('x2', finalX);
                needle.setAttribute('y2', finalY);

                // Activar la leyenda correspondiente
                const legendItems = document.querySelectorAll('.legend-item');
                legendItems.forEach(item => item.classList.remove('active'));
                
                if (riskValue <= 33) {
                    document.querySelector('[data-risk-level="low"]')?.classList.add('active');
                } else if (riskValue <= 66) {
                    document.querySelector('[data-risk-level="medium"]')?.classList.add('active');
                } else {
                    document.querySelector('[data-risk-level="high"]')?.classList.add('active');
                }
            }
        }

        // Nueva funcionalidad para el medidor de riesgo mejorado (Demo)
        function initializeRiskGaugeDemo() {
            const canvas = document.getElementById('riskGaugeDemo');
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');
            const riskValueDisplay = document.getElementById('riskValueDemo');
            const riskStatusDisplay = document.getElementById('riskStatus');
            const riskLegendContainer = document.getElementById('riskLegendDemo');
            const riskHourDisplay = document.getElementById('riskHourDemo');

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
            let targetRisk = findCategoryMiddlePoint(actualRiskValue); 
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

        // Auto-refresh every 30 seconds (demo feature)
        setTimeout(() => {
            window.location.reload();
        }, 30000);

        // Premium Modal Functions
        function showPremiumModal() {
            const modal = document.getElementById('premiumModal');
            const modalContent = document.getElementById('modalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Animate modal appearance
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closePremiumModal() {
            const modal = document.getElementById('premiumModal');
            const modalContent = document.getElementById('modalContent');
            
            // Animate modal disappearance
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function contactSales() {
            // Simulate contact action
            showSuccessNotification(
                '¡Solicitud Enviada Exitosamente!',
                'Gracias por tu interés en SmartPeak Premium. Nuestro equipo de ventas se pondrá en contacto contigo en las próximas 24 horas.',
                'Te contactaremos al teléfono y correo electrónico registrados.'
            );
            closePremiumModal();
        }

        function startTrial() {
            // Simulate trial start
            showSuccessNotification(
                '¡Excelente! Prueba Gratuita Activada',
                'Te enviaremos las instrucciones para iniciar tu prueba gratuita de 30 días por correo electrónico en los próximos minutos.',
                'Revisa tu bandeja de entrada y carpeta de spam.'
            );
            closePremiumModal();
        }

        function showSuccessNotification(title, message, subtitle) {
            // Crear el HTML de la notificación
            const notificationHTML = `
                <div id="successNotification" class="fixed top-6 right-6 z-[60] transform translate-x-full transition-all duration-500 ease-out">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-6 rounded-xl shadow-2xl max-w-md border border-green-400/30">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                        <polyline points="22 4 12 14.01 9 11.01"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold text-white">${title}</h3>
                                        <p class="text-sm text-green-100 mt-1 leading-relaxed">${message}</p>
                                        ${subtitle ? `<p class="text-xs text-green-200 mt-2 font-medium">${subtitle}</p>` : ''}
                                    </div>
                                    <button onclick="closeNotification()" class="ml-4 text-white/80 hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m18 6-12 12"/>
                                            <path d="m6 6 12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Barra de progreso -->
                        <div class="mt-4 bg-white/20 rounded-full h-1 overflow-hidden">
                            <div class="progress-bar bg-white h-full rounded-full" style="width: 0%; transition: width 6s linear;"></div>
                        </div>
                    </div>
                </div>
            `;

            // Insertar la notificación en el DOM
            document.body.insertAdjacentHTML('beforeend', notificationHTML);
            
            const notification = document.getElementById('successNotification');
            const progressBar = notification.querySelector('.progress-bar');

            // Animar la entrada
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
                notification.classList.add('translate-x-0');
            }, 100);

            // Iniciar la barra de progreso
            setTimeout(() => {
                progressBar.style.width = '100%';
            }, 200);

            // Auto-cerrar después de 6 segundos
            setTimeout(() => {
                closeNotification();
            }, 6000);
        }

        function closeNotification() {
            const notification = document.getElementById('successNotification');
            if (notification) {
                notification.classList.add('translate-x-full');
                notification.classList.remove('translate-x-0');
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }
        }

        function initializePremiumHandlers() {
            // Add click handlers to all premium elements
            const premiumElements = document.querySelectorAll('[title="Funcionalidad Premium"], .cursor-not-allowed, [data-premium="true"]');
            
            premiumElements.forEach(element => {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    showPremiumModal();
                });
                
                // Add premium styling
                element.style.cursor = 'pointer';
            });
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('premiumModal');
            if (e.target === modal) {
                closePremiumModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePremiumModal();
            }
        });

        // Initialize premium handlers when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initializePremiumHandlers();
            initializeSidebarToggle();
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

    </script>
</body>
</html>
