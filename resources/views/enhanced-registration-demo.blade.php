<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro Extendido - PowerGYMA</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .form-container {
            padding: 40px;
        }

        .form-section {
            margin-bottom: 40px;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #4CAF50;
        }

        .form-section h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.3em;
            display: flex;
            align-items: center;
        }

        .form-section h3::before {
            content: '';
            width: 8px;
            height: 8px;
            background: #4CAF50;
            border-radius: 50%;
            margin-right: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        .required {
            color: #e74c3c;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        input.is-invalid,
        select.is-invalid,
        textarea.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        select {
            cursor: pointer;
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 25px 0;
            padding: 20px;
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
        }

        .checkbox-group input[type="checkbox"] {
            margin-top: 3px;
            transform: scale(1.2);
        }

        .checkbox-group label {
            margin-bottom: 0;
            cursor: pointer;
            color: #856404;
        }

        .btn-submit {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        .btn-submit:hover:not(:disabled) {
            background: linear-gradient(135deg, #45a049, #4CAF50);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .help-text {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
            font-style: italic;
        }

        .demo-section {
            background: #e3f2fd;
            border-left-color: #2196F3;
        }

        .demo-section h3::before {
            background: #2196F3;
        }

        /* Autocomplete suggestions */
        .autocomplete-suggestions {
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .autocomplete-item {
            padding: 12px 15px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
        }

        .autocomplete-item:hover {
            background-color: #f8f9fa;
        }

        .autocomplete-item:last-child {
            border-bottom: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .form-container {
                padding: 20px;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 2em;
            }

            .form-section {
                padding: 20px;
            }
        }

        /* Loading states */
        .loading {
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            border: 2px solid #ddd;
            border-top: 2px solid #4CAF50;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: translateY(-50%) rotate(0deg); }
            100% { transform: translateY(-50%) rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💪 PowerGYMA</h1>
            <p>Registro Extendido con Autocompletado</p>
        </div>

        <div class="form-container">
            <form id="enhanced-registration-form" action="/register" method="POST">
                @csrf
                
                <!-- Sección: Datos Personales -->
                <div class="form-section">
                    <h3>👤 Datos Personales</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nombre Completo <span class="required">*</span></label>
                            <input type="text" id="name" name="name" required>
                            <div class="help-text">Ingrese su nombre completo</div>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico <span class="required">*</span></label>
                            <input type="email" id="email" name="email" required>
                            <div class="help-text">Será usado para iniciar sesión</div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="telefono_celular">Teléfono Celular <span class="required">*</span></label>
                            <input type="tel" id="telefono_celular" name="telefono_celular" required>
                            <div class="help-text">Ej: 987654321</div>
                        </div>
                        <div class="form-group">
                            <label for="telefono_fijo">Teléfono Fijo</label>
                            <input type="tel" id="telefono_fijo" name="telefono_fijo">
                            <div class="help-text">Opcional - Ej: 014567890</div>
                        </div>
                    </div>
                </div>

                <!-- Sección: Datos de la Empresa -->
                <div class="form-section">
                    <h3>🏢 Datos de la Empresa</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="empresa_ruc">RUC de la Empresa <span class="required">*</span></label>
                            <input type="text" id="empresa_ruc" name="empresa_ruc" maxlength="11" required>
                            <div class="help-text">Ingrese 11 dígitos - Se autocompletarán los datos</div>
                        </div>
                        <div class="form-group">
                            <label for="empresa_razon_social">Razón Social <span class="required">*</span></label>
                            <input type="text" id="empresa_razon_social" name="empresa_razon_social" required>
                            <div class="help-text">Razón social oficial de la empresa</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="empresa_telefono_fijo">Teléfono de la Empresa</label>
                        <input type="tel" id="empresa_telefono_fijo" name="empresa_telefono_fijo">
                        <div class="help-text">Teléfono principal de la empresa</div>
                    </div>
                </div>

                <!-- Sección: Ubicación -->
                <div class="form-section">
                    <h3>📍 Ubicación</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="departamento_id">Departamento <span class="required">*</span></label>
                            <select id="departamento_id" name="departamento_id" required>
                                <option value="" disabled selected>Seleccione un departamento</option>
                            </select>
                            <div class="help-text">Seleccione su departamento</div>
                        </div>
                        <div class="form-group">
                            <label for="provincia_id">Provincia <span class="required">*</span></label>
                            <select id="provincia_id" name="provincia_id" required disabled>
                                <option value="" disabled selected>Seleccione una provincia</option>
                            </select>
                            <div class="help-text">Primero seleccione un departamento</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="direccion_calle">Dirección Completa <span class="required">*</span></label>
                        <textarea id="direccion_calle" name="direccion_calle" required placeholder="Ej: Av. Principal 123, Urbanización Los Jardines"></textarea>
                        <div class="help-text">Dirección completa incluyendo referencias</div>
                    </div>
                </div>

                <!-- Sección: Información Adicional -->
                <div class="form-section">
                    <h3>📝 Información Adicional</h3>
                    
                    <div class="form-group">
                        <label for="comentarios">Comentarios</label>
                        <textarea id="comentarios" name="comentarios" placeholder="Información adicional que desee compartir..."></textarea>
                        <div class="help-text">Campo opcional para comentarios adicionales</div>
                    </div>
                </div>

                <!-- Términos y Condiciones -->
                <div class="checkbox-group">
                    <input type="checkbox" id="acepta_terminos" name="acepta_terminos" value="1" required>
                    <label for="acepta_terminos">
                        <strong>Acepto los términos y condiciones <span class="required">*</span></strong><br>
                        <small>He leído y acepto los términos de servicio y la política de privacidad de PowerGYMA</small>
                    </label>
                </div>

                <!-- Botón de Envío -->
                <button type="submit" class="btn-submit">
                    🚀 Completar Registro
                </button>
            </form>
        </div>
    </div>

    <!-- Incluir los componentes JavaScript -->
    <script src="{{ asset('resources/js/company-autocomplete.js') }}"></script>
    <script src="{{ asset('resources/js/location-selector-fixed.js') }}"></script>
    <script src="{{ asset('resources/js/enhanced-registration-form.js') }}"></script>

    <script>
        // Inicializar el formulario cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Inicializando formulario de registro extendido...');
            
            // Crear instancia del formulario mejorado
            window.registrationForm = new EnhancedRegistrationForm({
                formId: 'enhanced-registration-form',
                apiBaseUrl: '/api/v1',
                enableCompanyAutocomplete: true,
                enableLocationSelector: true,
                enableRealTimeValidation: true,
                submitUrl: '/register',
                redirectUrl: '/dashboard'
            });

            // Eventos adicionales para demo
            const companyAutocomplete = window.registrationForm.getCompanyAutocomplete();
            const locationSelector = window.registrationForm.getLocationSelector();

            // Escuchar cambios en el departamento
            if (locationSelector) {
                locationSelector.on('departamentoChanged', function(event) {
                    console.log('📍 Departamento cambiado:', event.detail);
                });
            }

            // Agregar algunos datos de prueba (solo para demo)
            if (window.location.search.includes('demo=true')) {
                setTimeout(() => {
                    console.log('🎯 Cargando datos de demo...');
                    document.getElementById('name').value = 'Juan Carlos Pérez';
                    document.getElementById('email').value = 'juan.perez@empresa.com';
                    document.getElementById('telefono_celular').value = '987654321';
                    document.getElementById('empresa_ruc').value = '20123456789';
                    
                    // Simular validación de RUC
                    document.getElementById('empresa_ruc').dispatchEvent(new Event('input'));
                }, 1000);
            }

            console.log('✅ Formulario de registro extendido inicializado correctamente');
        });

        // Función para limpiar el formulario (útil para testing)
        function resetForm() {
            if (window.registrationForm) {
                window.registrationForm.reset();
                console.log('🔄 Formulario reiniciado');
            }
        }

        // Función para debugging
        function getFormData() {
            if (window.registrationForm) {
                const data = window.registrationForm.collectFormData();
                console.log('📊 Datos del formulario:', data);
                return data;
            }
        }
    </script>
</body>
</html>
