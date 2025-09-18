<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✅ SOLUCION SELECTORES DE UBICACION</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            background: white;
            transition: border-color 0.3s ease;
        }
        select:focus {
            outline: none;
            border-color: #667eea;
        }
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .error {
            color: #dc3545;
            font-weight: bold;
        }
        .status {
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
        }
        .status.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✅ Selectores de Ubicación - SOLUCIONADO</h1>
        
        <div id="status" class="status">Inicializando...</div>

        <form>
            <div class="form-group">
                <label for="departamento_id">Departamento *</label>
                <select id="departamento_id" name="departamento_id" required>
                    <option value="">Cargando departamentos...</option>
                </select>
            </div>

            <div class="form-group">
                <label for="provincia_id">Provincia *</label>
                <select id="provincia_id" name="provincia_id" required>
                    <option value="">Primero seleccione un departamento</option>
                </select>
            </div>
        </form>
    </div>

    <script>
        // Implementación simplificada y funcional
        class SimpleLocationSelector {
            constructor() {
                this.apiBase = '/api/v1/locations';
                this.init();
            }

            async init() {
                this.updateStatus('Cargando departamentos...', 'loading');
                await this.loadDepartamentos();
                this.bindEvents();
            }

            updateStatus(message, type = 'info') {
                const statusEl = document.getElementById('status');
                statusEl.textContent = message;
                statusEl.className = `status ${type}`;
            }

            async loadDepartamentos() {
                try {
                    const response = await fetch(`${this.apiBase}/departamentos`);
                    const data = await response.json();
                    
                    if (data.success && data.data) {
                        this.populateDepartamentos(data.data);
                        this.updateStatus(`✅ ${data.data.length} departamentos cargados exitosamente`, 'success');
                    } else {
                        throw new Error(data.message || 'Error en API');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.updateStatus(`❌ Error: ${error.message}`, 'error');
                }
            }

            populateDepartamentos(departamentos) {
                const select = document.getElementById('departamento_id');
                select.innerHTML = '<option value="">Seleccione un departamento</option>';
                
                departamentos.forEach(dept => {
                    const option = document.createElement('option');
                    option.value = dept.id;
                    option.textContent = dept.nombre;
                    select.appendChild(option);
                });
            }

            async loadProvincias(departamentoId) {
                if (!departamentoId) {
                    this.clearProvincias();
                    return;
                }

                const provinciaSelect = document.getElementById('provincia_id');
                provinciaSelect.innerHTML = '<option value="">Cargando provincias...</option>';
                provinciaSelect.classList.add('loading');

                try {
                    const response = await fetch(`${this.apiBase}/provincias/departamento/${departamentoId}`);
                    const data = await response.json();
                    
                    if (data.success && data.data) {
                        this.populateProvincias(data.data);
                        this.updateStatus(`✅ ${data.data.length} provincias cargadas`, 'success');
                    } else {
                        throw new Error(data.message || 'Error al cargar provincias');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.updateStatus(`❌ Error: ${error.message}`, 'error');
                    this.clearProvincias();
                } finally {
                    provinciaSelect.classList.remove('loading');
                }
            }

            populateProvincias(provincias) {
                const select = document.getElementById('provincia_id');
                select.innerHTML = '<option value="">Seleccione una provincia</option>';
                
                provincias.forEach(prov => {
                    const option = document.createElement('option');
                    option.value = prov.id;
                    option.textContent = prov.nombre;
                    select.appendChild(option);
                });
            }

            clearProvincias() {
                const select = document.getElementById('provincia_id');
                select.innerHTML = '<option value="">Primero seleccione un departamento</option>';
            }

            bindEvents() {
                const deptSelect = document.getElementById('departamento_id');
                deptSelect.addEventListener('change', (e) => {
                    const departamentoId = e.target.value;
                    if (departamentoId) {
                        const deptName = e.target.options[e.target.selectedIndex].text;
                        this.updateStatus(`🏛️ Seleccionado: ${deptName}`, 'success');
                        this.loadProvincias(departamentoId);
                    } else {
                        this.clearProvincias();
                        this.updateStatus('Seleccione un departamento', 'info');
                    }
                });

                const provSelect = document.getElementById('provincia_id');
                provSelect.addEventListener('change', (e) => {
                    if (e.target.value) {
                        const provName = e.target.options[e.target.selectedIndex].text;
                        this.updateStatus(`🏘️ Provincia seleccionada: ${provName}`, 'success');
                    }
                });
            }
        }

        // Inicializar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Inicializando selector de ubicaciones...');
            new SimpleLocationSelector();
        });
    </script>
</body>
</html>
