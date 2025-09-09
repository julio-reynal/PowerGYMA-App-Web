<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, viewport-fit=cover" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="theme-color" content="#1d4ed8" />
    <title>Iniciar sesión - Power GYMA</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Boxicons for consistent iconography with the mockup -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- CSS y JS siempre inline para evitar problemas con Vite -->
    <link href="{{ asset('resources/css/login.css') }}" rel="stylesheet">
    <script src="{{ asset('resources/js/login.js') }}" defer></script>
</head>
<body>
    <div class="login-container">
        <div class="left-panel">
            <div>
                <img src="{{ asset('Img/Ico/Ico-Pw.svg') }}" alt="Power GYMA Logo" class="logo">
                <div class="promo-text">
                    <h1>Controla tu consumo, potencia tu ahorro.hillaaaaaaa</h1>
                    <p>Accede a tu portal exclusivo y gestiona tus datos de manera inteligente.</p>
                </div>
            </div>
            <div class="copyright">
                © {{ date('Y') }} POWERGYMA. Todos los derechos reservados.
            </div>
        </div>
        <div class="right-panel">
            <div class="card-outer">
            <div class="login-card">
                <button id="theme-toggle" type="button" class="theme-toggle" aria-label="Cambiar tema">
                    <i class='bx bxs-moon'></i>
                </button>
                <div id="notification-container" class="notifications"></div>
                <div class="form-title">
                    <h2>POWERGYMA</h2>
                    <p>Bienvenido a tu portal de cliente</p>
                </div>

                @if (session('error'))
                    <div class="alert alert-server" data-type="error">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-server" data-type="error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <div class="input-wrapper">
                            <i class='bx bx-envelope icon'></i>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="nombre@ejemplo.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-wrapper password-wrapper">
                            <i class='bx bx-lock-alt icon'></i>
                            <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
                            <i class='bx bx-hide icon-toggle' id="togglePassword"></i>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" value="1"> Recordar mis datos
                        </label>
                        <a href="#" class="form-link">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button type="submit" class="btn-submit">
                        Iniciar Sesión <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
                
                <div class="support-link">
                    <a href="#" class="form-link">Contactar a Soporte</a>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
