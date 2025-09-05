<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Power GYMA - Portal de Clientes</title>
    
    <!-- CSS inline para evitar problemas con Vite -->
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
            transition: transform 0.3s ease;
            animation: fadeInUp 0.6s ease-out;
        }
        .welcome-card:hover {
            transform: translateY(-5px);
        }
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            box-shadow: 0 10px 15px -3px rgba(29, 78, 216, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .logo:hover {
            transform: scale(1.05);
        }
        h1 {
            color: #1f2937;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #1d4ed8, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(29, 78, 216, 0.1), 0 10px 10px -5px rgba(29, 78, 216, 0.04);
            background: linear-gradient(135deg, #1e40af, #2563eb);
        }
        .btn:active {
            transform: translateY(0);
        }
        .btn.secondary {
            background: linear-gradient(135deg, #e5e7eb, #f3f4f6);
            color: #374151;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
        }
        .btn.secondary:hover {
            background: linear-gradient(135deg, #d1d5db, #e5e7eb);
            color: #1f2937;
        }
        .user-info {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border: 1px solid #0ea5e9;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            color: #0c4a6e;
            box-shadow: 0 4px 6px -1px rgba(14, 165, 233, 0.1);
        }
        .user-info strong {
            display: block;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #075985;
        }
        .user-info p {
            margin: 0;
            font-size: 0.95rem;
            opacity: 0.8;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @media (max-width: 640px) {
            .container { padding: 1rem; }
            .welcome-card { padding: 2rem 1.5rem; }
            h1 { font-size: 2rem; }
            .logo { width: 60px; height: 60px; font-size: 1.5rem; }
            .btn { padding: 0.8rem 1.5rem; font-size: 1rem; width: 100%; margin: 0.25rem 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-card">
            <div class="logo" id="logo">PG</div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Power GYMA - Página cargada correctamente');
            
            // Animación del logo
            const logo = document.getElementById('logo');
            if (logo) {
                logo.addEventListener('click', function() {
                    this.style.transform = 'scale(1.1) rotate(360deg)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 500);
                });
            }
            
            // Efectos en botones
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });
    </script>
</body>
</html>
