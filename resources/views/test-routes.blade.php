<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Routes - POWERGYMA</title>
    @vite(['resources/css/main.css', 'resources/css/components.css'])
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background: #f5f5f5; 
        }
        .test-container { 
            max-width: 800px; 
            margin: 0 auto; 
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .test-item { 
            margin: 15px 0; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
        }
        .success { 
            background: #d4edda; 
            border-color: #c3e6cb; 
            color: #155724; 
        }
        .error { 
            background: #f8d7da; 
            border-color: #f5c6cb; 
            color: #721c24; 
        }
        .asset-test img {
            max-width: 100px;
            height: auto;
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1>Test de Rutas y Assets - PowerGYMA</h1>
        
        <div class="test-item success">
            <h3>✅ CSS cargado correctamente</h3>
            <p>Si ves este texto con estilos, el CSS se está cargando.</p>
        </div>
        
        <div class="test-item">
            <h3>🔍 Test de Imágenes</h3>
            <div class="asset-test">
                <p>Logo principal:</p>
                <img src="/assets/icons/7f131e3ebf5d584ec2316a2e8cf8d25184bccec0.svg" alt="Logo PowerGYMA" />
                
                <p>Imagen hero:</p>
                <img src="/assets/images/97f02ab9639ce7dbf4e3a155db14b6f38706498f.png" alt="Hero background" />
                
                <p>Servicio imagen:</p>
                <img src="/assets/images/5ba4c4d57238514056e49d7be097a785436ad1ab.png" alt="Service image" />
            </div>
        </div>
        
        <div class="test-item">
            <h3>🎨 Test de Componentes</h3>
            <header style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
                @include('components.header')
            </header>
        </div>
        
        <div class="test-item">
            <h3>📋 Rutas disponibles</h3>
            <ul>
                <li><a href="/" target="_blank">Página principal (/)</a></li>
                <li><a href="/login" target="_blank">Login (/login)</a></li>
                <li><a href="/dashboard" target="_blank">Dashboard (/dashboard)</a></li>
            </ul>
        </div>
        
        <div class="test-item">
            <h3>📁 Assets públicos</h3>
            <p>Verificar que estos archivos existen:</p>
            <ul>
                <li>/assets/icons/ - Iconos SVG</li>
                <li>/assets/images/ - Imágenes PNG/JPG</li>
                <li>/build/ - Assets compilados por Vite</li>
            </ul>
        </div>
    </div>
    
    @vite(['resources/js/components.js', 'resources/js/main.js'])
    
    <script>
        console.log('✅ JavaScript cargado correctamente');
        
        // Test de carga de imágenes
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.asset-test img');
            images.forEach(img => {
                img.onload = function() {
                    console.log('✅ Imagen cargada:', this.src);
                };
                img.onerror = function() {
                    console.error('❌ Error cargando imagen:', this.src);
                    this.style.border = '2px solid red';
                };
            });
        });
    </script>
</body>
</html>
