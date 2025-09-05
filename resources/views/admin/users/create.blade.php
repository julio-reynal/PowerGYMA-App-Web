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

                <form method="POST" action="{{ route('admin.users.store') }}">
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
                                Fecha de Expiración
                            </label>
                            <input type="date" 
                                   class="form-control @error('expires_at') error @enderror" 
                                   id="expires_at" 
                                   name="expires_at" 
                                   value="{{ old('expires_at') }}">
                            @error('expires_at')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Solo para usuarios demo</div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const expiresField = document.getElementById('expires-field');
            const expiresInput = document.getElementById('expires_at');
            
            function toggleExpiresField() {
                if (roleSelect.value === 'demo') {
                    expiresField.style.display = 'block';
                    expiresInput.required = true;
                } else {
                    expiresField.style.display = 'none';
                    expiresInput.required = false;
                    expiresInput.value = '';
                }
            }
            
            roleSelect.addEventListener('change', toggleExpiresField);
            
            // Ejecutar al cargar si ya hay un valor seleccionado
            toggleExpiresField();
        });
    </script>
</body>
</html>
