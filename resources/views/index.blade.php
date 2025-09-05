<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Power GYMA</title>
  <style>
    body{font-family:system-ui, sans-serif; background:#f8fafc; color:#0f172a; margin:0}
    .container{max-width:800px;margin:4rem auto;padding:0 1.25rem;text-align:center}
    a.btn{display:inline-block;margin:.5rem;padding:.6rem 1rem;border-radius:8px;text-decoration:none}
    .primary{background:#1d4ed8;color:#fff}
    .secondary{background:#e2e8f0;color:#0f172a}
  </style>
  </head>
<body>
  <div class="container">
    <h1>Bienvenido a Power GYMA</h1>
    @auth
      <p>Hola, {{ auth()->user()->name }}.</p>
      <a href="{{ route('dashboard') }}" class="btn primary">Ir al Dashboard</a>
      <a href="{{ route('logout.get') }}" class="btn secondary">Cerrar sesión</a>
    @else
      <p>Por favor inicia sesión para continuar.</p>
      <a href="{{ route('login') }}" class="btn primary">Iniciar sesión</a>
    @endauth
  </div>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Power GYMA - Inicio</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/index.css', 'resources/js/index.js'])
    @else
        <style>
            html, body { height: 100%; margin: 0; background: #ffffff; font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; }
            .center { min-height: 100%; display: grid; place-items: center; }
            .btn { appearance: none; border: 0; background: #1d4ed8; color: #fff; padding: 14px 22px; border-radius: 8px; font-weight: 600; font-size: 16px; cursor: pointer; text-decoration: none; box-shadow: 0 4px 10px rgba(29,78,216,0.25); }
            .btn:hover { background: #1e40af; }
            .btn:active { transform: translateY(1px); }
        </style>
    @endif
</head>
<body>
    <main class="center">
        <a href="{{ route('login') }}" class="btn">Acceso Clientes</a>
    </main>
</body>
</html>
