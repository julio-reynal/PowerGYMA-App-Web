@extends('layouts.admin')

@section('title', 'Crear Usuario Demo')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0">
                        <i class="fas fa-clock text-warning"></i> Crear Usuario Demo
                    </h1>
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <h6>Por favor corrige los siguientes errores:</h6>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="alert alert-info mb-4">
                <h6><i class="fas fa-info-circle"></i> Información sobre usuarios Demo</h6>
                <p class="mb-0">
                    Los usuarios demo tienen acceso limitado al sistema con una fecha de expiración definida. 
                    Después de la expiración, no podrán iniciar sesión hasta que se extienda su acceso.
                </p>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-clock"></i> Información del Usuario Demo
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.demo.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    Nombre Completo 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Ej: Juan Pérez Demo"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    Correo Electrónico 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="usuario@ejemplo.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    Contraseña 
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Mínimo 8 caracteres</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">
                                    Confirmar Contraseña 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="expires_at" class="form-label">
                                    Fecha de Expiración 
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('expires_at') is-invalid @enderror" 
                                       id="expires_at" 
                                       name="expires_at" 
                                       value="{{ old('expires_at', now()->addDays(30)->format('Y-m-d')) }}" 
                                       min="{{ now()->addDay()->format('Y-m-d') }}"
                                       required>
                                @error('expires_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">La fecha debe ser posterior a hoy</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Acceso Estimado</label>
                                <div class="form-control-plaintext">
                                    <span id="access-duration" class="badge bg-info fs-6">
                                        Calculando...
                                    </span>
                                </div>
                                <div class="form-text">Tiempo de acceso desde hoy</div>
                            </div>
                        </div>

                        <!-- Información adicional -->
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-shield-alt text-warning"></i> 
                                            Configuración del Usuario Demo
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul class="list-unstyled mb-0">
                                                    <li><i class="fas fa-check text-success"></i> Rol: <strong>Demo</strong></li>
                                                    <li><i class="fas fa-check text-success"></i> Estado: <strong>Activo</strong></li>
                                                    <li><i class="fas fa-clock text-info"></i> Acceso temporal</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-unstyled mb-0">
                                                    <li><i class="fas fa-eye text-primary"></i> Dashboard de demo</li>
                                                    <li><i class="fas fa-ban text-warning"></i> Sin gestión de datos</li>
                                                    <li><i class="fas fa-calendar-times text-danger"></i> Expira automáticamente</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-user-clock"></i> Crear Usuario Demo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
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

body {
    background: linear-gradient(135deg, var(--bg) 0%, #e0e7ff 100%);
    min-height: 100vh;
}

.page-header {
    background: linear-gradient(135deg, var(--demo) 0%, #7c3aed 100%);
    color: white;
    padding: 2rem;
    border-radius: var(--radius) var(--radius) 0 0;
    margin-bottom: 0;
    box-shadow: var(--shadow-lg);
    border-bottom: none;
}

.page-header .d-flex {
    align-items: center;
    justify-content: space-between;
}

.page-header .h3 {
    font-size: 1.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0;
}

.btn-outline-secondary {
    background: rgba(255,255,255,0.2);
    color: white;
    border: 1px solid rgba(255,255,255,0.3);
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-sm);
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-outline-secondary:hover {
    background: rgba(255,255,255,0.3);
    color: white;
    transform: translateY(-1px);
    text-decoration: none;
}

.alert {
    border: none;
    border-radius: var(--radius-sm);
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.alert-info {
    background: var(--demo-light);
    color: #581c87;
    border: 1px solid var(--demo);
}

.alert-info h6 {
    color: #581c87;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-danger {
    background: var(--danger-light);
    color: #991b1b;
    border: 1px solid var(--danger);
}

.alert-danger h6 {
    color: #991b1b;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.card {
    background: var(--white);
    border: none;
    border-radius: 0 0 var(--radius) var(--radius);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
}

.card-header {
    background: var(--demo-light);
    border-bottom: 1px solid var(--demo);
    padding: 1.5rem 2rem;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #581c87;
    margin-bottom: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-body {
    padding: 2.5rem;
}

.form-label {
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.text-danger {
    color: var(--danger);
    font-weight: 600;
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
    border-color: var(--demo);
    box-shadow: 0 0 0 3px var(--demo-light);
}

.form-control.is-invalid {
    border-color: var(--danger);
}

.form-text {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin-top: 0.25rem;
}

.invalid-feedback {
    font-size: 0.85rem;
    color: var(--danger);
    margin-top: 0.25rem;
}

.input-group .btn-outline-secondary {
    background: var(--text-muted);
    border-color: var(--border);
    color: white;
    border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
}

.input-group .btn-outline-secondary:hover {
    background: var(--text);
    transform: none;
}

.card.bg-light {
    background: var(--demo-light) !important;
    border: 1px solid var(--demo);
    border-radius: var(--radius-sm);
    margin-bottom: 1.5rem;
}

.card.bg-light .card-body {
    padding: 1.5rem;
    background: transparent;
}

.card.bg-light .card-title {
    color: #581c87;
    font-weight: 600;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card.bg-light .list-unstyled li {
    color: #581c87;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.badge {
    padding: 0.5rem 1rem;
    border-radius: var(--radius-sm);
    font-weight: 600;
    font-size: 0.875rem !important;
}

.badge.bg-info {
    background: var(--info) !important;
    color: white;
}

.badge.bg-warning {
    background: var(--warning) !important;
    color: white;
}

.badge.bg-success {
    background: var(--success) !important;
    color: white;
}

.badge.bg-danger {
    background: var(--danger) !important;
    color: white;
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

.btn-secondary {
    background: var(--text-muted);
    color: white;
}

.btn-secondary:hover {
    background: var(--text);
    transform: translateY(-1px);
}

.btn-warning {
    background: linear-gradient(135deg, var(--demo), #7c3aed);
    color: white;
}

.btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.gap-2 {
    gap: 1rem !important;
}

.d-flex.justify-content-end {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
}

.row.justify-content-center {
    min-height: auto;
    padding-top: 2rem;
}

@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
        text-align: center;
    }
    
    .page-header .d-flex {
        flex-direction: column;
        gap: 1rem;
        align-items: center;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .d-flex.justify-content-end {
        flex-direction: column;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const expiresInput = document.getElementById('expires_at');
    const accessDuration = document.getElementById('access-duration');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    // Calcular duración del acceso
    function calculateAccessDuration() {
        const expiresDate = new Date(expiresInput.value);
        const today = new Date();
        
        if (expiresDate > today) {
            const diffTime = Math.abs(expiresDate - today);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays === 1) {
                accessDuration.textContent = '1 día';
                accessDuration.className = 'badge bg-warning fs-6';
            } else if (diffDays <= 7) {
                accessDuration.textContent = `${diffDays} días`;
                accessDuration.className = 'badge bg-warning fs-6';
            } else if (diffDays <= 30) {
                accessDuration.textContent = `${diffDays} días`;
                accessDuration.className = 'badge bg-info fs-6';
            } else {
                const months = Math.floor(diffDays / 30);
                const remainingDays = diffDays % 30;
                let text = `${months} mes${months > 1 ? 'es' : ''}`;
                if (remainingDays > 0) {
                    text += ` y ${remainingDays} día${remainingDays > 1 ? 's' : ''}`;
                }
                accessDuration.textContent = text;
                accessDuration.className = 'badge bg-success fs-6';
            }
        } else {
            accessDuration.textContent = 'Fecha inválida';
            accessDuration.className = 'badge bg-danger fs-6';
        }
    }
    
    // Toggle mostrar/ocultar contraseña
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        const icon = this.querySelector('i');
        if (type === 'password') {
            icon.className = 'fas fa-eye';
        } else {
            icon.className = 'fas fa-eye-slash';
        }
    });
    
    // Escuchar cambios en la fecha de expiración
    expiresInput.addEventListener('change', calculateAccessDuration);
    
    // Calcular inicialmente
    calculateAccessDuration();
});
</script>
@endpush
