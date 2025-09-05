<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Power GYMA - Portal de Clientes</title>
    
    <!-- Verificar si existe Vite manifest o usar fallback -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @try
            @vite(['resources/css/index.css', 'resources/js/index.js'])
        @catch(\Exception $e)
            <!-- Fallback CSS en caso de error de Vite -->
            <link href="{{ asset('resources/css/index.css') }}" rel="stylesheet">
            <script src="{{ asset('resources/js/index.js') }}" defer></script>
        @endtry
    @else
        <!-- Estilos inline de fallback -->
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            html, body { 
                height: 100%; 
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: #333;
            }
            .container {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 2rem;
                text-align: center;
            }
            .welcome-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 3rem 2rem;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                max-width: 500px;
                width: 100%;
            }
            .logo {
                width: 80px;
                height: 80px;
                background: #1d4ed8;
                border-radius: 50%;
                margin: 0 auto 1.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 2rem;
                font-weight: bold;
            }
            h1 {
                color: #1f2937;
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }
            .subtitle {
                color: #6b7280;
                font-size: 1.1rem;
                margin-bottom: 2rem;
                line-height: 1.6;
            }
            .btn {
                display: inline-block;
                background: linear-gradient(135deg, #1d4ed8, #3b82f6);
                color: white;
                padding: 1rem 2rem;
                border-radius: 12px;
                text-decoration: none;
                font-weight: 600;
                font-size: 1.1rem;
                transition: all 0.3s ease;
                box-shadow: 0 10px 15px -3px rgba(29, 78, 216, 0.1), 0 4px 6px -2px rgba(29, 78, 216, 0.05);
                margin: 0.5rem;
            }
            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 20px 25px -5px rgba(29, 78, 216, 0.1), 0 10px 10px -5px rgba(29, 78, 216, 0.04);
            }
            .btn.secondary {
                background: linear-gradient(135deg, #e5e7eb, #f3f4f6);
                color: #374151;
            }
            .user-info {
                background: #f0f9ff;
                border: 1px solid #0ea5e9;
                border-radius: 12px;
                padding: 1rem;
                margin-bottom: 1.5rem;
                color: #0c4a6e;
            }
        </style>
    @endif
</head>
<body>
    <div class="container">
        <div class="welcome-card">
            <div class="logo">PG</div>
            <h1>Power GYMA</h1>
            <p class="subtitle">Sistema de Gestión y Monitoreo de Energía</p>
            
            @auth
                <div class="user-info">
                    <strong>Bienvenido, {{ auth()->user()->name }}!</strong>
                    <p>Accede a tu panel de control personalizado</p>
                </div>
                <div>
                    <a href="{{ route('dashboard') }}" class="btn">Ir al Dashboard</a>
                    <a href="{{ route('logout.get') }}" class="btn secondary">Cerrar Sesión</a>
                </div>
            @else
                <p class="subtitle">Accede a tu portal exclusivo de cliente</p>
                <a href="{{ route('login') }}" class="btn">Acceso Clientes</a>
            @endauth
        </div>
    </div>
</body>
</html>
