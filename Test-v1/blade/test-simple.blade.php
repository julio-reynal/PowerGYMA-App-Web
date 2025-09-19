<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Simple - Location Selector</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        select { width: 300px; padding: 10px; margin: 10px; }
        .log { background: #f0f0f0; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Test Simple - Location Selector</h1>
    
    <div>
        <label>Departamento:</label>
        <select id="departamento_id">
            <option value="">Seleccione un departamento</option>
        </select>
    </div>
    
    <div>
        <label>Provincia:</label>
        <select id="provincia_id">
            <option value="">Seleccione una provincia</option>
        </select>
    </div>
    
    <div class="log" id="log"></div>

    <script src="{{ asset('resources/js/location-selector.js') }}"></script>
    <script>
        function log(message) {
            const logElement = document.getElementById('log');
            logElement.innerHTML += '<div>' + new Date().toLocaleTimeString() + ': ' + message + '</div>';
            console.log(message);
        }

        document.addEventListener('DOMContentLoaded', function() {
            log('🚀 Iniciando test...');
            
            try {
                // Test 1: Verificar que la clase existe
                if (typeof LocationSelector !== 'undefined') {
                    log('✅ Clase LocationSelector encontrada');
                } else {
                    log('❌ Clase LocationSelector NO encontrada');
                    return;
                }

                // Test 2: Crear instancia
                const selector = new LocationSelector({
                    departamentoSelectId: 'departamento_id',
                    provinciaSelectId: 'provincia_id',
                    apiBaseUrl: '/api/v1'
                });
                
                log('✅ Instancia creada');

                // Test 3: Probar API manualmente
                fetch('/api/v1/locations/departamentos')
                    .then(response => {
                        log(`API Response Status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        log(`API Data: ${JSON.stringify(data).substring(0, 100)}...`);
                        if (data.success && data.data) {
                            log(`✅ API funcionando: ${data.data.length} departamentos`);
                            
                            // Llenar select manualmente para verificar
                            const select = document.getElementById('departamento_id');
                            data.data.forEach(dept => {
                                const option = document.createElement('option');
                                option.value = dept.id;
                                option.textContent = dept.nombre;
                                select.appendChild(option);
                            });
                            log('✅ Select llenado manualmente');
                        } else {
                            log('❌ API error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        log('❌ Error en API: ' + error.message);
                    });

            } catch (error) {
                log('❌ Error: ' + error.message);
            }
        });
    </script>
</body>
</html>
