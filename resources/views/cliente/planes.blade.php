<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Planes de Entrenamiento - Cliente</title>
    <style>
        body { font-family: system-ui, sans-serif; background:#f8fafc; color:#0f172a; margin:0; }
        .container{ max-width:900px;margin:2rem auto;padding:0 1.25rem; }
        .card{ background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:1.5rem; }
        a{ color:#1d4ed8; text-decoration:none; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>Planes de Entrenamiento</h1>
        <p>Explora y gestiona tus planes de entrenamiento.</p>
        <p><a href="{{ route('cliente.dashboard') }}">Volver al dashboard</a></p>
    </div>
</div>
</body>
</html>
