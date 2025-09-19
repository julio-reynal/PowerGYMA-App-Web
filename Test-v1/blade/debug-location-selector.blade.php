<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug - Selectores de Ubicación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .debug-info {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        .info {
            color: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Debug - Selectores de Ubicación</h1>
        
        <div class="debug-info">
            <h3>📊 Estado del Sistema:</h3>
            <div id="system-status">Verificando...</div>
        </div>

        <form>
            <div class="form-group">
                <label for="departamento_id">Departamento *</label>
                <select id="departamento_id" name="departamento_id" required>
                    <option value="">Seleccione un departamento</option>
                </select>
            </div>

            <div class="form-group">
                <label for="provincia_id">Provincia *</label>
                <select id="provincia_id" name="provincia_id" required>
                    <option value="">Primero seleccione un departamento</option>
                </select>
            </div>

            <div class="debug-info">
                <h3>🔍 Log de Eventos:</h3>
                <div id="debug-log"></div>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('resources/js/location-selector.js') }}"></script>
    <script>
        // Logger para debug
        function logDebug(message, type = 'info') {
            const logElement = document.getElementById('debug-log');
            const timestamp = new Date().toLocaleTimeString();
            const logClass = type === 'error' ? 'error' : (type === 'success' ? 'success' : 'info');
            logElement.innerHTML += `<div class="${logClass}">[${timestamp}] ${message}</div>`;
        }

        // Sistema de status
        function updateStatus(message, type = 'info') {
            const statusElement = document.getElementById('system-status');
            const statusClass = type === 'error' ? 'error' : (type === 'success' ? 'success' : 'info');
            statusElement.innerHTML = `<span class="${statusClass}">${message}</span>`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            logDebug('🚀 DOM cargado, inicializando sistema...');
            
            try {
                // Verificar si la clase LocationSelector está disponible
                if (typeof LocationSelector === 'undefined') {
                    throw new Error('Clase LocationSelector no encontrada');
                }
                
                logDebug('✅ Clase LocationSelector encontrada');
                updateStatus('✅ Sistema iniciando...', 'success');

                // Inicializar el selector de ubicaciones
                const locationSelector = new LocationSelector({
                    departamentoSelectId: 'departamento_id',
                    provinciaSelectId: 'provincia_id',
                    apiBaseUrl: '/api/v1',
                    loadOnInit: true
                });

                logDebug('✅ LocationSelector inicializado');
                updateStatus('✅ Sistema funcionando correctamente', 'success');

                // Eventos personalizados para debug
                document.addEventListener('departamentoLoaded', function(event) {
                    logDebug(`📦 Departamentos cargados: ${event.detail.count}`, 'success');
                });

                document.addEventListener('departamentoChanged', function(event) {
                    logDebug(`🏛️ Departamento seleccionado: ${event.detail.departamento.nombre}`, 'info');
                });

                document.addEventListener('provinciasLoaded', function(event) {
                    logDebug(`🏘️ Provincias cargadas: ${event.detail.count}`, 'success');
                });

                document.addEventListener('provinciaChanged', function(event) {
                    logDebug(`🏘️ Provincia seleccionada: ${event.detail.provincia.nombre}`, 'info');
                });

                // Monitorear cambios en los selects
                document.getElementById('departamento_id').addEventListener('change', function(e) {
                    logDebug(`🔄 Select departamento cambió a: ${e.target.value}`, 'info');
                });

                document.getElementById('provincia_id').addEventListener('change', function(e) {
                    logDebug(`🔄 Select provincia cambió a: ${e.target.value}`, 'info');
                });

            } catch (error) {
                logDebug(`❌ Error: ${error.message}`, 'error');
                updateStatus(`❌ Error: ${error.message}`, 'error');
                console.error('Error en debug:', error);
            }
        });

        // Test manual de API
        function testAPI() {
            logDebug('🧪 Probando API manualmente...');
            
            fetch('/api/v1/locations/departamentos')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        logDebug(`✅ API responde: ${data.count} departamentos`, 'success');
                    } else {
                        logDebug(`❌ API error: ${data.message}`, 'error');
                    }
                })
                .catch(error => {
                    logDebug(`❌ API error: ${error.message}`, 'error');
                });
        }

        // Ejecutar test después de 2 segundos
        setTimeout(testAPI, 2000);
    </script>
</body>
</html>
