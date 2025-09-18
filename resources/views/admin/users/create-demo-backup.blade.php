<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario Demo - Power GYMA Admin [NUEVA INTERFAZ v2.0]</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #dbeafe;
            --success: #10b981;
            --success-light: #dcfce7;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --info: #06b6d4;
            --info-light: #cffafe;
            --demo: #8b5cf6;
            --demo-light: #ede9fe;
            --text: #111827;
            --text-muted: #6b7280;
            --text-light: #f3f4f6;
            --bg: #f9fafb;
            --white: #ffffff;
            --border: #e5e7eb;
            --border-light: #f3f4f6;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --radius: 12px;
            --radius-sm: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--bg) 0%, var(--demo-light) 100%);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 2rem;
            background: var(--white);
            border-radius: var(--radius) var(--radius) 0 0;
            box-shadow: var(--shadow);
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--demo);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-sm);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-outline {
            background: transparent;
            color: var(--text-muted);
            border: 2px solid var(--border);
        }

        .btn-outline:hover {
            background: var(--text-muted);
            color: var(--white);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--demo), var(--primary-dark));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: var(--text-muted);
            color: white;
        }

        .btn-secondary:hover {
            background: var(--text);
        }

        .card {
            background: var(--white);
            border-radius: 0 0 var(--radius) var(--radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .card-body {
            padding: 2.5rem;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .alert.error {
            background: var(--danger-light);
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        .info-card {
            background: linear-gradient(135deg, var(--demo-light), var(--info-light));
            padding: 1.5rem;
            border-radius: var(--radius-sm);
            margin-bottom: 2rem;
            border-left: 4px solid var(--demo);
        }

        .info-card h3 {
            color: var(--demo);
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-list {
            list-style: none;
            padding: 0;
        }

        .info-list li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            color: var(--text);
        }

        .info-list li i {
            color: var(--demo);
            width: 1rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .required {
            color: var(--danger);
        }

        .form-control {
            padding: 0.75rem 1rem;
            border: 2px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 1rem;
            transition: all 0.2s ease;
            background: var(--white);
            width: 100%;
            position: relative;
            z-index: 1;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--demo);
            box-shadow: 0 0 0 3px var(--demo-light);
            z-index: 2;
        }

        .form-control.error {
            border-color: var(--danger);
        }

        /* Estilos específicos para selectores */
        select.form-control {
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        select.form-control:focus {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%238b5cf6' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        }

        select.form-control option {
            padding: 0.5rem;
            background: var(--white);
            color: var(--text);
        }

        /* Asegurar que los selectores sean completamente funcionales */
        select.form-control:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background-color: var(--border-light);
        }

        select.form-control:not(:disabled) {
            cursor: pointer;
        }

        /* Mejorar la apariencia del dropdown */
        .form-group select {
            position: relative;
            z-index: 10;
        }

        .form-text {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        .error-message {
            font-size: 0.85rem;
            color: var(--danger);
            margin-top: 0.25rem;
        }

        .validation-feedback {
            font-size: 0.85rem;
            margin-top: 0.25rem;
            transition: all 0.2s ease;
        }

        .validation-feedback.success {
            color: var(--success);
        }

        .validation-feedback.error {
            color: var(--danger);
        }

        .validation-feedback.warning {
            color: var(--warning);
        }

        .password-input-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.25rem;
            font-size: 0.9rem;
        }

        .password-toggle:hover {
            color: var(--demo);
        }

        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 0.5rem;
            background: var(--border);
            overflow: hidden;
        }

        .password-strength.weak {
            background: linear-gradient(90deg, var(--danger) 33%, var(--border) 33%);
        }

        .password-strength.medium {
            background: linear-gradient(90deg, var(--warning) 66%, var(--border) 66%);
        }

        .password-strength.strong {
            background: var(--success);
        }

        .form-actions {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        h4 {
            color: var(--demo);
            margin-bottom: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border-light);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <i class="fas fa-clock"></i>
                Crear Usuario Demo
            </h1>
            <a href="{{ route('admin.users') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Volver
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                @if($errors->any())
                    <div class="alert error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Por favor corrige los siguientes errores:</strong>
                            <ul style="margin: 0.5rem 0 0 1rem;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="info-card">
                    <h3>
                        <i class="fas fa-info-circle"></i>
                        Información sobre usuarios demo
                    </h3>
                    <ul class="info-list">
                        <li><i class="fas fa-clock"></i> <strong>Acceso temporal:</strong> Los usuarios demo tienen acceso limitado en el tiempo</li>
                        <li><i class="fas fa-calendar-alt"></i> <strong>Fecha de expiración:</strong> Las cuentas expiran automáticamente en la fecha seleccionada</li>
                        <li><i class="fas fa-eye"></i> <strong>Funcionalidades:</strong> Acceso a dashboard de datos de riesgo con funciones limitadas</li>
                        <li><i class="fas fa-shield-alt"></i> <strong>Seguridad:</strong> Datos aislados y temporales para demostraciones</li>
                    </ul>
                </div>

                <form method="POST" action="{{ route('admin.demo.store') }}" id="demo-form">
                    @csrf
                    <input type="hidden" name="role" value="demo">
                    
                    <!-- Datos Básicos -->
                    <h4>
                        <i class="fas fa-user"></i> Datos Básicos
                    </h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                Nombre Completo <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') error @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required
                                   maxlength="255">
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div id="name-feedback" class="validation-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                Email <span class="required">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') error @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   maxlength="255">
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div id="email-feedback" class="validation-feedback"></div>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="password" class="form-label">
                                Contraseña <span class="required">*</span>
                            </label>
                            <div class="password-input-wrapper">
                                <input type="password" 
                                       class="form-control @error('password') error @enderror" 
                                       id="password" 
                                       name="password" 
                                       required
                                       minlength="8"
                                       maxlength="255">
                                <button type="button" class="password-toggle" id="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="password-strength" class="password-strength"></div>
                            <div class="form-text">Mínimo 8 caracteres, incluye mayúsculas, minúsculas y números</div>
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div id="password-feedback" class="validation-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                Confirmar Contraseña <span class="required">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required
                                   minlength="8"
                                   maxlength="255">
                            <div id="password-confirmation-feedback" class="validation-feedback"></div>
                        </div>
                    </div>

                    <!-- Información de la Empresa -->
                    <h4>
                        <i class="fas fa-building"></i> Información de la Empresa
                    </h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="ruc_empresa" class="form-label">
                                RUC de la Empresa <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control @error('ruc_empresa') error @enderror" 
                                       id="ruc_empresa" 
                                       name="ruc_empresa" 
                                       value="{{ old('ruc_empresa') }}" 
                                       maxlength="11"
                                       pattern="[0-9]{11}"
                                       placeholder="12345678901">
                                <button type="button" id="search-ruc" class="btn btn-info" style="border-radius: 0 var(--radius-sm) var(--radius-sm) 0;">
                                    <i class="fas fa-search"></i>
                                    <span class="btn-text">Buscar</span>
                                </button>
                            </div>
                            <div class="form-text">11 dígitos del RUC de la empresa. Presiona buscar o Enter para autocompletar</div>
                            @error('ruc_empresa')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div id="ruc-feedback" class="validation-feedback"></div>
                            <div id="ruc-status" class="form-text" style="margin-top: 0.5rem; color: var(--info); font-weight: 500;"></div>
                        </div>

                        <div class="form-group">
                            <label for="razon_social" class="form-label">
                                Razón Social <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('razon_social') error @enderror" 
                                   id="razon_social" 
                                   name="razon_social" 
                                   value="{{ old('razon_social') }}" 
                                   required
                                   maxlength="255"
                                   placeholder="Empresa Ejemplo S.A.C.">
                            @error('razon_social')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Información Personal -->
                    <h4>
                        <i class="fas fa-id-badge"></i> Información Personal
                    </h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="tipo_documento" class="form-label">
                                Tipo de Documento <span class="required">*</span>
                            </label>
                            <select class="form-control @error('tipo_documento') error @enderror" 
                                    id="tipo_documento" 
                                    name="tipo_documento" 
                                    required>
                                <option value="">Seleccionar tipo</option>
                                <option value="dni" {{ old('tipo_documento') == 'dni' ? 'selected' : '' }}>DNI</option>
                                <option value="ruc" {{ old('tipo_documento') == 'ruc' ? 'selected' : '' }}>RUC</option>
                                <option value="ce" {{ old('tipo_documento') == 'ce' ? 'selected' : '' }}>Carné de Extranjería</option>
                                <option value="pasaporte" {{ old('tipo_documento') == 'pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                            </select>
                            @error('tipo_documento')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="numero_documento" class="form-label">
                                Número de Documento <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('numero_documento') error @enderror" 
                                   id="numero_documento" 
                                   name="numero_documento" 
                                   value="{{ old('numero_documento') }}" 
                                   required
                                   maxlength="20"
                                   placeholder="Seleccione un tipo de documento">
                            <div id="documento-help" class="form-text">Seleccione un tipo de documento para ver el formato</div>
                            @error('numero_documento')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div id="documento-feedback" class="validation-feedback"></div>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="telefono_celular" class="form-label">
                                Teléfono Celular <span class="required">*</span>
                            </label>
                            <input type="tel" 
                                   class="form-control @error('telefono_celular') error @enderror" 
                                   id="telefono_celular" 
                                   name="telefono_celular" 
                                   value="{{ old('telefono_celular') }}" 
                                   required
                                   maxlength="15"
                                   placeholder="987654321">
                            @error('telefono_celular')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div id="telefono-feedback" class="validation-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label for="puesto_trabajo" class="form-label">
                                Puesto de Trabajo <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('puesto_trabajo') error @enderror" 
                                   id="puesto_trabajo" 
                                   name="puesto_trabajo" 
                                   value="{{ old('puesto_trabajo') }}" 
                                   required
                                   maxlength="100"
                                   placeholder="Gerente General">
                            @error('puesto_trabajo')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dirección de la Empresa -->
                    <h4>
                        <i class="fas fa-map-marker-alt"></i> Dirección de la Empresa
                    </h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="departamento_id" class="form-label">
                                Departamento <span class="required">*</span>
                            </label>
                            <select class="form-control @error('departamento_id') error @enderror" 
                                    id="departamento" 
                                    name="departamento_id" 
                                    required>
                                <option value="">Seleccionar departamento...</option>
                                @foreach($departamentos as $depto)
                                    <option value="{{ $depto->id }}" {{ old('departamento_id') == $depto->id ? 'selected' : '' }}>{{ $depto->nombre }}</option>
                                @endforeach
                            </select>
                            @error('departamento_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="provincia_id" class="form-label">
                                Provincia <span class="required">*</span>
                            </label>
                            <select class="form-control @error('provincia_id') error @enderror" 
                                    id="provincia" 
                                    name="provincia_id" 
                                    required>
                                <option value="">Seleccionar provincia...</option>
                                <!-- Las provincias se cargarán dinámicamente según el departamento seleccionado -->
                            </select>
                            @error('provincia_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="distrito" class="form-label">
                                Distrito <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('distrito') error @enderror" 
                                   id="distrito" 
                                   name="distrito" 
                                   value="{{ old('distrito') }}" 
                                   placeholder="Ej: Miraflores"
                                   required>
                            @error('distrito')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="direccion_empresa" class="form-label">
                            Dirección de la Empresa <span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('direccion_empresa') error @enderror" 
                               id="direccion_empresa" 
                               name="direccion_empresa" 
                               value="{{ old('direccion_empresa') }}" 
                               required
                               maxlength="255"
                               placeholder="Av. Javier Prado Este 123, San Isidro">
                        <div class="form-text">Dirección exacta de la empresa</div>
                        @error('direccion_empresa')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Configuración Demo -->
                    <h4>
                        <i class="fas fa-cogs"></i> Configuración Demo
                    </h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="expires_at" class="form-label">
                                Fecha de Expiración <span class="required">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('expires_at') error @enderror" 
                                   id="expires_at" 
                                   name="expires_at" 
                                   value="{{ old('expires_at', now()->addDays(30)->format('Y-m-d')) }}" 
                                   min="{{ now()->format('Y-m-d') }}"
                                   required>
                            <div class="form-text">Las cuentas demo expiran automáticamente en la fecha seleccionada</div>
                            @error('expires_at')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">
                                Estado <span class="required">*</span>
                            </label>
                            <select class="form-control @error('status') error @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                    Usuario Activo
                                </option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                    Usuario Inactivo
                                </option>
                            </select>
                            <div class="form-text">Estado inicial del usuario demo</div>
                            @error('status')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Crear Usuario Demo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('resources/js/advanced-form-validator.js') }}"></script>
    <script src="{{ asset('resources/js/location-handler.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // === SISTEMA DE UBICACIONES (CORREGIDO PARA USAR IDs) ===
            console.log('🚀 Iniciando sistema de ubicaciones con IDs...');
            
            const departamentoSelect = document.getElementById('departamento');
            const provinciaSelect = document.getElementById('provincia');
            
            if (departamentoSelect && provinciaSelect) {
                // Función para cargar provincias
                async function cargarProvincias(departamentoId, oldProvinciaId = null) {
                    try {
                        provinciaSelect.innerHTML = '<option value="">Cargando provincias...</option>';
                        provinciaSelect.disabled = true;
                        
                        const response = await fetch(`/api/v1/locations/provincias/departamento/${departamentoId}`);
                        const result = await response.json();
                        
                        if (result.success && result.data) {
                            let optionsHtml = '<option value="">Seleccionar provincia...</option>';
                            result.data.forEach(prov => {
                                optionsHtml += `<option value="${prov.id}">${prov.nombre}</option>`;
                            });
                            provinciaSelect.innerHTML = optionsHtml;
                            
                            if (oldProvinciaId) {
                                provinciaSelect.value = oldProvinciaId;
                            }
                        } else {
                            provinciaSelect.innerHTML = '<option value="">No se encontraron provincias</option>';
                        }
                    } catch (error) {
                        console.error('❌ Error cargando provincias:', error);
                        provinciaSelect.innerHTML = '<option value="">Error al cargar provincias</option>';
                    } finally {
                        provinciaSelect.disabled = false;
                    }
                }
                
                // Event listener para departamento
                departamentoSelect.addEventListener('change', function() {
                    const departamentoId = this.value;
                    if (departamentoId) {
                        cargarProvincias(departamentoId);
                    } else {
                        provinciaSelect.innerHTML = '<option value="">Seleccionar provincia...</option>';
                    }
                });

                // Si hay un departamento seleccionado por 'old' input, cargar sus provincias
                if (departamentoSelect.value) {
                    const oldProvincia = "{{ old('provincia_id') }}";
                    cargarProvincias(departamentoSelect.value, oldProvincia);
                }
            }
            
            // === OTROS SCRIPTS DEL FORMULARIO (VALIDADOR, ETC.) ===
            const togglePassword = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('password');
            const tipoDocumento = document.getElementById('tipo_documento');
            const numeroDocumento = document.getElementById('numero_documento');
            const documentoHelp = document.getElementById('documento-help');
            
            const validator = new AdvancedFormValidator('demo-form', {
                apiEndpoint: '/api/v1/forms',
                csrfToken: '{{ csrf_token() }}',
                realTimeValidation: true,
                showPasswordStrength: true
            });

            const documentoFormats = {
                'dni': { pattern: /^\d{8}$/, placeholder: '12345678', help: 'DNI debe tener 8 dígitos numéricos' },
                'ruc': { pattern: /^\d{11}$/, placeholder: '20123456789', help: 'RUC debe tener 11 dígitos numéricos' },
                'ce': { pattern: /^[0-9]{9,12}$/, placeholder: '001234567', help: 'CE debe tener entre 9 y 12 dígitos' },
                'pasaporte': { pattern: /^[A-Z0-9]{6,12}$/, placeholder: 'ABC123456', help: 'Pasaporte debe tener entre 6 y 12 caracteres alfanuméricos' }
            };

            function updateDocumentFormat() {
                const tipo = tipoDocumento.value;
                const format = documentoFormats[tipo] || { placeholder: 'Seleccione un tipo de documento', help: 'Seleccione un tipo de documento para ver el formato', pattern: '' };
                numeroDocumento.placeholder = format.placeholder;
                documentoHelp.textContent = format.help;
                numeroDocumento.pattern = format.pattern ? format.pattern.source : '';
                if (numeroDocumento.value) validator.validateField('numero_documento', numeroDocumento.value);
            }

            function togglePasswordVisibility() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                const icon = togglePassword.querySelector('i');
                icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
            }

            tipoDocumento.addEventListener('change', updateDocumentFormat);
            togglePassword.addEventListener('click', togglePasswordVisibility);

            document.getElementById('email').addEventListener('blur', function() { if (this.value) validator.validateField('email', this.value); });
            numeroDocumento.addEventListener('blur', function() { if (this.value && tipoDocumento.value) validator.checkDocumentAvailability(tipoDocumento.value, this.value); });
            document.getElementById('telefono_celular').addEventListener('blur', function() { if (this.value) validator.validateField('telefono', this.value); });
            document.getElementById('password_confirmation').addEventListener('blur', function() { if (this.value) validator.validateField('password_confirmation', this.value); });

            updateDocumentFormat();

            // === AUTOCOMPLETADO POR RUC ===
            const rucInput = document.getElementById('ruc_empresa');
            const searchRucBtn = document.getElementById('search-ruc');
            const rucStatus = document.getElementById('ruc-status');

            // Verificar que todos los elementos existan
            if (!rucInput || !searchRucBtn || !rucStatus) {
                console.warn('⚠️ Algunos elementos del autocompletado RUC no fueron encontrados');
                return;
            }

            console.log('✅ Elementos de autocompletado RUC cargados correctamente');

            async function searchRuc() {
                console.log('🔍 Iniciando búsqueda de RUC...');
                const ruc = rucInput.value.trim();
                console.log('RUC ingresado:', ruc);
                
                // Validar RUC
                if (ruc.length !== 11 || !/^\d{11}$/.test(ruc)) {
                    rucStatus.textContent = 'El RUC debe tener exactamente 11 dígitos numéricos.';
                    rucStatus.style.color = 'var(--danger)';
                    clearCompanyFields();
                    return;
                }
                
                // Mostrar estado de carga
                rucStatus.textContent = '🔍 Buscando empresa...';
                rucStatus.style.color = 'var(--info)';
                searchRucBtn.disabled = true;
                searchRucBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span class="btn-text">Buscando...</span>';
                
                try {
                    const response = await fetch(`/api/v1/companies/ruc/${ruc}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    const result = await response.json();
                    console.log('📡 API Response:', result);

                    if (result.success && result.data) {
                        const company = result.data;
                        console.log('🏢 Datos de empresa encontrados:', company);
                        
                        // Autocompletar campos de empresa
                        fillCompanyFields(company);
                        
                        // Mostrar mensaje de éxito
                        rucStatus.innerHTML = `<i class="fas fa-check-circle"></i> Empresa encontrada: <strong>${company.razon_social}</strong>`;
                        rucStatus.style.color = 'var(--success)';
                        
                        // Resaltar campos autocompletados temporalmente
                        highlightFilledFields();
                        
                    } else {
                        console.log('❌ No se encontró empresa con RUC:', ruc);
                        rucStatus.innerHTML = '<i class="fas fa-exclamation-triangle"></i> No se encontró empresa con este RUC en la base de datos.';
                        rucStatus.style.color = 'var(--warning)';
                        clearCompanyFields();
                    }
                    
                } catch (error) {
                    console.error('❌ Error en búsqueda de RUC:', error);
                    rucStatus.innerHTML = '<i class="fas fa-times-circle"></i> Error al buscar la empresa. Inténtelo nuevamente.';
                    rucStatus.style.color = 'var(--danger)';
                    clearCompanyFields();
                } finally {
                    // Restaurar botón
                    searchRucBtn.disabled = false;
                    searchRucBtn.innerHTML = '<i class="fas fa-search"></i> <span class="btn-text">Buscar</span>';
                }
            }

            function fillCompanyFields(company) {
                console.log('📝 Autocompletando campos...');
                
                // Campos básicos de empresa
                const fields = {
                    'razon_social': company.razon_social || '',
                    'direccion_empresa': company.direccion_calle || '',
                    'distrito': company.distrito || ''
                };
                
                // Llenar campos básicos
                Object.entries(fields).forEach(([fieldId, value]) => {
                    const field = document.getElementById(fieldId);
                    if (field && value) {
                        field.value = value;
                        console.log(`✅ Campo ${fieldId} llenado con: ${value}`);
                    }
                });
                
                // Manejar ubicación geográfica
                if (company.departamento && company.departamento.id) {
                    const deptoSelect = document.getElementById('departamento');
                    if (deptoSelect) {
                        deptoSelect.value = company.departamento.id;
                        console.log(`🗺️ Departamento seleccionado: ${company.departamento.nombre} (ID: ${company.departamento.id})`);
                        
                        // Trigger change event para cargar provincias
                        deptoSelect.dispatchEvent(new Event('change'));
                        
                        // Esperar a que se carguen las provincias y luego seleccionar
                        if (company.provincia && company.provincia.id) {
                            setTimeout(() => {
                                const provinciaSelect = document.getElementById('provincia');
                                if (provinciaSelect) {
                                    provinciaSelect.value = company.provincia.id;
                                    console.log(`🏘️ Provincia seleccionada: ${company.provincia.nombre} (ID: ${company.provincia.id})`);
                                }
                            }, 1500); // Esperar 1.5 segundos para que carguen las provincias
                        }
                    }
                }
            }

            function clearCompanyFields() {
                console.log('🧹 Limpiando campos de empresa...');
                const fieldsToClear = ['razon_social', 'direccion_empresa', 'distrito'];
                fieldsToClear.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) {
                        field.value = '';
                    }
                });
            }

            function highlightFilledFields() {
                const fieldsToHighlight = ['razon_social', 'direccion_empresa', 'departamento', 'provincia', 'distrito'];
                fieldsToHighlight.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field && field.value) {
                        field.style.transition = 'all 0.3s ease';
                        field.style.backgroundColor = 'var(--demo-light)';
                        field.style.borderColor = 'var(--demo)';
                        
                        // Remover el resaltado después de 2 segundos
                        setTimeout(() => {
                            field.style.backgroundColor = '';
                            field.style.borderColor = '';
                        }, 2000);
                    }
                });
            }

            function validateRucFormat(ruc) {
                // Validar que sea exactamente 11 dígitos numéricos
                return /^\d{11}$/.test(ruc);
            }

            // Event listeners para RUC
            // Búsqueda automática al perder el foco si el RUC es válido
            rucInput.addEventListener('blur', function() {
                const ruc = this.value.trim();
                if (validateRucFormat(ruc)) {
                    searchRuc();
                } else if (ruc.length > 0) {
                    rucStatus.textContent = 'Formato de RUC inválido. Debe tener 11 dígitos.';
                    rucStatus.style.color = 'var(--danger)';
                } else {
                    rucStatus.textContent = '';
                }
            });

            // Búsqueda al hacer clic en el botón
            searchRucBtn.addEventListener('click', function(event) {
                event.preventDefault();
                searchRuc();
            });

                // Búsqueda al presionar Enter
                rucInput.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        searchRuc();
                    }
                });

                // Validación en tiempo real mientras escribe
                rucInput.addEventListener('input', function() {
                    let ruc = this.value;
                    
                    // Solo permitir números
                    ruc = ruc.replace(/[^0-9]/g, '');
                    this.value = ruc;
                    
                    if (ruc.length === 0) {
                        rucStatus.textContent = '';
                        clearCompanyFields();
                    } else if (ruc.length < 11) {
                        rucStatus.textContent = `Faltan ${11 - ruc.length} dígitos`;
                        rucStatus.style.color = 'var(--text-muted)';
                    } else if (ruc.length === 11) {
                        rucStatus.textContent = '✅ RUC completo. Buscando automáticamente...';
                        rucStatus.style.color = 'var(--info)';
                        
                        // Búsqueda automática cuando se completa el RUC
                        setTimeout(() => {
                            if (this.value.trim() === ruc && validateRucFormat(ruc)) {
                                searchRuc();
                            }
                        }, 800); // Esperar 0.8 segundos después de completar
                    }
                });
        });
    </script>
</body>
</html>
