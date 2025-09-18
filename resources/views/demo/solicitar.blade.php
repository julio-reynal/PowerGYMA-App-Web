<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, viewport-fit=cover" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1e293b" media="(prefers-color-scheme: dark)">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Solicitar Demo - Power GYMA</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        /* --- CSS Properties for Animation --- */
        @property --angle {
          syntax: '<angle>';
          initial-value: 0deg;
          inherits: false;
        }

        /* --- Reset and Base Styles --- */
        :root {
            --primary-color: #1d4ed8; /* Blue */
            --secondary-color: #f59e0b; /* Amber */
            --secondary-hover: #d97706;
            --bg-color: #f1f5f9;
            --card-bg-color: #ffffff;
            --text-dark-color: #1e293b;
            --text-light-color: #f8fafc;
            --text-muted-color: #64748b;
            --border-color: #cbd5e1;
            --input-bg-color: #f8fafc;
            --focus-shadow-color: rgba(29, 78, 216, 0.2);
            --danger-color: #ef4444;
            --angle: 0deg; /* Initial angle for gradient */
        }

        body.dark {
            --bg-color: #000000;
            --card-bg-color: #111827; /* Azul medianoche oscuro */
            --text-dark-color: #f8fafc;
            --text-muted-color: #9ca3af;
            --border-color: #374151;
            --input-bg-color: #1f2937;
            --focus-shadow-color: rgba(59, 130, 246, 0.25);
        }

        html {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark-color);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        * {
            box-sizing: border-box;
        }

        @keyframes spin {
          to {
            --angle: 360deg;
          }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- Main Container Layout --- */
        .main-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .left-panel {
            width: 45%;
            background: linear-gradient(rgba(29, 78, 216, 0.85), rgba(29, 78, 216, 0.85)), url(https://images.unsplash.com/photo-1605379399642-870262d3d051?q=80&w=2106&auto=format&fit=crop) center/cover no-repeat;
            color: var(--text-light-color);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 4rem;
            text-align: left;
        }

        .left-panel .logo {
            width: 80px;
            height: auto;
            margin-bottom: 2rem;
            filter: brightness(0) invert(1); /* Make SVG white */
        }

        .promo-text h1 {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .promo-text p {
            font-size: 1.1rem;
            max-width: 450px;
            opacity: 0.9;
        }

        .copyright {
            font-size: 0.875rem;
            opacity: 0.8;
        }

        .right-panel {
            width: 55%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow-y: auto;
        }
        
        /* --- Demo Card and Form --- */
        .card-outer {
             width: 100%;
             max-width: 800px;
        }

        .animated-border-wrapper {
            padding: 3px; /* This padding creates the border thickness */
            border-radius: 1.1rem; /* Slightly larger than the card's radius */
            background: conic-gradient(from var(--angle), var(--primary-color), var(--secondary-color), var(--primary-color));
            animation: spin 4s linear infinite;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        }

        .demo-card {
            background-color: var(--card-bg-color);
            padding: 2.5rem;
            border-radius: 1rem;
            width: 100%;
            position: relative;
            transition: background-color 0.3s ease;
        }

        .theme-toggle {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background-color: var(--input-bg-color);
            border: 1px solid var(--border-color);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-muted-color);
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }
        .theme-toggle:hover {
            color: var(--text-dark-color);
            border-color: var(--primary-color);
        }

        .form-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-header h1 {
            font-size: 2rem;
            font-weight: 600;
            color: var(--text-dark-color);
        }
        
        .form-header p {
            color: var(--text-muted-color);
            margin-top: 0.5rem;
        }

        /* --- Progress Bar --- */
        .progress-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            position: relative;
        }
        .progress-bar::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 2px;
            width: 100%;
            background-color: var(--border-color);
            z-index: 1;
        }
        #progress-line {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 2px;
            width: 0%; /* Initially 0 */
            background-color: var(--primary-color);
            z-index: 2;
            transition: width 0.4s ease;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: var(--text-muted-color);
            z-index: 3;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .step-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--card-bg-color);
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
            transition: all 0.4s ease;
        }

        .progress-step.active .step-icon {
            border-color: var(--primary-color);
            background-color: var(--primary-color);
            color: white;
        }
        .progress-step.active {
             color: var(--primary-color);
        }


        /* --- Form Steps --- */
        .form-step {
            display: none;
            animation: fadeIn 0.5s ease-in-out;
        }
        .form-step.active {
            display: block;
        }

        .form-section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        
        .grid-full-width {
            grid-column: 1 / -1;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
        }
        
        .form-group label .required {
            color: var(--danger-color);
            margin-left: 2px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-left: 2.75rem; /* Space for icon */
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
            background-color: var(--input-bg-color);
            color: var(--text-dark-color);
            transition: all 0.2s;
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--focus-shadow-color);
        }
        
        .form-control::placeholder {
            color: var(--text-muted-color);
        }
        
        .form-control.invalid {
            border-color: var(--danger-color);
        }

        .input-wrapper .icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted-color);
            font-size: 1.2rem;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
            padding-left: 1rem;
        }
        
        /* --- Custom Select --- */
        .custom-select-wrapper {
            position: relative;
        }
        .custom-select-wrapper select {
            display: none; /* Hide original select */
        }
        .custom-select {
            position: relative;
            cursor: pointer;
        }
        .custom-select-trigger {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-left: 2.75rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
            background-color: var(--input-bg-color);
            color: var(--text-dark-color);
            transition: all 0.2s;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .custom-select-trigger.placeholder {
            color: var(--text-muted-color);
        }
        .custom-select.open .custom-select-trigger {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--focus-shadow-color);
        }
        .custom-select-trigger::after {
            content: '\ea4a'; /* Boxicon chevron-down */
            font-family: 'Boxicons';
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }
        .custom-select.open .custom-select-trigger::after {
            transform: rotate(180deg);
        }

        .custom-options {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            width: 100%;
            background-color: var(--card-bg-color);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 10;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
            max-height: 200px;
            overflow-y: auto;
        }
        .custom-select.open .custom-options {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .custom-option {
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .custom-option:hover {
            background-color: var(--input-bg-color);
        }
        .custom-option.selected {
            background-color: var(--primary-color);
            color: white;
        }


        /* --- Checkbox & Terms --- */
        .terms-group {
            margin-top: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .checkbox-label {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            cursor: pointer;
        }
        
        .checkbox-label input[type="checkbox"] {
            margin-right: 0.75rem;
            width: 1em;
            height: 1em;
            accent-color: var(--primary-color);
        }

        .checkbox-label a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        .checkbox-label a:hover {
            text-decoration: underline;
        }

        /* --- Form Navigation Buttons --- */
        .form-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-prev {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-dark-color);
        }
        .btn-prev:hover {
            background-color: var(--input-bg-color);
        }

        .btn-next {
            background-color: var(--secondary-color);
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-next:hover {
            background-color: var(--secondary-hover);
        }

        /* --- Footer Link --- */
        .footer-link {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
        }
        .footer-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        .footer-link a:hover {
            text-decoration: underline;
        }

        /* --- Alert Styles --- */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .alert.success {
            background: #d1fae5;
            color: #065f46;
            border-color: #10b981;
        }

        .alert.error {
            background: #fee2e2;
            color: #991b1b;
            border-color: #ef4444;
        }

        /* --- Responsive Design --- */
        @media (max-width: 1200px) {
            .left-panel {
                width: 40%;
                padding: 2.5rem;
            }
            .right-panel {
                width: 60%;
            }
            .promo-text h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 992px) {
            .left-panel {
                display: none; /* Hide decorative panel on smaller screens */
            }
            .right-panel {
                width: 100%;
                min-height: 100vh;
                padding: 1.5rem;
            }
            .card-outer {
                max-width: 100%;
            }
            .demo-card {
                padding: 2rem 1.5rem;
            }
        }
         @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
         }
        @media (max-width: 576px) {
             .progress-step span {
                display: none; /* Hide text on very small screens */
             }
            .form-navigation {
                flex-direction: column-reverse;
                gap: 1rem;
            }
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Left Decorative Panel -->
        <div class="left-panel">
            <div>
                <img src="{{ asset('Img/Ico/Ico-Pw.svg') }}" alt="Power GYMA Logo" class="logo">
                <div class="promo-text">
                    <h1>Controla tu consumo, potencia tu ahorro.</h1>
                    <p>Descubra cómo Power GYMA puede ayudar a su empresa a controlar el consumo energético y potenciar el ahorro. Complete este formulario y nos pondremos en contacto con usted.</p>
                </div>
            </div>
            <div class="copyright">
                © <span id="copyright-year"></span> POWERGYMA. Todos los derechos reservados.
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="right-panel">
            <div class="card-outer">
                <div class="animated-border-wrapper">
                    <div class="demo-card">
                        
                        <button id="theme-toggle" type="button" class="theme-toggle" aria-label="Cambiar tema">
                            <i class='bx bxs-moon'></i>
                        </button>
                        
                        <div class="form-header">
                            <h1>Solicitar Demo</h1>
                            <p>Complete los siguientes pasos para solicitar su demostración.</p>
                        </div>

                        <!-- Progress Bar -->
                        <div class="progress-bar">
                             <div id="progress-line"></div>
                            <div class="progress-step active" data-step="1">
                                <div class="step-icon"><i class='bx bx-user'></i></div>
                                <span>Personal</span>
                            </div>
                            <div class="progress-step" data-step="2">
                                <div class="step-icon"><i class='bx bx-building-house'></i></div>
                                <span>Empresa</span>
                            </div>
                            <div class="progress-step" data-step="3">
                                <div class="step-icon"><i class='bx bx-map-alt'></i></div>
                                <span>Ubicación</span>
                            </div>
                            <div class="progress-step" data-step="4">
                                <div class="step-icon"><i class='bx bx-desktop'></i></div>
                                <span>Demo</span>
                            </div>
                        </div>

                        <!-- Alert Messages -->
                        @if (session('success'))
                            <div class="alert success">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert error">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert error">
                                <i class="fas fa-exclamation-triangle"></i>
                                <div>
                                    <strong>Por favor corrija los siguientes errores:</strong>
                                    <ul style="margin: 0.5rem 0 0 1rem; list-style: disc;">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('demo.store') }}" method="POST" id="demo-form" novalidate>
                            @csrf

                            <!-- Step 1: Personal Information -->
                            <div class="form-step active">
                                <h2 class="form-section-title">Información Personal</h2>
                                <div class="form-grid">
                                    <div class="form-group grid-full-width">
                                        <label for="nombre">Nombre Completo <span class="required">*</span></label>
                                        <div class="input-wrapper">
                                            <i class='bx bx-user icon'></i>
                                            <input type="text" id="nombre" name="nombre" class="form-control" required 
                                                   placeholder="Ej: Juan Pérez" value="{{ old('nombre') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Correo Electrónico <span class="required">*</span></label>
                                        <div class="input-wrapper">
                                            <i class='bx bx-envelope icon'></i>
                                            <input type="email" id="email" name="email" class="form-control" required 
                                                   placeholder="nombre@ejemplo.com" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="telefono_celular">Teléfono Celular</label>
                                        <div class="input-wrapper">
                                            <i class='bx bx-mobile-alt icon'></i>
                                            <input type="tel" id="telefono_celular" name="telefono_celular" class="form-control" 
                                                   placeholder="987 654 321" value="{{ old('telefono_celular') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tipo_documento">Tipo de Documento <span class="required">*</span></label>
                                        <div class="input-wrapper">
                                            <i class='bx bx-id-card icon'></i>
                                            <select id="tipo_documento" name="tipo_documento" class="form-control" required>
                                                <option value="" disabled selected>Seleccione un tipo</option>
                                                @foreach(\App\Models\DemoRequest::TIPOS_DOCUMENTO as $key => $label)
                                                    <option value="{{ $key }}" {{ old('tipo_documento') == $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="numero_documento">Número de Documento</label>
                                        <div class="input-wrapper">
                                            <i class='bx bx-hash icon'></i>
                                            <input type="text" id="numero_documento" name="numero_documento" class="form-control" 
                                                   placeholder="Ingrese el número" value="{{ old('numero_documento') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Company Information -->
                            <div class="form-step">
                                <h2 class="form-section-title">Información de la Empresa</h2>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="empresa">Nombre de la Empresa <span class="required">*</span></label>
                                        <div class="input-wrapper">
                                            <i class='bx bx-building-house icon'></i>
                                            <input type="text" id="empresa" name="empresa" class="form-control" required 
                                                   placeholder="Nombre de su empresa" value="{{ old('empresa') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ruc_empresa">RUC de la Empresa</label>
                                        <div class="input-wrapper">
                                            <i class='bx bx-spreadsheet icon'></i>
                                            <input type="text" id="ruc_empresa" name="ruc_empresa" class="form-control" 
                                                   placeholder="20100100101" value="{{ old('ruc_empresa') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="giro_empresa">Giro de la Empresa</label>
                                        <div class="input-wrapper">
                                            <i class='bx bx-briefcase-alt-2 icon'></i>
                                            <input type="text" id="giro_empresa" name="giro_empresa" class="form-control" 
                                                   placeholder="Ej: Manufactura, Retail" value="{{ old('giro_empresa') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cargo_puesto">Cargo o Puesto</label>
                                        <div class="input-wrapper">
                                            <i class='bx bx-user-pin icon'></i>
                                            <input type="text" id="cargo_puesto" name="cargo_puesto" class="form-control" 
                                                   placeholder="Ej: Gerente de Operaciones" value="{{ old('cargo_puesto') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Location -->
                            <div class="form-step">
                                <h2 class="form-section-title">Ubicación</h2>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="departamento_id">Departamento</label>
                                        <div class="input-wrapper">
                                            <i class='bx bx-map-alt icon'></i>
                                            <select id="departamento_id" name="departamento_id" class="form-control">
                                                <option value="" disabled selected>Seleccione</option>
                                                @foreach($departamentos as $departamento)
                                                    <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                                        {{ $departamento->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="provincia_id">Provincia</label>
                                        <div class="input-wrapper">
                                            <i class='bx bx-map icon'></i>
                                            <select id="provincia_id" name="provincia_id" class="form-control" disabled>
                                                <option value="" disabled selected>Seleccione</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="direccion">Dirección</label>
                                        <div class="input-wrapper">
                                            <i class='bx bx-home-alt icon'></i>
                                            <textarea id="direccion" name="direccion" class="form-control" 
                                                      placeholder="Av. Principal 123">{{ old('direccion') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ciudad">Ciudad/Distrito</label>
                                        <div class="input-wrapper">
                                            <i class='bx bxs-city icon'></i>
                                            <input type="text" id="ciudad" name="ciudad" class="form-control" 
                                                   placeholder="Ej: Miraflores" value="{{ old('ciudad') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4: Demo Information -->
                            <div class="form-step">
                                 <h2 class="form-section-title">Información del Demo</h2>
                                <div class="form-grid">
                                    <div class="form-group grid-full-width">
                                        <label for="tipo_demo">Tipo de Demo <span class="required">*</span></label>
                                        <div class="input-wrapper">
                                            <i class='bx bx-desktop icon'></i>
                                            <select id="tipo_demo" name="tipo_demo" class="form-control" required>
                                                <option value="" disabled selected>Seleccione el tipo de demo</option>
                                                @foreach(\App\Models\DemoRequest::TIPOS_DEMO as $key => $label)
                                                    <option value="{{ $key }}" {{ old('tipo_demo') == $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group grid-full-width">
                                        <label for="necesidades_especificas">Necesidades Específicas</label>
                                        <textarea id="necesidades_especificas" name="necesidades_especificas" class="form-control" 
                                                  placeholder="Describa brevemente qué busca solucionar o mejorar...">{{ old('necesidades_especificas') }}</textarea>
                                    </div>
                                    <div class="form-group grid-full-width">
                                        <label for="comentarios">Comentarios Adicionales</label>
                                        <textarea id="comentarios" name="comentarios" class="form-control" 
                                                  placeholder="¿Hay algo más que debamos saber?">{{ old('comentarios') }}</textarea>
                                    </div>
                                </div>
                                <div class="terms-group grid-full-width">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="acepta_terminos" value="1" required {{ old('acepta_terminos') ? 'checked' : '' }}>
                                        <span>Acepto los <a href="#">términos y condiciones</a> y la <a href="#">política de privacidad</a> <span class="required">*</span></span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="acepta_marketing" value="1" {{ old('acepta_marketing') ? 'checked' : '' }}>
                                        <span>Acepto recibir comunicaciones comerciales de Power GYMA</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Navigation -->
                            <div class="form-navigation">
                                <button type="button" class="btn btn-prev" style="display: none;">Anterior</button>
                                <button type="button" class="btn btn-next">Siguiente <i class="fas fa-arrow-right"></i></button>
                            </div>
                        </form>

                        <div class="footer-link">
                            <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar Sesión</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Theme Toggler ---
            const themeToggle = document.getElementById('theme-toggle');
            const themeToggleIcon = themeToggle.querySelector('i');
            const currentTheme = localStorage.getItem('theme');

            if (currentTheme === 'dark') {
                document.body.classList.add('dark');
                themeToggleIcon.className = 'bx bxs-sun';
            }

            themeToggle.addEventListener('click', () => {
                document.body.classList.toggle('dark');
                let theme = 'light';
                if (document.body.classList.contains('dark')) {
                    theme = 'dark';
                    themeToggleIcon.className = 'bx bxs-sun';
                } else {
                    themeToggleIcon.className = 'bx bxs-moon';
                }
                localStorage.setItem('theme', theme);
            });

            // --- Multi-Step Form Logic ---
            const steps = document.querySelectorAll('.form-step');
            const prevBtn = document.querySelector('.btn-prev');
            const nextBtn = document.querySelector('.btn-next');
            const progressSteps = document.querySelectorAll('.progress-step');
            const progressLine = document.getElementById('progress-line');
            let currentStep = 0;

            function validateStep(stepIndex) {
                const currentStepFields = steps[stepIndex].querySelectorAll('[required]');
                let isValid = true;
                currentStepFields.forEach(field => {
                    // For checkboxes, check the 'checked' property
                    if (field.type === 'checkbox' && !field.checked) {
                        isValid = false;
                        field.closest('.checkbox-label').classList.add('invalid'); // Or some visual cue
                    } 
                    // For other inputs/selects, check the value
                    else if (field.type !== 'checkbox' && !field.value.trim()) {
                        isValid = false;
                        field.classList.add('invalid');
                    } else {
                         if (field.type === 'checkbox') {
                             field.closest('.checkbox-label').classList.remove('invalid');
                         } else {
                            field.classList.remove('invalid');
                         }
                    }
                });
                 if (!isValid) {
                     alert("Por favor, complete todos los campos obligatorios.");
                 }
                return isValid;
            }

            function updateFormSteps() {
                steps.forEach((step, index) => {
                    step.classList.toggle('active', index === currentStep);
                });

                progressSteps.forEach((step, index) => {
                    step.classList.toggle('active', index <= currentStep);
                });
                
                const progressPercentage = (currentStep / (steps.length - 1)) * 100;
                progressLine.style.width = progressPercentage + '%';

                prevBtn.style.display = currentStep > 0 ? 'inline-block' : 'none';
                
                if (currentStep === steps.length - 1) {
                    nextBtn.innerHTML = 'Enviar Solicitud <i class="fas fa-paper-plane"></i>';
                } else {
                    nextBtn.innerHTML = 'Siguiente <i class="fas fa-arrow-right"></i>';
                }
            }

            nextBtn.addEventListener('click', () => {
                if (currentStep === steps.length - 1) {
                    // Submit form
                    if (validateStep(currentStep)) {
                        document.getElementById('demo-form').submit();
                    }
                } else {
                    // Go to next step
                    if (validateStep(currentStep)) {
                        currentStep++;
                        updateFormSteps();
                    }
                }
            });

            prevBtn.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    updateFormSteps();
                }
            });

            // --- Copyright Year ---
            const yearSpan = document.getElementById('copyright-year');
            if(yearSpan) {
                yearSpan.textContent = new Date().getFullYear();
            }

            // --- Dependent Dropdowns for Locations ---
            const departamentoSelect = document.getElementById('departamento_id');
            const provinciaSelect = document.getElementById('provincia_id');
            
            departamentoSelect.addEventListener('change', function() {
                const departamentoId = this.value;
                
                // Limpiar provincias
                provinciaSelect.innerHTML = '<option value="">Cargando...</option>';
                provinciaSelect.disabled = true;
                
                if (departamentoId) {
                    fetch(`/api/demo/provincias/${departamentoId}`)
                        .then(response => response.json())
                        .then(provincias => {
                            provinciaSelect.innerHTML = '<option value="">Seleccione una provincia</option>';
                            provincias.forEach(provincia => {
                                const option = document.createElement('option');
                                option.value = provincia.id;
                                option.textContent = provincia.nombre;
                                provinciaSelect.appendChild(option);
                            });
                            provinciaSelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            provinciaSelect.innerHTML = '<option value="">Error al cargar provincias</option>';
                        });
                } else {
                    provinciaSelect.innerHTML = '<option value="">Primero seleccione un departamento</option>';
                }
            });

            // --- Email Validation ---
            const emailInput = document.getElementById('email');
            let emailTimeout;
            
            emailInput.addEventListener('input', function() {
                clearTimeout(emailTimeout);
                const email = this.value;
                
                if (email && email.includes('@')) {
                    emailTimeout = setTimeout(() => {
                        fetch('/api/demo/check-email', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ email: email })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.available) {
                                emailInput.setCustomValidity('Ya existe una solicitud con este email');
                                emailInput.reportValidity();
                            } else {
                                emailInput.setCustomValidity('');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }, 500);
                }
            });
        });
    </script>
</body>
</html>