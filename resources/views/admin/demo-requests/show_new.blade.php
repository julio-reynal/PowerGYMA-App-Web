<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Solicitud Demo #{{ $demoRequest->id }} - Power GYMA Admin</title>
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
        }
        
        .logo { 
            font-size: 1.5rem; 
            font-weight: 700; 
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .breadcrumb-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .breadcrumb-container a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .breadcrumb-container a:hover {
            color: var(--primary-dark);
        }
        
        .user-info { 
            display: flex; 
            align-items: center; 
            gap: 1rem; 
        }
        
        /* Botones mejorados */
        .btn { 
            padding: 0.75rem 1.5rem; 
            border-radius: var(--radius-sm); 
            text-decoration: none; 
            font-weight: 500; 
            border: none; 
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }
        
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
            text-decoration: none;
        }
        
        .btn-primary { 
            background: linear-gradient(135deg, var(--primary), var(--primary-dark)); 
            color: white; 
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #d97706);
            color: white;
        }
        
        .btn-danger { 
            background: linear-gradient(135deg, var(--danger), #dc2626); 
            color: white; 
        }
        
        .btn-info {
            background: linear-gradient(135deg, var(--info), #0891b2);
            color: white;
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text);
        }
        
        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
        
        /* Container */
        .container { 
            max-width: 1400px; 
            margin: 0 auto; 
            padding: 2rem; 
        }
        
        /* Page header */
        .page-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--info));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
        }
        
        .page-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
            margin-top: 0.5rem;
        }
        
        .page-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }
        
        /* Layout grid */
        .detail-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        /* Cards mejoradas */
        .card { 
            background: var(--card); 
            border-radius: var(--radius); 
            border: 1px solid var(--border); 
            overflow: hidden;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }
        
        .card-header { 
            padding: 1.5rem; 
            border-bottom: 1px solid var(--border); 
            font-weight: 600;
            font-size: 1.1rem;
            background: linear-gradient(135deg, var(--primary-light), var(--info-light));
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .card-body { 
            padding: 1.5rem; 
        }
        
        /* Status card especial */
        .status-card {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            text-align: center;
            padding: 2rem;
            border-radius: var(--radius);
            margin-bottom: 2rem;
        }
        
        .status-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }
        
        .status-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .status-subtitle {
            opacity: 0.8;
            font-size: 1.1rem;
        }
        
        /* Field display */
        .field-group {
            margin-bottom: 1.5rem;
        }
        
        .field-label {
            font-weight: 600;
            color: var(--text-muted);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }
        
        .field-value {
            font-size: 1rem;
            color: var(--text);
            padding: 0.75rem;
            background: var(--border-light);
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            min-height: 2.5rem;
            display: flex;
            align-items: center;
        }
        
        .field-value.editable {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .field-value.editable:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }
        
        /* Contact info especial */
        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--border-light);
            border-radius: var(--radius-sm);
            margin-bottom: 1rem;
            transition: all 0.2s ease;
        }
        
        .contact-item:hover {
            background: var(--primary-light);
            transform: translateY(-1px);
        }
        
        .contact-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
        }
        
        .contact-info {
            flex: 1;
        }
        
        .contact-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 0.25rem;
        }
        
        .contact-value {
            font-weight: 500;
            color: var(--text);
        }
        
        .contact-action {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        
        .contact-action:hover {
            color: var(--primary-dark);
        }
        
        /* Badges mejorados */
        .badge { 
            padding: 0.5rem 1rem; 
            border-radius: 50px; 
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.025em;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .badge-primary { background: var(--primary-light); color: var(--primary-dark); }
        .badge-warning { background: var(--warning-light); color: #92400e; }
        .badge-info { background: var(--info-light); color: #0c4a6e; }
        .badge-success { background: var(--success-light); color: #065f46; }
        .badge-danger { background: var(--danger-light); color: #991b1b; }
        .badge-secondary { background: var(--border); color: var(--text-muted); }
        
        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 0.75rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--border);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2.25rem;
            top: 0.75rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary);
            border: 3px solid var(--card);
            box-shadow: 0 0 0 3px var(--border);
        }
        
        .timeline-content {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 1rem;
        }
        
        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .timeline-title {
            font-weight: 600;
            color: var(--text);
        }
        
        .timeline-date {
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        
        /* Inline editing */
        .editable-field {
            position: relative;
        }
        
        .edit-overlay {
            position: absolute;
            top: 0;
            right: 0;
            padding: 0.5rem;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        
        .editable-field:hover .edit-overlay {
            opacity: 1;
        }
        
        .edit-btn {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .edit-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.1);
        }
        
        /* Form styles para edición inline */
        .inline-form {
            display: none;
        }
        
        .inline-form.active {
            display: block;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--text);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-control {
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            transition: all 0.2s ease;
            background: var(--card);
            width: 100%;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
            margin-top: 1rem;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal.show {
            display: flex;
        }
        
        .modal-dialog {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 500px;
            margin: 1rem;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .modal-close:hover {
            background: var(--border-light);
            color: var(--text);
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .timeline {
                padding-left: 1rem;
            }
            
            .timeline::before {
                left: 0.25rem;
            }
            
            .timeline-item::before {
                left: -1.75rem;
            }
        }
        
        /* Animaciones */
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Notifications */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1100;
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 300px;
            box-shadow: var(--shadow-lg);
            animation: slideIn 0.3s ease-out;
        }
        
        .notification.success { background: var(--success); }
        .notification.error { background: var(--danger); }
        .notification.warning { background: var(--warning); }
        .notification.info { background: var(--info); }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="/Img/Ico/Ico-Pw.svg" alt="Power GYMA Logo" style="height: 40px;">
            <div>
                <div style="font-size: 1.2rem;">Power GYMA</div>
                <div class="breadcrumb-container">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i>
                    <a href="{{ route('admin.demo-requests.index') }}">Solicitudes Demo</a>
                    <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i>
                    <span>Solicitud #{{ $demoRequest->id }}</span>
                </div>
            </div>
        </div>
        <div class="user-info">
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-outline btn-sm">
                    <i class="fas fa-sign-out-alt"></i>
                    Salir
                </button>
            </form>
        </div>
    </header>

    <div class="container fade-in">
        <div class="page-header">
            <div>
                <h1 class="page-title">Solicitud Demo #{{ $demoRequest->id }}</h1>
                <p class="page-subtitle">
                    Recibida el {{ $demoRequest->created_at->format('d/m/Y') }} a las {{ $demoRequest->created_at->format('H:i') }}
                </p>
            </div>
            <div class="page-actions">
                <button type="button" class="btn btn-warning" onclick="openEditModal()">
                    <i class="fas fa-edit"></i>
                    Cambiar Estado
                </button>
                <a href="{{ route('admin.demo-requests.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i>
                    Volver a Lista
                </a>
            </div>
        </div>

        <!-- Status Card Principal -->
        <div class="status-card" style="background: {{ $demoRequest->estado == 'pendiente' ? 'linear-gradient(135deg, var(--warning), #d97706)' : ($demoRequest->estado == 'contactado' ? 'linear-gradient(135deg, var(--info), #0891b2)' : ($demoRequest->estado == 'programado' ? 'linear-gradient(135deg, var(--primary), var(--primary-dark))' : ($demoRequest->estado == 'completado' ? 'linear-gradient(135deg, var(--success), #059669)' : 'linear-gradient(135deg, var(--danger), #dc2626)'))) }};">
            <div class="status-icon">
                @if($demoRequest->estado == 'pendiente')
                    <i class="fas fa-clock"></i>
                @elseif($demoRequest->estado == 'contactado')
                    <i class="fas fa-phone"></i>
                @elseif($demoRequest->estado == 'programado')
                    <i class="fas fa-calendar-check"></i>
                @elseif($demoRequest->estado == 'completado')
                    <i class="fas fa-check-circle"></i>
                @else
                    <i class="fas fa-times-circle"></i>
                @endif
            </div>
            <div class="status-title">
                {{ ucfirst($demoRequest->estado) }}
            </div>
            <div class="status-subtitle">
                {{ $demoRequest->nombre }} {{ $demoRequest->apellido ?? '' }} - {{ $demoRequest->empresa ?? 'Sin empresa' }}
            </div>
        </div>

        <!-- Grid Principal -->
        <div class="detail-grid">
            <!-- Columna Principal -->
            <div>
                <!-- Información Personal -->
                <div class="card">
                    <div class="card-header">
                        <h3 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-user"></i>
                            Información Personal
                        </h3>
                    </div>
                    <div class="card-body">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                            <div class="field-group editable-field">
                                <div class="field-label">Nombre Completo</div>
                                <div class="field-value editable" onclick="editField('nombre')">
                                    {{ $demoRequest->nombre }} {{ $demoRequest->apellido ?? '' }}
                                </div>
                                <div class="edit-overlay">
                                    <button class="edit-btn" onclick="editField('nombre')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="field-group editable-field">
                                <div class="field-label">Cargo</div>
                                <div class="field-value editable" onclick="editField('cargo')">
                                    {{ $demoRequest->cargo ?? 'No especificado' }}
                                </div>
                                <div class="edit-overlay">
                                    <button class="edit-btn" onclick="editField('cargo')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="field-group editable-field">
                                <div class="field-label">Empresa</div>
                                <div class="field-value editable" onclick="editField('empresa')">
                                    {{ $demoRequest->empresa ?? 'No especificada' }}
                                </div>
                                <div class="edit-overlay">
                                    <button class="edit-btn" onclick="editField('empresa')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="field-group">
                                <div class="field-label">Tamaño de Empresa</div>
                                <div class="field-value">
                                    {{ $demoRequest->tamaño_empresa ?? 'No especificado' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="card">
                    <div class="card-header">
                        <h3 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-address-book"></i>
                            Información de Contacto
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="contact-item">
                            <div class="contact-icon" style="background: var(--info);">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-info">
                                <div class="contact-label">Email</div>
                                <div class="contact-value">{{ $demoRequest->email }}</div>
                            </div>
                            <a href="mailto:{{ $demoRequest->email }}" class="contact-action">
                                <i class="fas fa-external-link-alt"></i>
                                Enviar Email
                            </a>
                        </div>
                        
                        @if($demoRequest->telefono)
                        <div class="contact-item">
                            <div class="contact-icon" style="background: var(--success);">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-info">
                                <div class="contact-label">Teléfono Principal</div>
                                <div class="contact-value">{{ $demoRequest->telefono }}</div>
                            </div>
                            <a href="tel:{{ $demoRequest->telefono }}" class="contact-action">
                                <i class="fas fa-phone"></i>
                                Llamar
                            </a>
                        </div>
                        @endif
                        
                        @if($demoRequest->telefono_celular)
                        <div class="contact-item">
                            <div class="contact-icon" style="background: var(--warning);">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="contact-info">
                                <div class="contact-label">Teléfono Celular</div>
                                <div class="contact-value">{{ $demoRequest->telefono_celular }}</div>
                            </div>
                            <a href="tel:{{ $demoRequest->telefono_celular }}" class="contact-action">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Información de la Demo -->
                <div class="card">
                    <div class="card-header">
                        <h3 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-calendar-alt"></i>
                            Información de la Demo
                        </h3>
                    </div>
                    <div class="card-body">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                            <div class="field-group">
                                <div class="field-label">Tipo de Demo</div>
                                <div class="field-value">
                                    @if($demoRequest->tipo_demo == 'gimnasio')
                                        <span class="badge badge-primary">
                                            <i class="fas fa-dumbbell"></i>
                                            Gimnasio
                                        </span>
                                    @elseif($demoRequest->tipo_demo == 'nutricion')
                                        <span class="badge badge-success">
                                            <i class="fas fa-apple-alt"></i>
                                            Nutrición
                                        </span>
                                    @else
                                        <span class="badge badge-info">
                                            <i class="fas fa-star"></i>
                                            Ambos
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="field-group editable-field">
                                <div class="field-label">Fecha Preferida</div>
                                <div class="field-value editable" onclick="editField('fecha_preferida')">
                                    {{ $demoRequest->fecha_preferida ? \Carbon\Carbon::parse($demoRequest->fecha_preferida)->format('d/m/Y') : 'No especificada' }}
                                </div>
                                <div class="edit-overlay">
                                    <button class="edit-btn" onclick="editField('fecha_preferida')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="field-group editable-field">
                                <div class="field-label">Hora Preferida</div>
                                <div class="field-value editable" onclick="editField('hora_preferida')">
                                    {{ $demoRequest->hora_preferida ?? 'No especificada' }}
                                </div>
                                <div class="edit-overlay">
                                    <button class="edit-btn" onclick="editField('hora_preferida')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="field-group">
                                <div class="field-label">Número de Empleados</div>
                                <div class="field-value">
                                    {{ $demoRequest->numero_empleados ?? 'No especificado' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Necesidades y Comentarios -->
                @if($demoRequest->necesidades_especificas || $demoRequest->comentarios_adicionales)
                <div class="card">
                    <div class="card-header">
                        <h3 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-comments"></i>
                            Necesidades y Comentarios
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($demoRequest->necesidades_especificas)
                        <div class="field-group editable-field">
                            <div class="field-label">Necesidades Específicas</div>
                            <div class="field-value editable" onclick="editField('necesidades_especificas')" style="min-height: 4rem; align-items: flex-start;">
                                {{ $demoRequest->necesidades_especificas }}
                            </div>
                            <div class="edit-overlay">
                                <button class="edit-btn" onclick="editField('necesidades_especificas')">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        @endif
                        
                        @if($demoRequest->comentarios_adicionales)
                        <div class="field-group editable-field">
                            <div class="field-label">Comentarios Adicionales</div>
                            <div class="field-value editable" onclick="editField('comentarios_adicionales')" style="min-height: 4rem; align-items: flex-start;">
                                {{ $demoRequest->comentarios_adicionales }}
                            </div>
                            <div class="edit-overlay">
                                <button class="edit-btn" onclick="editField('comentarios_adicionales')">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Acciones Rápidas -->
                <div class="card">
                    <div class="card-header">
                        <h3 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-bolt"></i>
                            Acciones Rápidas
                        </h3>
                    </div>
                    <div class="card-body">
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <button class="btn btn-primary" onclick="contactClient()">
                                <i class="fas fa-phone"></i>
                                Contactar Cliente
                            </button>
                            
                            <button class="btn btn-success" onclick="scheduleDemo()">
                                <i class="fas fa-calendar-plus"></i>
                                Programar Demo
                            </button>
                            
                            <button class="btn btn-info" onclick="sendEmail()">
                                <i class="fas fa-envelope"></i>
                                Enviar Email
                            </button>
                            
                            <button class="btn btn-warning" onclick="openEditModal()">
                                <i class="fas fa-edit"></i>
                                Cambiar Estado
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Información del Sistema -->
                <div class="card">
                    <div class="card-header">
                        <h3 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-info-circle"></i>
                            Información del Sistema
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="field-group">
                            <div class="field-label">ID de Solicitud</div>
                            <div class="field-value">#{{ $demoRequest->id }}</div>
                        </div>
                        
                        <div class="field-group">
                            <div class="field-label">Fecha de Creación</div>
                            <div class="field-value">
                                {{ $demoRequest->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        
                        <div class="field-group">
                            <div class="field-label">Última Actualización</div>
                            <div class="field-value">
                                {{ $demoRequest->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        
                        <div class="field-group">
                            <div class="field-label">Tiempo Transcurrido</div>
                            <div class="field-value">
                                {{ $demoRequest->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline de Actividades -->
                <div class="card">
                    <div class="card-header">
                        <h3 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-history"></i>
                            Historial de Actividades
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <div class="timeline-title">Solicitud Creada</div>
                                        <div class="timeline-date">{{ $demoRequest->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <p style="margin: 0; color: var(--text-muted);">
                                        {{ $demoRequest->nombre }} envió una solicitud de demo.
                                    </p>
                                </div>
                            </div>
                            
                            @if($demoRequest->updated_at != $demoRequest->created_at)
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <div class="timeline-title">Última Actualización</div>
                                        <div class="timeline-date">{{ $demoRequest->updated_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <p style="margin: 0; color: var(--text-muted);">
                                        Estado actual: {{ ucfirst($demoRequest->estado) }}
                                    </p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para cambiar estado -->
    <div class="modal" id="statusModal">
        <div class="modal-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Cambiar Estado de Solicitud</h3>
                <button type="button" class="modal-close" onclick="closeModal('statusModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.demo-requests.update', $demoRequest->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nuevo Estado</label>
                        <select name="estado" class="form-control" required>
                            <option value="pendiente" {{ $demoRequest->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="contactado" {{ $demoRequest->estado == 'contactado' ? 'selected' : '' }}>Contactado</option>
                            <option value="programado" {{ $demoRequest->estado == 'programado' ? 'selected' : '' }}>Programado</option>
                            <option value="completado" {{ $demoRequest->estado == 'completado' ? 'selected' : '' }}>Completado</option>
                            <option value="cancelado" {{ $demoRequest->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notas (opcional)</label>
                        <textarea name="notas" class="form-control" rows="3" 
                                  placeholder="Agregar notas sobre el cambio de estado..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('statusModal')">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Actualizar Estado
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Función para abrir modal de estado
        function openEditModal() {
            document.getElementById('statusModal').classList.add('show');
        }

        // Función para cerrar modales
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }

        // Funciones de acciones rápidas
        function contactClient() {
            const phone = '{{ $demoRequest->telefono_celular ?? $demoRequest->telefono }}';
            if (phone) {
                window.open(`tel:${phone}`, '_self');
            } else {
                showNotification('warning', 'No hay número de teléfono disponible');
            }
        }

        function scheduleDemo() {
            showNotification('info', 'Función de programación en desarrollo');
        }

        function sendEmail() {
            const email = '{{ $demoRequest->email }}';
            const subject = encodeURIComponent('Solicitud de Demo - Power GYMA');
            const body = encodeURIComponent(`Hola {{ $demoRequest->nombre }},\n\nGracias por tu interés en Power GYMA.\n\nSaludos,\nEquipo Power GYMA`);
            window.open(`mailto:${email}?subject=${subject}&body=${body}`, '_self');
        }

        // Función para editar campos inline
        function editField(fieldName) {
            showNotification('info', 'Edición inline en desarrollo');
        }

        // Cerrar modales al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
            }
        });

        // Manejar tecla ESC para cerrar modales
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('.modal.show');
                modals.forEach(modal => modal.classList.remove('show'));
            }
        });

        // Mostrar notificaciones si hay mensajes
        @if(session('success'))
            showNotification('success', '{{ session('success') }}');
        @endif

        @if(session('error'))
            showNotification('error', '{{ session('error') }}');
        @endif

        // Función para mostrar notificaciones
        function showNotification(type, message) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
                ${message}
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        // Animaciones en carga
        document.addEventListener('DOMContentLoaded', function() {
            // Animación fade-in para las cards
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            document.querySelectorAll('.card, .status-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
</body>
</html>