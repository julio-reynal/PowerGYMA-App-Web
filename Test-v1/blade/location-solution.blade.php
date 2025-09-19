<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎯 SOLUCION FINAL - Selectores de Ubicación</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
            font-size: 2.2em;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1em;
        }
        .form-group {
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 1.1em;
        }
        select {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            background: white;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        select.loading {
            opacity: 0.6;
            pointer-events: none;
            background: #f8f9fa;
        }
        .status-card {
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .status-card.success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        .status-card.error {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        .status-card.info {
            background: #d1ecf1;
            color: #0c5460;
            border: 2px solid #bee5eb;
        }
        .test-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
        }
        .test-button {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
            transition: background 0.3s ease;
        }
        .test-button:hover {
            background: #5a67d8;
        }
        .selection-display {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            font-family: monospace;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎯 SOLUCION FINAL</h1>
        <p class="subtitle">Selectores de Ubicación - Funcionando al 100%</p>
        
        <div id="status" class="status-card info">Inicializando sistema...</div>

        <form>
            <div class="form-group">
                <label for="departamento_id">🏛️ Departamento *</label>
                <select id="departamento_id" name="departamento_id" required>
                    <option value="">Cargando departamentos...</option>
                </select>
            </div>

            <div class="form-group">
                <label for="provincia_id">🏘️ Provincia *</label>
                <select id="provincia_id" name="provincia_id" required>
                    <option value="">Primero seleccione un departamento</option>
                </select>
            </div>

            <div class="selection-display" id="selection-display">
                <strong>Selección actual:</strong><br>
                Departamento: <span id="selected-dept">Ninguno</span><br>
                Provincia: <span id="selected-prov">Ninguna</span>
            </div>
        </form>

        <div class="test-section">
            <h3>🧪 Pruebas Rápidas</h3>
            <button type="button" class="test-button" onclick="testSelectLima()">Seleccionar Lima</button>
            <button type="button" class="test-button" onclick="testSelectArequipa()">Seleccionar Arequipa</button>
            <button type="button" class="test-button" onclick="testReset()">Resetear</button>
            <button type="button" class="test-button" onclick="testCache()">Verificar Cache</button>
        </div>
    </div>

    <!-- Cargar componente corregido -->
    <script src="{{ asset('resources/js/location-selector-fixed.js') }}"></script>
    <script>
        let locationSelector;

        function updateStatus(message, type = 'info') {
            const statusEl = document.getElementById('status');
            statusEl.textContent = message;
            statusEl.className = `status-card ${type}`;
        }

        function updateSelectionDisplay(deptName = 'Ninguno', provName = 'Ninguna') {
            document.getElementById('selected-dept').textContent = deptName;
            document.getElementById('selected-prov').textContent = provName;
        }

        // Funciones de prueba
        function testSelectLima() {
            console.log('🧪 Test: Seleccionar Lima');
            locationSelector.selectDepartamento(15); // Lima tiene ID 15
        }

        function testSelectArequipa() {
            console.log('🧪 Test: Seleccionar Arequipa');
            locationSelector.selectDepartamento(4); // Arequipa tiene ID 4
        }

        function testReset() {
            console.log('🧪 Test: Reset');
            locationSelector.reset();
            updateSelectionDisplay();
            updateStatus('Sistema reseteado', 'info');
        }

        function testCache() {
            console.log('🧪 Test: Verificar cache');
            const cacheInfo = {
                departamentos: locationSelector.cache.departamentos ? locationSelector.cache.departamentos.length : 0,
                provincias: locationSelector.cache.provincias.size
            };
            updateStatus(`Cache: ${cacheInfo.departamentos} deps, ${cacheInfo.provincias} provs`, 'info');
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Iniciando sistema de ubicaciones...');
            updateStatus('Inicializando LocationSelector...', 'info');
            
            try {
                // Inicializar componente
                locationSelector = new LocationSelector({
                    departamentoSelectId: 'departamento_id',
                    provinciaSelectId: 'provincia_id',
                    apiBaseUrl: '/api/v1',
                    loadOnInit: true
                });

                // Eventos del sistema
                document.addEventListener('departamentoLoaded', function(event) {
                    updateStatus(`✅ ${event.detail.count} departamentos cargados exitosamente`, 'success');
                });

                document.addEventListener('provinciasLoaded', function(event) {
                    updateStatus(`✅ ${event.detail.count} provincias cargadas para el departamento`, 'success');
                });

                document.addEventListener('departamentoChanged', function(event) {
                    const dept = event.detail.departamento;
                    updateSelectionDisplay(dept.nombre, 'Ninguna');
                    updateStatus(`🏛️ Departamento seleccionado: ${dept.nombre}`, 'success');
                });

                document.addEventListener('provinciaChanged', function(event) {
                    const prov = event.detail.provincia;
                    const currentDept = document.getElementById('selected-dept').textContent;
                    updateSelectionDisplay(currentDept, prov.nombre);
                    updateStatus(`🏘️ Provincia seleccionada: ${prov.nombre}`, 'success');
                });

                document.addEventListener('error', function(event) {
                    updateStatus(`❌ Error: ${event.detail.message}`, 'error');
                });

                updateStatus('✅ Sistema inicializado correctamente', 'success');

            } catch (error) {
                console.error('❌ Error fatal:', error);
                updateStatus(`❌ Error fatal: ${error.message}`, 'error');
            }
        });
    </script>
</body>
</html>
