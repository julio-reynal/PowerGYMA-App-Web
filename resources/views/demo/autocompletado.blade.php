<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASE 4: Autocompletado Avanzado - PowerGYMA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .header p {
            font-size: 1.2em;
            opacity: 0.9;
        }
        
        .demo-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }
        
        .demo-card:hover {
            transform: translateY(-5px);
        }
        
        .demo-title {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-input:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            outline: none;
        }
        
        .results-section {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #3498db;
        }
        
        .results-title {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: #2c3e50;
        }
        
        .result-item {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            border: 1px solid #e1e5e9;
        }
        
        .result-item strong {
            color: #3498db;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .feature-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .feature-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }
        
        .feature-title {
            font-size: 1.3em;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        
        .feature-description {
            color: #666;
            line-height: 1.6;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-success {
            background: #d4edda;
            color: #155724;
        }
        
        .status-info {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .status-warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .test-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: #27ae60;
            color: white;
        }
        
        .btn-success:hover {
            background: #229954;
            transform: translateY(-2px);
        }
        
        .btn-warning {
            background: #f39c12;
            color: white;
        }
        
        .btn-warning:hover {
            background: #e67e22;
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .header h1 {
                font-size: 2em;
            }
            
            .demo-card {
                padding: 20px;
            }
            
            .test-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 FASE 4: AUTOCOMPLETADO AVANZADO</h1>
            <p>Sistema de búsqueda inteligente para departamentos y provincias del Perú</p>
        </div>

        <!-- Demo Principal -->
        <div class="demo-card">
            <div class="demo-title">📍 Selector de Ubicación con Autocompletado</div>
            
            <form id="locationForm">
                <div class="form-group">
                    <label for="departamento_autocomplete" class="form-label">
                        🏛️ Departamento
                        <span class="status-badge status-info">Búsqueda en tiempo real</span>
                    </label>
                    <input type="text" 
                           id="departamento_autocomplete" 
                           class="form-input" 
                           placeholder="Escribe para buscar departamento..."
                           autocomplete="off">
                    <input type="hidden" id="departamento_id" name="departamento_id">
                </div>

                <div class="form-group">
                    <label for="provincia_autocomplete" class="form-label">
                        🏘️ Provincia
                        <span class="status-badge status-warning">Requiere departamento</span>
                    </label>
                    <input type="text" 
                           id="provincia_autocomplete" 
                           class="form-input" 
                           placeholder="Primero seleccione un departamento"
                           autocomplete="off"
                           disabled>
                    <input type="hidden" id="provincia_id" name="provincia_id">
                </div>
            </form>

            <div class="test-buttons">
                <button class="btn btn-primary" onclick="testDepartment('Lima')">🧪 Probar "Lima"</button>
                <button class="btn btn-primary" onclick="testDepartment('Cusco')">🧪 Probar "Cusco"</button>
                <button class="btn btn-primary" onclick="testDepartment('Ayacucho')">🧪 Probar "Ayacucho"</button>
                <button class="btn btn-warning" onclick="resetSelections()">🔄 Limpiar</button>
                <button class="btn btn-success" onclick="showSelectedData()">📊 Ver Datos</button>
            </div>

            <div id="results" class="results-section" style="display: none;">
                <div class="results-title">📋 Datos Seleccionados</div>
                <div id="results-content"></div>
            </div>
        </div>

        <!-- Características -->
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <div class="feature-title">Búsqueda Instantánea</div>
                <div class="feature-description">
                    Resultados en tiempo real con debounce de 300ms para optimizar performance
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🧠</div>
                <div class="feature-title">Búsqueda Inteligente</div>
                <div class="feature-description">
                    Búsqueda fuzzy que ignora acentos y encuentra coincidencias parciales
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">⌨️</div>
                <div class="feature-title">Navegación por Teclado</div>
                <div class="feature-description">
                    Soporte completo para flechas, Enter y Escape para navegación sin mouse
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">💾</div>
                <div class="feature-title">Caché Inteligente</div>
                <div class="feature-description">
                    Almacena resultados para mejorar velocidad y reducir solicitudes al servidor
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🎨</div>
                <div class="feature-title">Resaltado de Texto</div>
                <div class="feature-description">
                    Destaca los términos de búsqueda en los resultados para mejor UX
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <div class="feature-title">Responsive Design</div>
                <div class="feature-description">
                    Optimizado para desktop, tablet y móvil con diseño adaptativo
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/resources/js/advanced-location-autocomplete.js"></script>
    <script>
        // Inicializar el componente de autocompletado
        let locationAutocomplete;
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Inicializando FASE 4: Autocompletado Avanzado');
            
            // Configuración avanzada del componente
            locationAutocomplete = new AdvancedLocationAutocomplete({
                // IDs de elementos
                departamentoInputId: 'departamento_autocomplete',
                provinciaInputId: 'provincia_autocomplete',
                departamentoHiddenId: 'departamento_id',
                provinciaHiddenId: 'provincia_id',
                
                // Configuración de búsqueda
                minSearchLength: 2,
                searchDelay: 300,
                maxResults: 10,
                
                // Características avanzadas
                enableKeyboardNavigation: true,
                enableHighlighting: true,
                enableFuzzySearch: true,
                preloadDepartments: true,
                cacheResults: true,
                
                // Callbacks para eventos
                onDepartmentSelect: function(department) {
                    console.log('✅ Departamento seleccionado:', department);
                    updateStatusBadge('department', 'success', 'Seleccionado');
                },
                
                onProvinceSelect: function(province) {
                    console.log('✅ Provincia seleccionada:', province);
                    updateStatusBadge('province', 'success', 'Seleccionado');
                },
                
                onClear: function() {
                    console.log('🔄 Selecciones limpiadas');
                    resetStatusBadges();
                    hideResults();
                },
                
                onError: function(message, error) {
                    console.error('❌ Error:', message, error);
                    showMessage('Error: ' + message, 'error');
                }
            });
        });
        
        // Funciones de prueba
        function testDepartment(name) {
            const input = document.getElementById('departamento_autocomplete');
            input.value = name;
            input.focus();
            
            // Simular evento de input
            const event = new Event('input', { bubbles: true });
            input.dispatchEvent(event);
            
            console.log(`🧪 Probando búsqueda: "${name}"`);
        }
        
        function resetSelections() {
            if (locationAutocomplete) {
                locationAutocomplete.reset();
                resetStatusBadges();
                hideResults();
                console.log('🔄 Selecciones reiniciadas');
            }
        }
        
        function showSelectedData() {
            if (!locationAutocomplete) return;
            
            const data = locationAutocomplete.getSelectedData();
            const resultsDiv = document.getElementById('results');
            const contentDiv = document.getElementById('results-content');
            
            if (data.department || data.province) {
                let html = '';
                
                if (data.department) {
                    html += `
                        <div class="result-item">
                            <strong>🏛️ Departamento:</strong> ${data.department.nombre}<br>
                            <small>ID: ${data.department.id} | Código: ${data.department.codigo}</small>
                        </div>
                    `;
                }
                
                if (data.province) {
                    html += `
                        <div class="result-item">
                            <strong>🏘️ Provincia:</strong> ${data.province.nombre}<br>
                            <small>ID: ${data.province.id} | Código: ${data.province.codigo}</small>
                        </div>
                    `;
                }
                
                contentDiv.innerHTML = html;
                resultsDiv.style.display = 'block';
                
                console.log('📊 Datos mostrados:', data);
            } else {
                showMessage('No hay ubicaciones seleccionadas', 'warning');
            }
        }
        
        function hideResults() {
            const resultsDiv = document.getElementById('results');
            resultsDiv.style.display = 'none';
        }
        
        function updateStatusBadge(type, status, text) {
            const label = document.querySelector(`label[for="${type === 'department' ? 'departamento' : 'provincia'}_autocomplete"]`);
            const badge = label.querySelector('.status-badge');
            
            badge.className = `status-badge status-${status}`;
            badge.textContent = text;
        }
        
        function resetStatusBadges() {
            updateStatusBadge('department', 'info', 'Búsqueda en tiempo real');
            updateStatusBadge('province', 'warning', 'Requiere departamento');
        }
        
        function showMessage(message, type = 'info') {
            // Usar el sistema de mensajes del componente
            if (locationAutocomplete) {
                locationAutocomplete.showMessage(message, type);
            }
        }
        
        // Función para probar la API directamente
        async function testAPI() {
            try {
                console.log('🔍 Probando API de búsqueda...');
                
                // Probar búsqueda de departamentos
                const deptResponse = await fetch('/api/v1/locations/departamentos/search?q=lima&limit=5');
                const deptData = await deptResponse.json();
                console.log('📍 Departamentos encontrados:', deptData);
                
                // Probar búsqueda de provincias
                const provResponse = await fetch('/api/v1/locations/provincias/search?q=lima&limit=5');
                const provData = await provResponse.json();
                console.log('🏘️ Provincias encontradas:', provData);
                
                showMessage('✅ API funcionando correctamente', 'success');
            } catch (error) {
                console.error('❌ Error probando API:', error);
                showMessage('❌ Error en API: ' + error.message, 'error');
            }
        }
        
        // Ejecutar prueba de API al cargar
        window.addEventListener('load', function() {
            setTimeout(testAPI, 2000);
        });
    </script>
</body>
</html>
