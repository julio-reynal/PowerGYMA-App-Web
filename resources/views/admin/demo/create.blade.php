<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Crear Usuario Demo - Power GYMA Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { 
            --bg: #f1f5f9; 
            --bg-secondary: #e2e8f0;
            --text: #0f172a; 
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --primary-light: #dbeafe;
            --success: #10b981;
            --success-light: #d1fae5;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --info: #06b6d4;
            --info-light: #cffafe;
            --demo: #8b5cf6;
            --demo-light: #ede9fe;
            --border: #e2e8f0;
            --border-light: #f1f5f9;
            --card: #ffffff;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius: 12px;
            --radius-sm: 8px;
        }
        
        * { box-sizing: border-box; }
        
        html, body { 
            height: 100%; 
            margin: 0; 
            background: var(--bg); 
            color: var(--text); 
            font-family: 'Inter', system-ui, sans-serif; 
            line-height: 1.6;
        }
        
        /* Header moderno */
        .header { 
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); 
            border-bottom: 1px solid var(--border); 
            padding: 1rem 2rem; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(10px);
            border-radius: 0 0 16px 16px;
        }
        
        .logo { 
            font-size: 1.5rem; 
            font-weight: 700; 
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .logo:hover {
            transform: translateY(-1px);
        }
        
        .logo svg {
            transition: all 0.3s ease;
        }
        
        .logo:hover svg {
            transform: scale(1.05);
        }
        
        .user-info { 
            display: flex; 
            align-items: center; 
            gap: 1rem; 
            flex-wrap: wrap;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            background: linear-gradient(135deg, var(--primary-light), rgba(59, 130, 246, 0.1));
            border-radius: var(--radius);
            font-weight: 500;
            border: 1px solid rgba(59, 130, 246, 0.2);
            transition: all 0.3s ease;
        }
        
        .user-profile:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }
        
        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
        }

        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.875rem 1.75rem;
            border: none;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            text-decoration: none;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: var(--radius);
            padding: 3rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .page-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: white;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            position: relative;
            z-index: 2;
        }

        .page-title i {
            background: rgba(255,255,255,0.2);
            padding: 0.75rem;
            border-radius: 50%;
            backdrop-filter: blur(10px);
        }

        .page-subtitle {
            color: rgba(255,255,255,0.9);
            font-size: 1.1rem;
            font-weight: 500;
            position: relative;
            z-index: 2;
        }

        .card {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: none;
            overflow: hidden;
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
            background-size: 300% 100%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card-body {
            padding: 3rem;
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,1) 100%);
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
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .required {
            color: var(--danger);
        }

        .form-control {
            padding: 1rem 1.25rem;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--card);
            position: relative;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .form-control.error {
            border-color: var(--danger);
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .form-text {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
            font-style: italic;
        }

        .error-message {
            font-size: 0.85rem;
            color: var(--danger);
            margin-top: 0.25rem;
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

        .demo-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: var(--radius);
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .demo-info::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .demo-info h3 {
            color: white;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            position: relative;
            z-index: 2;
        }

        .demo-info h3 i {
            background: rgba(255,255,255,0.2);
            padding: 0.5rem;
            border-radius: 50%;
            backdrop-filter: blur(10px);
        }

        .demo-features {
            list-style: none;
            color: white;
            position: relative;
            z-index: 2;
        }

        .demo-features li {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .demo-features li i {
            background: rgba(255,255,255,0.2);
            padding: 0.5rem;
            border-radius: 50%;
            backdrop-filter: blur(10px);
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1.5rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 2px solid var(--border-light);
            position: relative;
        }

        .form-actions::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
                padding: 1rem;
            }
            
            .user-info {
                flex-direction: column;
                width: 100%;
                gap: 0.5rem;
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
    <header class="header">
        <div class="logo">
            <img src="/Img/Ico/Ico-Pw.svg" alt="Power GYMA Logo" style="height: 48px;">
            <span style="font-size: 0.8rem; font-weight: 500; color: var(--primary); background: var(--primary-light); padding: 0.25rem 0.5rem; border-radius: 4px; margin-left: 0.5rem;">Admin</span>
        </div>
        <div class="user-info">
            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <a href="{{ route('admin.excel.index') }}" class="btn btn-info">
                <i class="fas fa-file-excel"></i>
                Gestión Excel
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                <i class="fas fa-user-plus"></i>
                Crear Usuario
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    Salir
                </button>
            </form>
        </div>
    </header>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-clock"></i>
                Crear Usuario Demo
            </h1>
            <p class="page-subtitle">
                Los usuarios demo tienen acceso limitado al sistema con fecha de expiración definida
            </p>
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

                <div class="demo-info">
                    <h3>
                        <i class="fas fa-rocket"></i>
                        Características del Usuario Demo
                    </h3>
                    <ul class="demo-features">
                        <li><i class="fas fa-check-circle"></i> Acceso limitado al dashboard</li>
                        <li><i class="fas fa-calendar-alt"></i> Cuenta con fecha de expiración automática</li>
                        <li><i class="fas fa-eye"></i> Solo visualización de datos, sin modificaciones</li>
                        <li><i class="fas fa-shield-alt"></i> Permisos restringidos del sistema</li>
                    </ul>
                </div>

                <form method="POST" action="{{ route('admin.demo.store') }}">
                    @csrf
                    
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
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">
                                Contraseña <span class="required">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') error @enderror" 
                                   id="password" 
                                   name="password" 
                                   required>
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Mínimo 8 caracteres</div>
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
                        </div>

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
                            @error('expires_at')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Por defecto 30 días desde hoy</div>
                        </div>

                        <div class="form-group">
                            <label for="company" class="form-label">
                                Empresa (Opcional)
                            </label>
                            <input type="text" 
                                   class="form-control @error('company') error @enderror" 
                                   id="company" 
                                   name="company" 
                                   value="{{ old('company') }}">
                            @error('company')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Empresa o organización del usuario demo</div>
                        </div>
                    </div>

                    <input type="hidden" name="role" value="demo">

                    <div class="form-actions">
                        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Volver
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-rocket"></i>
                            Crear Usuario Demo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
