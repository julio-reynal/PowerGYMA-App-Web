<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario - Power GYMA Admin</title>
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
            background: linear-gradient(135deg, var(--bg) 0%, #e0e7ff 100%);
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
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2rem;
            border-radius: var(--radius) var(--radius) 0 0;
            margin-bottom: 0;
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-outline {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .btn-outline:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
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
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .form-control.error {
            border-color: var(--danger);
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

        .password-input-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-meter {
            height: 6px;
            background: var(--border);
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 3px;
        }

        .strength-fill.very-weak {
            width: 20%;
            background: var(--danger);
        }

        .strength-fill.weak {
            width: 40%;
            background: #ff6b35;
        }

        .strength-fill.fair {
            width: 60%;
            background: var(--warning);
        }

        .strength-fill.good {
            width: 80%;
            background: #4ade80;
        }

        .strength-fill.strong {
            width: 100%;
            background: var(--success);
        }

        .strength-text {
            font-size: 0.85rem;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .strength-text.very-weak {
            color: var(--danger);
        }

        .strength-text.weak {
            color: #ff6b35;
        }

        .strength-text.fair {
            color: var(--warning);
        }

        .strength-text.good {
            color: #4ade80;
        }

        .strength-text.strong {
            color: var(--success);
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.5rem;
            border: 1px solid;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .alert.error {
            background: var(--danger-light);
            color: #991b1b;
            border-color: var(--danger);
        }

        .info-card {
            background: var(--info-light);
            border: 1px solid var(--info);
            border-radius: var(--radius-sm);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .info-card h3 {
            color: #0c4a6e;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-list {
            list-style: none;
            color: #0c4a6e;
        }

        .info-list li {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .card-body {
                padding: 1.5rem;
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
                <i class="fas fa-user-plus"></i>
                Crear Usuario
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
                        Información sobre roles
                    </h3>
                    <ul class="info-list">
                        <li><i class="fas fa-shield-alt"></i> <strong>Administrador:</strong> Acceso completo al sistema</li>
                        <li><i class="fas fa-chart-line"></i> <strong>Cliente:</strong> Acceso a dashboard de datos de riesgo</li>
                        <li><i class="fas fa-clock"></i> <strong>Demo:</strong> Acceso limitado con fecha de expiración</li>
                    </ul>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}" id="user-form">
    
                    
                    <!-- Datos Básicos -->
                    <h4 style="color: var(--primary); margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
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
                                   required>
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="validation-feedback" id="name-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                Correo Electrónico <span class="required">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') error @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="validation-feedback" id="email-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">
                                Contraseña <span class="required">*</span>
                            </label>
                            <div class="password-input-container">
                                <input type="password" 
                                       class="form-control @error('password') error @enderror" 
                                       id="password" 
                                       name="password" 
                                       required>
                                <button type="button" class="password-toggle" id="toggle-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <!-- Medidor de fortaleza -->
                            <div class="password-strength" id="password-strength">
                                <div class="strength-meter">
                                    <div class="strength-fill" id="strength-fill"></div>
                                </div>
                                <div class="strength-text" id="strength-text">Escriba una contraseña</div>
                            </div>
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Mínimo 8 caracteres, incluir mayúsculas, minúsculas, números y símbolos</div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                Confirmar Contraseña <span class="required">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required>
                            <div class="validation-feedback" id="password-confirmation-feedback"></div>
                        </div>
                    </div>

                    <!-- Información de la Empresa -->
                    <h4 style="color: var(--primary); margin: 2rem 0 1.5rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-building"></i> Información de la Empresa
                    </h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="ruc_empresa" class="form-label">
                                N° RUC <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control @error('ruc_empresa') error @enderror" 
                                       id="ruc_empresa" 
                                       name="ruc_empresa" 
                                       value="{{ old('ruc_empresa') }}" 
                                       placeholder="12345678901"
                                       maxlength="11"
                                       pattern="[0-9]{11}">
                                <button type="button" id="search-ruc" class="btn btn-info" style="border-radius: 0 var(--radius-sm) var(--radius-sm) 0;">
                                    <i class="fas fa-search"></i>
                                    <span class="btn-text">Buscar</span>
                                </button>
                            </div>
                            @error('ruc_empresa')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="validation-feedback" id="ruc-feedback"></div>
                            <div class="form-text">11 dígitos del RUC de la empresa. Presiona buscar o Enter para autocompletar</div>
                            <div id="ruc-status" class="form-text" style="margin-top: 0.5rem; color: var(--info); font-weight: 500;"></div>
                        </div>

                        <div class="form-group">
                            <label for="giro_empresa" class="form-label">
                                Giro de la Empresa <span class="required">*</span>
                            </label>
                            <select class="form-control @error('giro_empresa') error @enderror" 
                                    id="giro_empresa" 
                                    name="giro_empresa" 
                                    required>
                                <option value="">Seleccionar giro empresarial...</option>
                                <option value="comercio" {{ old('giro_empresa') === 'comercio' ? 'selected' : '' }}>Comercio</option>
                                <option value="servicios" {{ old('giro_empresa') === 'servicios' ? 'selected' : '' }}>Servicios</option>
                                <option value="manufactura" {{ old('giro_empresa') === 'manufactura' ? 'selected' : '' }}>Manufactura</option>
                                <option value="construccion" {{ old('giro_empresa') === 'construccion' ? 'selected' : '' }}>Construcción</option>
                                <option value="tecnologia" {{ old('giro_empresa') === 'tecnologia' ? 'selected' : '' }}>Tecnología</option>
                                <option value="salud" {{ old('giro_empresa') === 'salud' ? 'selected' : '' }}>Salud</option>
                                <option value="educacion" {{ old('giro_empresa') === 'educacion' ? 'selected' : '' }}>Educación</option>
                                <option value="transporte" {{ old('giro_empresa') === 'transporte' ? 'selected' : '' }}>Transporte</option>
                                <option value="alimentario" {{ old('giro_empresa') === 'alimentario' ? 'selected' : '' }}>Alimentario</option>
                                <option value="textil" {{ old('giro_empresa') === 'textil' ? 'selected' : '' }}>Textil</option>
                                <option value="mineria" {{ old('giro_empresa') === 'mineria' ? 'selected' : '' }}>Minería</option>
                                <option value="agroindustria" {{ old('giro_empresa') === 'agroindustria' ? 'selected' : '' }}>Agroindustria</option>
                                <option value="otros" {{ old('giro_empresa') === 'otros' ? 'selected' : '' }}>Otros</option>
                            </select>
                            @error('giro_empresa')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group form-group-full">
                            <label for="razon_social" class="form-label">
                                Razón Social de la Empresa <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('razon_social') error @enderror" 
                                   id="razon_social" 
                                   name="razon_social" 
                                   value="{{ old('razon_social') }}" 
                                   placeholder="Empresa Ejemplo S.A.C."
                                   maxlength="255"
                                   required>
                            @error('razon_social')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Puesto de Trabajo -->
                    <h4 style="color: var(--primary); margin: 2rem 0 1.5rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-id-badge"></i> Información del Cargo
                    </h4>
                    
                    <div class="form-grid">
                        <div class="form-group form-group-full">
                            <label for="puesto_trabajo" class="form-label">
                                Puesto de Trabajo <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('puesto_trabajo') error @enderror" 
                                   id="puesto_trabajo" 
                                   name="puesto_trabajo" 
                                   value="{{ old('puesto_trabajo') }}" 
                                   placeholder="Gerente General"
                                   maxlength="100"
                                   required>
                            @error('puesto_trabajo')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Documentos de Identidad -->
                    <h4 style="color: var(--primary); margin: 2rem 0 1.5rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-id-card"></i> Documentos de Identidad
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
                                <option value="">Seleccionar tipo...</option>
                                <option value="dni" {{ old('tipo_documento') === 'dni' ? 'selected' : '' }}>DNI - Documento Nacional de Identidad</option>
                                <option value="ruc" {{ old('tipo_documento') === 'ruc' ? 'selected' : '' }}>RUC - Registro Único de Contribuyentes</option>
                                <option value="ce" {{ old('tipo_documento') === 'ce' ? 'selected' : '' }}>CE - Carnet de Extranjería</option>
                                <option value="pasaporte" {{ old('tipo_documento') === 'pasaporte' ? 'selected' : '' }}>Pasaporte</option>
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
                                   placeholder="Ingrese el número de documento"
                                   required>
                            @error('numero_documento')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="validation-feedback" id="documento-feedback"></div>
                            <div class="form-text" id="documento-help">Seleccione un tipo de documento para ver el formato</div>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <h4 style="color: var(--primary); margin: 2rem 0 1.5rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-phone"></i> Información de Contacto
                    </h4>
                    
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
                                   placeholder="987654321"
                                   maxlength="15"
                                   required>
                            @error('telefono_celular')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="validation-feedback" id="telefono-celular-feedback"></div>
                            <div class="form-text">Formato: 9XX XXX XXX para móviles</div>
                        </div>

                        <div class="form-group">
                            <label for="telefono_fijo" class="form-label">
                                Teléfono Fijo
                            </label>
                            <input type="tel" 
                                   class="form-control @error('telefono_fijo') error @enderror" 
                                   id="telefono_fijo" 
                                   name="telefono_fijo" 
                                   value="{{ old('telefono_fijo') }}" 
                                   placeholder="01-1234567"
                                   maxlength="15">
                            @error('telefono_fijo')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Formato: 01-XXXXXXX para Lima, XX-XXXXXX para provincias</div>
                        </div>
                    </div>

                    <!-- Dirección de la Empresa -->
                    <h4 style="color: var(--primary); margin: 2rem 0 1.5rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
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
                            <div id="location-error" style="display: none; color: var(--warning); font-size: 0.85rem; margin-top: 0.25rem;"></div>
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

                        <div class="form-group form-group-full">
                            <label for="direccion_empresa" class="form-label">
                                Dirección de la Empresa <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('direccion_empresa') error @enderror" 
                                   id="direccion_empresa" 
                                   name="direccion_empresa" 
                                   value="{{ old('direccion_empresa') }}" 
                                   placeholder="Av. Javier Prado Este 123, San Isidro"
                                   maxlength="255"
                                   required>
                            @error('direccion_empresa')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Dirección exacta de la empresa</div>
                        </div>
                    </div>

                    <!-- Información Personal -->
                    <h4 style="color: var(--primary); margin: 2rem 0 1.5rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-user-circle"></i> Información Personal
                    </h4>
                    
                    <div class="form-grid">
                        

                        <div class="form-group">
                            <label for="fecha_nacimiento" class="form-label">
                                Fecha de Nacimiento
                            </label>
                            <input type="date" 
                                   class="form-control @error('fecha_nacimiento') error @enderror" 
                                   id="fecha_nacimiento" 
                                   name="fecha_nacimiento" 
                                   value="{{ old('fecha_nacimiento') }}" 
                                   max="{{ date('Y-m-d', strtotime('-18 years')) }}">
                            @error('fecha_nacimiento')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Debe ser mayor de 18 años</div>
                        </div>

                        <div class="form-group">
                            <label for="genero" class="form-label">
                                Género
                            </label>
                            <select class="form-control @error('genero') error @enderror" 
                                    id="genero" 
                                    name="genero">
                                <option value="">Seleccionar género...</option>
                                <option value="masculino" {{ old('genero') === 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('genero') === 'femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="otro" {{ old('genero') === 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('genero')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="direccion" class="form-label">
                                Dirección Personal
                            </label>
                            <input type="text" 
                                   class="form-control @error('direccion') error @enderror" 
                                   id="direccion" 
                                   name="direccion" 
                                   value="{{ old('direccion') }}" 
                                   placeholder="Av. Principal 123, Distrito, Provincia">
                            @error('direccion')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Configuración del Sistema -->
                    <h4 style="color: var(--primary); margin: 2rem 0 1.5rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-cogs"></i> Configuración del Sistema
                    </h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="role" class="form-label">
                                Rol del Usuario <span class="required">*</span>
                            </label>
                            <select class="form-control @error('role') error @enderror" 
                                    id="role" 
                                    name="role" 
                                    required>
                                <option value="">Seleccionar rol...</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                    Administrador
                                </option>
                                <option value="cliente" {{ old('role') === 'cliente' ? 'selected' : '' }}>
                                    Cliente
                                </option>
                                <option value="demo" {{ old('role') === 'demo' ? 'selected' : '' }}>
                                    Demo
                                </option>
                            </select>
                            @error('role')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="expires-field" style="display: none;">
                            <label for="expires_at" class="form-label">
                                Fecha de Expiración <span class="required" id="expires-required">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('expires_at') error @enderror" 
                                   id="expires_at" 
                                   name="expires_at" 
                                   value="{{ old('expires_at', now()->addDays(30)->format('Y-m-d')) }}"
                                   min="{{ now()->addDay()->format('Y-m-d') }}">
                            @error('expires_at')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Solo para usuarios demo</div>
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <h4 style="color: var(--primary); margin: 2rem 0 1.5rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-comment-alt"></i> Información Adicional
                    </h4>
                    
                    <div class="form-grid">
                        <div class="form-group form-group-full">
                            <label for="comentarios_adicionales" class="form-label">
                                Comentarios Adicionales
                            </label>
                            <textarea class="form-control @error('comentarios_adicionales') error @enderror" 
                                      id="comentarios_adicionales" 
                                      name="comentarios_adicionales" 
                                      rows="4" 
                                      maxlength="500" 
                                      placeholder="Información adicional relevante...">{{ old('comentarios_adicionales') }}</textarea>
                            @error('comentarios_adicionales')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Máximo 500 caracteres</div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Crear Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('resources/js/advanced-form-validator.js') }}"></script>
    <script src="{{ asset('resources/js/location-handler.js') }}"></script>
@endsection

@section('additional-scripts')
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
            const roleSelect = document.getElementById('role');
            const expiresField = document.getElementById('expires-field');
            const expiresInput = document.getElementById('expires_at');
            const expiresRequired = document.getElementById('expires-required');
            const togglePassword = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('password');
            const tipoDocumento = document.getElementById('tipo_documento');
            const numeroDocumento = document.getElementById('numero_documento');
            const documentoHelp = document.getElementById('documento-help');
            
            const validator = new AdvancedFormValidator('user-form', {
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

            function toggleExpiresField() {
                if (roleSelect.value === 'demo') {
                    expiresField.style.display = 'block';
                    expiresInput.required = true;
                    expiresRequired.style.display = 'inline';
                } else {
                    expiresField.style.display = 'none';
                    expiresInput.required = false;
                    expiresRequired.style.display = 'none';
                    expiresInput.value = '';
                }
            }

            function updateDocumentFormat() {
                const tipo = tipoDocumento.value;
                const format = documentoFormats[tipo] || { placeholder: 'Ingrese el número de documento', help: 'Seleccione un tipo de documento para ver el formato', pattern: '' };
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

            roleSelect.addEventListener('change', toggleExpiresField);
            tipoDocumento.addEventListener('change', updateDocumentFormat);
            togglePassword.addEventListener('click', togglePasswordVisibility);

            document.getElementById('email').addEventListener('blur', function() { if (this.value) validator.validateField('email', this.value); });
            numeroDocumento.addEventListener('blur', function() { if (this.value && tipoDocumento.value) validator.checkDocumentAvailability(tipoDocumento.value, this.value); });
            document.getElementById('telefono_celular').addEventListener('blur', function() { if (this.value) validator.validateField('telefono_celular', this.value); });
            document.getElementById('password_confirmation').addEventListener('blur', function() { if (this.value) validator.validateField('password_confirmation', this.value); });

            toggleExpiresField();
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
                    'telefono_fijo': company.telefono_fijo || '',
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
                const fieldsToClear = ['razon_social', 'telefono_fijo', 'direccion_empresa', 'distrito'];
                fieldsToClear.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) {
                        field.value = '';
                    }
                });
            }

            function highlightFilledFields() {
                const fieldsToHighlight = ['razon_social', 'telefono_fijo', 'direccion_empresa', 'departamento', 'provincia', 'distrito'];
                fieldsToHighlight.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field && field.value) {
                        field.style.transition = 'all 0.3s ease';
                        field.style.backgroundColor = 'var(--success-light)';
                        field.style.borderColor = 'var(--success)';
                        
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
@endsection
