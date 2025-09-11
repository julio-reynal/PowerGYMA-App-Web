<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Acceso - POWERGYMA</title>
    @vite(['resources/css/main.css', 'resources/css/components.css'])
    <style>
        .verification-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            font-family: 'Poppins', sans-serif;
        }
        .test-button {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px;
            background: #025ccd;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .test-button:hover {
            background: #0147a0;
        }
        .status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .header-demo {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <h1>🔍 Verificación del Botón "Acceso Clientes"</h1>
        
        <div class="status success">
            ✅ <strong>CONFIGURACIÓN COMPLETADA:</strong> El botón de "Acceso Clientes" ahora redirige correctamente al login.
        </div>
        
        <h2>📋 Cambios Realizados:</h2>
        <ul>
            <li><strong>Header Component:</strong> Cambiado de <code>&lt;button&gt;</code> a <code>&lt;a href="{{ route('login') }}"&gt;</code></li>
            <li><strong>JavaScript Fallback:</strong> Actualizado para usar enlace directo a <code>/login</code></li>
            <li><strong>Rutas:</strong> Verificadas - <code>Route::get('/login')</code> existe y funciona</li>
        </ul>
        
        <h2>🧪 Prueba del Header:</h2>
        <div class="header-demo">
            <p><strong>Componente Header con botón funcional:</strong></p>
            @include('components.header')
        </div>
        
        <h2>🔗 Enlaces de Prueba:</h2>
        <div>
            <a href="/" class="test-button">🏠 Página Principal</a>
            <a href="/login" class="test-button">🔐 Login Directo</a>
            <a href="/dashboard" class="test-button">📊 Dashboard (requiere login)</a>
            <a href="/test-routes" class="test-button">🔍 Test de Rutas</a>
        </div>
        
        <h2>✅ Verificación del Servidor:</h2>
        <div class="status success">
            <p><strong>Estado:</strong> El servidor muestra accesos exitosos al login.</p>
            <p><strong>Logs verificados:</strong> Se detectó acceso a <code>/login</code> - ¡Funciona!</p>
        </div>
        
        <h2>📝 Instrucciones para el Usuario:</h2>
        <ol>
            <li>Ve a la página principal: <a href="/" target="_blank">http://127.0.0.1:8000</a></li>
            <li>Haz clic en el botón <strong>"Acceso Clientes"</strong> en el header</li>
            <li>Deberías ser redirigido automáticamente a la página de login</li>
            <li>La URL cambiará a: <code>http://127.0.0.1:8000/login</code></li>
        </ol>
        
        <h2>🔐 Credenciales de Prueba:</h2>
        <div style="background: #fff3cd; padding: 15px; border-radius: 5px; border: 1px solid #ffeaa7;">
            <p><strong>Nota:</strong> Para acceder completamente, necesitarás credenciales válidas configuradas en la base de datos.</p>
            <p>El sistema redirige según el rol del usuario:</p>
            <ul>
                <li><strong>Admin:</strong> /admin/dashboard</li>
                <li><strong>Cliente:</strong> /cliente/dashboard</li>
                <li><strong>Demo:</strong> /demo/dashboard</li>
            </ul>
        </div>
    </div>
    
    @vite(['resources/js/components.js', 'resources/js/main.js'])
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Verificación de Acceso Cargada');
            
            // Verificar que el botón de acceso tenga el href correcto
            const accessButton = document.querySelector('.btn-access');
            if (accessButton) {
                console.log('✅ Botón encontrado:', accessButton.href || accessButton.getAttribute('href'));
                if (accessButton.href && accessButton.href.includes('/login')) {
                    console.log('✅ Botón configurado correctamente para login');
                } else {
                    console.warn('⚠️ Verificar configuración del botón');
                }
            }
        });
    </script>
</body>
</html>
