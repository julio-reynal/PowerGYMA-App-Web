<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Power GYMA') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Tailwind CSS CDN for immediate testing -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {}
            }
        }
    </script>
    
    <!-- Dark Mode Initial Script -->
    <script>
        // Aplicar tema inmediatamente para evitar flash
        (function() {
            const theme = localStorage.getItem('powergyma_theme') || 'light';
            console.log('🎨 Tema inicial desde localStorage:', theme);
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                console.log('🌙 Aplicando modo oscuro inicial');
            } else {
                document.documentElement.classList.remove('dark');
                console.log('☀️ Aplicando modo claro inicial');
            }
        })();
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @yield('additional-styles')
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <div x-data="{ 
        sidebarOpen: false,
        init() {
            // Cerrar sidebar con tecla Escape
            this.$watch('sidebarOpen', value => {
                if (value) {
                    document.addEventListener('keydown', this.handleEscape);
                } else {
                    document.removeEventListener('keydown', this.handleEscape);
                }
            });
        },
        handleEscape(e) {
            if (e.key === 'Escape') {
                this.sidebarOpen = false;
            }
        }
    }">
        <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Sidebar -->
            @include('layouts.partials.sidebar')

            <div class="flex-1 flex flex-col overflow-hidden lg:ml-64">
                @include('layouts.partials.header')
                <!-- Main Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900 p-6">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Theme Toggle Script - VERSIÓN COMPLETA -->
    <script>
        console.log('🚀 Cargando sistema de temas...');
        
        // Variables globales
        let currentTheme = localStorage.getItem('powergyma_theme') || 'light';
        
        // Función principal para cambiar tema
        function toggleTheme() {
            console.log('🔄 INICIO - toggleTheme ejecutado');
            console.log('📋 Tema actual:', currentTheme);
            
            // Cambiar tema
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            currentTheme = newTheme;
            
            console.log('� Cambiando a tema:', newTheme);
            
            // Aplicar al HTML
            const html = document.documentElement;
            
            if (newTheme === 'dark') {
                html.classList.add('dark');
                html.classList.remove('light');
                console.log('🌙 Clases aplicadas - MODO OSCURO');
            } else {
                html.classList.remove('dark');
                html.classList.add('light');
                console.log('☀️ Clases aplicadas - MODO CLARO');
            }
            
            // Guardar en localStorage
            localStorage.setItem('powergyma_theme', newTheme);
            console.log('💾 Tema guardado en localStorage:', newTheme);
            
            // Actualizar iconos
            updateThemeIcons(newTheme);
            
            // Verificar que se aplicó
            setTimeout(() => {
                const hasClass = html.classList.contains('dark');
                console.log('✅ Verificación final - HTML tiene clase "dark":', hasClass);
                console.log('📋 Clases actuales del HTML:', html.classList.toString());
            }, 100);
            
            console.log('✅ FIN - toggleTheme completado');
        }

        // Función para actualizar iconos
        function updateThemeIcons(theme) {
            console.log('🔄 Actualizando iconos para tema:', theme);
            
            const lightIcon = document.getElementById('theme-icon-light');
            const darkIcon = document.getElementById('theme-icon-dark');
            
            if (lightIcon && darkIcon) {
                if (theme === 'dark') {
                    lightIcon.style.display = 'none';
                    darkIcon.style.display = 'inline-block';
                    console.log('🌙 Iconos: Mostrando sol (modo oscuro)');
                } else {
                    lightIcon.style.display = 'inline-block';
                    darkIcon.style.display = 'none';
                    console.log('☀️ Iconos: Mostrando luna (modo claro)');
                }
            } else {
                console.log('⚠️ ERROR: No se encontraron iconos');
                console.log('lightIcon:', lightIcon);
                console.log('darkIcon:', darkIcon);
            }
        }

        // Función para aplicar tema
        function applyInitialTheme() {
            console.log('🎯 Aplicando tema inicial:', currentTheme);
            
            const html = document.documentElement;
            
            if (currentTheme === 'dark') {
                html.classList.add('dark');
                html.classList.remove('light');
                console.log('🌙 Tema inicial: OSCURO aplicado');
            } else {
                html.classList.remove('dark');
                html.classList.add('light');
                console.log('☀️ Tema inicial: CLARO aplicado');
            }
            
            // Actualizar iconos después de un delay
            setTimeout(() => {
                updateThemeIcons(currentTheme);
            }, 200);
        }

        // Inicializar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 DOM READY - Inicializando sistema de temas');
            console.log('📋 Tema detectado:', currentTheme);
            
            // Aplicar tema inicial
            applyInitialTheme();
            
            console.log('✅ Sistema de temas inicializado completamente');
        });

        // Test function para debug
        function testTheme() {
            console.log('🧪 TEST - Estado actual del tema:');
            console.log('- currentTheme:', currentTheme);
            console.log('- localStorage:', localStorage.getItem('powergyma_theme'));
            console.log('- HTML classes:', document.documentElement.classList.toString());
            console.log('- Has dark class:', document.documentElement.classList.contains('dark'));
        }
        
        // Hacer función disponible globalmente para testing
        window.testTheme = testTheme;
        window.toggleTheme = toggleTheme;
    </script>

    @stack('scripts')
        </div> <!-- Cierre div flex -->
    </div> <!-- Cierre div Alpine.js -->
</body>
</html>
