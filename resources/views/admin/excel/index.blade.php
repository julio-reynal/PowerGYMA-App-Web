<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Archivos Excel - Power GYMA</title>
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
            --radius-lg: 16px;
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2rem;
            border-radius: var(--radius) var(--radius) 0 0;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header .subtitle {
            opacity: 0.9;
            font-size: 1.1rem;
            font-weight: 400;
        }

        .card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .card-header {
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, var(--bg), var(--border-light));
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-body {
            padding: 2rem;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.5rem;
            border: 1px solid;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .alert.success {
            background: var(--success-light);
            color: #065f46;
            border-color: #10b981;
        }

        .alert.warning {
            background: var(--warning-light);
            color: #92400e;
            border-color: #f59e0b;
        }

        .alert.danger {
            background: var(--danger-light);
            color: #991b1b;
            border-color: #ef4444;
        }

        .upload-area {
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            padding: 3rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            background: linear-gradient(135deg, var(--white), var(--bg));
            position: relative;
            overflow: hidden;
        }

        .upload-area:hover {
            border-color: var(--primary);
            background: var(--primary-light);
            transform: scale(1.01);
        }

        .upload-area.dragover {
            border-color: var(--success);
            background: var(--success-light);
            transform: scale(1.02);
        }

        .upload-icon {
            font-size: 4rem;
            color: var(--primary);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .upload-area:hover .upload-icon {
            transform: scale(1.1);
            color: var(--primary-dark);
        }

        .upload-text {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .upload-subtext {
            color: var(--text-muted);
            font-size: 1rem;
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
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            min-width: 120px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .progress-container {
            margin-top: 1.5rem;
            display: none;
        }

        .progress-bar {
            background: var(--border-light);
            border-radius: 50px;
            height: 8px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--success), #059669);
            width: 0%;
            transition: width 0.3s ease;
            border-radius: 50px;
        }

        .file-name {
            margin-top: 1rem;
            padding: 0.75rem 1rem;
            background: var(--success-light);
            color: #065f46;
            border-radius: var(--radius-sm);
            font-weight: 500;
            display: none;
        }

        .format-help {
            background: var(--info-light);
            border: 1px solid var(--info);
            border-radius: var(--radius-sm);
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .format-help h3 {
            color: #0c4a6e;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .format-help ul {
            list-style: none;
            color: #0c4a6e;
            font-size: 0.9rem;
        }

        .format-help li {
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 2rem;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--white);
            border-radius: var(--radius);
            padding: 2rem;
            max-width: 800px;
            width: 100%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            margin: 1rem;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text);
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
            padding: 0.5rem;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
        }

        .close-btn:hover {
            background: var(--danger-light);
            color: var(--danger);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .header {
                padding: 1.5rem;
            }
            
            .header h1 {
                font-size: 1.5rem;
            }
            
            .header > div {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start !important;
            }
            
            .card-body {
                padding: 1.5rem;
            }
            
            .upload-area {
                padding: 2rem 1rem;
            }

            .table-container {
                font-size: 0.8rem;
            }

            .data-table th,
            .data-table td {
                padding: 0.5rem;
            }

            .file-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .file-icon {
                width: 30px;
                height: 30px;
            }

            .actions-group {
                flex-direction: column;
                gap: 0.25rem;
            }

            .action-btn {
                width: 30px;
                height: 30px;
            }

            .pagination {
                flex-wrap: wrap;
                gap: 0.25rem;
            }

            .pagination a,
            .pagination span {
                min-width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
        }

        /* Estilos para la tabla */
        .table-container {
            overflow-x: auto;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            -webkit-overflow-scrolling: touch; /* Scroll suave en iOS */
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            background: var(--white);
            min-width: 800px; /* Asegurar ancho mínimo */
        }

        .data-table thead {
            background: var(--bg);
        }

        .data-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border);
        }

        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-light);
            transition: background 0.2s ease;
        }

        .data-table tbody tr:hover {
            background: var(--border-light);
        }

        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-completed {
            background: var(--success-light);
            color: #065f46;
        }

        .status-failed {
            background: var(--danger-light);
            color: #991b1b;
        }

        .status-processing {
            background: var(--warning-light);
            color: #92400e;
        }

        .status-pending {
            background: var(--text-light);
            color: var(--text);
        }

        .action-btn {
            padding: 0.5rem;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .action-view {
            background: var(--info-light);
            color: #0c4a6e;
        }

        .action-retry {
            background: var(--warning-light);
            color: #92400e;
        }

        .action-delete {
            background: var(--danger-light);
            color: #991b1b;
        }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
            color: var(--text-muted);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .empty-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .file-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .file-icon {
            width: 40px;
            height: 40px;
            background: var(--success-light);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .file-details .name {
            font-weight: 500;
            color: var(--text);
        }

        .file-details .size {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .stats-number {
            font-weight: 600;
            color: var(--primary);
            font-size: 1.1rem;
        }

        .stats-label {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .actions-group {
            display: flex;
            gap: 0.5rem;
        }

        .pagination-container {
            padding: 1.5rem;
            border-top: 1px solid var(--border);
            background: var(--border-light);
            display: flex;
            justify-content: center;
        }

        /* Estilos para paginación de Laravel */
        .pagination {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0.5rem;
        }

        .pagination li {
            display: flex;
        }

        .pagination a,
        .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0.5rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: var(--text);
            background: var(--white);
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .pagination a:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        .pagination .active span {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination .disabled span {
            color: var(--text-muted);
            background: var(--border-light);
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                <div>
                    <h1>
                        <i class="fas fa-file-excel"></i>
                        Gestión de Archivos Excel
                    </h1>
                    <p class="subtitle">Carga y procesa archivos de evaluación de riesgos en formato Excel/CSV</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" 
                   style="background: rgba(255,255,255,0.2); color: white; padding: 0.75rem 1.5rem; border-radius: var(--radius-sm); text-decoration: none; display: flex; align-items: center; gap: 0.5rem; font-weight: 500; transition: all 0.2s ease; border: 1px solid rgba(255,255,255,0.3);"
                   onmouseover="this.style.background='rgba(255,255,255,0.3)'"
                   onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                    <i class="fas fa-arrow-left"></i>
                    Volver al Dashboard
                </a>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert danger">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert warning">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('warning') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert danger">
                <i class="fas fa-times-circle"></i>
                <div>
                    <strong>Error de validación:</strong>
                    <ul style="margin-left: 1rem; margin-top: 0.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Upload Card -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-cloud-upload-alt"></i>
                    Subir Nuevo Archivo
                </h2>
                <button type="button" onclick="showFormatModal()" class="btn btn-outline">
                    <i class="fas fa-info-circle"></i>
                    Ver Formato
                </button>
            </div>
            <div class="card-body">
                <!-- Información del formato esperado -->
                <div class="format-help">
                    <h3>
                        <i class="fas fa-lightbulb"></i>
                        Formato Requerido
                    </h3>
                    <ul>
                        <li><i class="fas fa-check"></i> Archivos: CSV únicamente</li>
                        <li><i class="fas fa-check"></i> Formato de fecha: DD-MMM (ej: 25-ago)</li>
                        <li><i class="fas fa-check"></i> Niveles: Muy Bajo, Bajo, Moderado, Alto, Crítico, No procede</li>
                        <li><i class="fas fa-check"></i> Horarios: formato 24h (ej: 19:00)</li>
                    </ul>
                </div>

                <form id="uploadForm" action="{{ route('admin.excel.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Selector de año -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="csv_year" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--text);">
                            <i class="fas fa-calendar-alt"></i> Año de los datos:
                        </label>
                        <select name="csv_year" id="csv_year" required 
                                style="width: 100%; padding: 0.75rem; border: 2px solid var(--border); border-radius: var(--radius-sm); font-size: 1rem; background: var(--white);">
                            @for ($year = 2020; $year <= 2030; $year++)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="upload-area" id="uploadArea">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="upload-text">Arrastra tu archivo aquí</div>
                        <div class="upload-subtext">o haz click para seleccionar</div>
                        <input type="file" 
                               id="fileInput" 
                               name="excel_file" 
                               accept=".csv" 
                               required 
                               style="position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer;">
                    </div>

                    <div id="fileName" class="file-name"></div>

                    <div id="progressContainer" class="progress-container">
                        <div class="progress-bar">
                            <div id="progressBar" class="progress-fill"></div>
                        </div>
                        <div style="text-align: center; font-size: 0.9rem; color: var(--text-muted);">
                            Procesando archivo...
                        </div>
                    </div>

                    <div style="margin-top: 2rem; text-align: center;">
                        <button type="submit" id="submitBtn" class="btn btn-primary" disabled>
                            <i class="fas fa-upload"></i>
                            Procesar Archivo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de archivos procesados -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-history"></i>
                    Archivos Procesados
                </h2>
                <span style="background: var(--info-light); color: #0c4a6e; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.85rem; font-weight: 500;">
                    <i class="fas fa-database"></i>
                    {{ $uploads->total() }} archivos
                </span>
            </div>
            
            @if($uploads->count() > 0)
                <!-- Indicador de scroll en móviles -->
                <div style="display: none; padding: 0.5rem 1rem; background: var(--info-light); color: #0c4a6e; font-size: 0.8rem; text-align: center;" id="scrollIndicator">
                    <i class="fas fa-arrows-alt-h"></i> Desliza horizontalmente para ver más información
                </div>
                
                <div class="table-container" id="tableContainer">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>
                                    <i class="fas fa-file-alt"></i> Archivo
                                </th>
                                <th>
                                    <i class="fas fa-user-shield"></i> Administrador
                                </th>
                                <th>
                                    <i class="fas fa-traffic-light"></i> Estado
                                </th>
                                <th>
                                    <i class="fas fa-chart-bar"></i> Registros
                                </th>
                                <th>
                                    <i class="fas fa-calendar-plus"></i> Procesado
                                </th>
                                <th>
                                    <i class="fas fa-cog"></i> Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($uploads as $upload)
                                <tr>
                                    <td>
                                        <div class="file-info">
                                            <div class="file-icon">
                                                <i class="fas fa-file-csv" style="color: var(--success); font-size: 1.2rem;"></i>
                                            </div>
                                            <div class="file-details">
                                                <div class="name">{{ $upload->original_filename }}</div>
                                                <div class="size">{{ number_format($upload->file_size / 1024, 1) }} KB</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <div class="user-avatar">
                                                {{ strtoupper(substr($upload->adminUser->name ?? 'A', 0, 2)) }}
                                            </div>
                                            <span style="font-weight: 500;">{{ $upload->adminUser->name ?? 'Admin' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @switch($upload->status)
                                            @case('completed')
                                                <span class="status-badge status-completed">
                                                    <i class="fas fa-check-circle"></i> Completado
                                                </span>
                                                @break
                                            @case('failed')
                                                <span class="status-badge status-failed">
                                                    <i class="fas fa-times-circle"></i> Error
                                                </span>
                                                @break
                                            @case('processing')
                                                <span class="status-badge status-processing">
                                                    <i class="fas fa-spinner fa-spin"></i> Procesando
                                                </span>
                                                @break
                                            @default
                                                <span class="status-badge status-pending">
                                                    <i class="fas fa-clock"></i> Pendiente
                                                </span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="stats-number">
                                            {{ number_format($upload->records_processed) }}
                                        </div>
                                        <div class="stats-label">registros</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 500;">{{ $upload->created_at->format('d/m/Y') }}</div>
                                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $upload->created_at->format('H:i') }}</div>
                                    </td>
                                    <td>
                                        <div class="actions-group">
                                            <a href="{{ route('admin.excel.show', $upload->id) }}" 
                                               class="action-btn action-view"
                                               title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($upload->status === 'failed')
                                                <form action="{{ route('admin.excel.reprocess', $upload->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="action-btn action-retry"
                                                            title="Reprocesar archivo">
                                                        <i class="fas fa-redo"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.excel.destroy', $upload->id) }}" method="POST" style="display: inline;" 
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este registro?\n\nEsta acción no se puede deshacer.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="action-btn action-delete"
                                                        title="Eliminar registro">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if($uploads->hasPages())
                    <div class="pagination-container">
                        {{ $uploads->links('vendor.pagination.custom') }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <div class="empty-title">No hay archivos procesados aún</div>
                    <div>¡Sube tu primer archivo Excel para comenzar!</div>
                </div>
            @endif
        </div>

        <!-- Botón de navegación inferior -->
        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('admin.dashboard') }}" 
               class="btn btn-outline"
               style="min-width: auto;">
                <i class="fas fa-arrow-left"></i>
                Volver al Dashboard de Administración
            </a>
        </div>
    </div>

    <!-- Modal de formato detallado -->
    <div id="formatModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">📊 Formato Detallado del Archivo Excel</h3>
                <button onclick="closeFormatModal()" class="close-btn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div style="max-height: 400px; overflow-y: auto;">
                <div style="space-y: 1.5rem;">
                    <!-- Sección 1: Revisión Diaria -->
                    <div style="margin-bottom: 1.5rem;">
                        <h4 style="color: var(--primary); font-weight: 600; margin-bottom: 0.75rem;">
                            🎯 SECCIÓN 1: Revisión de Riesgo Diario
                        </h4>
                        <div style="background: var(--bg); padding: 1rem; border-radius: var(--radius-sm);">
                            <p style="font-weight: 500; margin-bottom: 0.5rem;">Formato requerido:</p>
                            <pre style="background: var(--white); padding: 0.75rem; border-radius: var(--radius-sm); border: 1px solid var(--border); font-size: 0.9rem;">FECHA: 25-ago
RIESGO: Alto
HORA INICIO: 19:00
HORA FIN: 20:00</pre>
                        </div>
                    </div>

                    <!-- Sección 2: Revisión Mensual -->
                    <div style="margin-bottom: 1.5rem;">
                        <h4 style="color: var(--primary); font-weight: 600; margin-bottom: 0.75rem;">
                            📅 SECCIÓN 2: Revisión de Riesgo Mensual
                        </h4>
                        <div style="background: var(--bg); padding: 1rem; border-radius: var(--radius-sm);">
                            <p style="font-weight: 500; margin-bottom: 0.5rem;">Formato de tabla:</p>
                            <pre style="background: var(--white); padding: 0.75rem; border-radius: var(--radius-sm); border: 1px solid var(--border); font-size: 0.9rem;">1-ago    Bajo
2-ago    Alto
3-ago    Moderado
4-ago    Bajo
5-ago    No procede
...
31-ago   Alto</pre>
                        </div>
                    </div>

                    <!-- Niveles válidos -->
                    <div style="margin-bottom: 1.5rem;">
                        <h4 style="color: var(--primary); font-weight: 600; margin-bottom: 0.75rem;">
                            ✅ Niveles de Riesgo Válidos
                        </h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div style="space-y: 0.5rem;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="width: 12px; height: 12px; background: var(--success); border-radius: 50%;"></span>
                                    <code>Muy Bajo</code>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="width: 12px; height: 12px; background: var(--success); border-radius: 50%;"></span>
                                    <code>Bajo</code>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="width: 12px; height: 12px; background: var(--warning); border-radius: 50%;"></span>
                                    <code>Moderado</code>
                                </div>
                            </div>
                            <div style="space-y: 0.5rem;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="width: 12px; height: 12px; background: #ff6b35; border-radius: 50%;"></span>
                                    <code>Alto</code>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="width: 12px; height: 12px; background: var(--danger); border-radius: 50%;"></span>
                                    <code>Crítico</code>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="width: 12px; height: 12px; background: var(--text-muted); border-radius: 50%;"></span>
                                    <code>No procede</code>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Errores comunes -->
                    <div>
                        <h4 style="color: var(--danger); font-weight: 600; margin-bottom: 0.75rem;">
                            ⚠️ Errores Comunes a Evitar
                        </h4>
                        <div style="background: var(--danger-light); padding: 1rem; border-radius: var(--radius-sm);">
                            <ul style="list-style: none; font-size: 0.9rem; color: #991b1b;">
                                <li style="margin-bottom: 0.25rem;">❌ <code>25/08/2025</code> → ✅ <code>25-ago</code></li>
                                <li style="margin-bottom: 0.25rem;">❌ <code>Medio</code> → ✅ <code>Moderado</code></li>
                                <li style="margin-bottom: 0.25rem;">❌ <code>19:00:00</code> → ✅ <code>19:00</code></li>
                                <li style="margin-bottom: 0.25rem;">❌ <code>N/A</code> → ✅ <code>No procede</code></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                <button onclick="closeFormatModal()" class="btn btn-primary">
                    <i class="fas fa-check"></i>
                    Entendido
                </button>
            </div>
        </div>
    </div>

    <script>
        // Drag and drop functionality
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const progressContainer = document.getElementById('progressContainer');
        const progressBar = document.getElementById('progressBar');
        const submitBtn = document.getElementById('submitBtn');
        const fileName = document.getElementById('fileName');

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        uploadArea.addEventListener('drop', handleDrop, false);

        // Handle file selection
        fileInput.addEventListener('change', handleFileSelect, false);

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            uploadArea.classList.add('dragover');
        }

        function unhighlight(e) {
            uploadArea.classList.remove('dragover');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        function handleFileSelect(e) {
            const files = e.target.files;
            handleFiles(files);
        }

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                
                // Validate file type
                const validTypes = ['.csv'];
                const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
                
                if (!validTypes.includes(fileExtension)) {
                    alert('Por favor, selecciona un archivo CSV válido.');
                    return;
                }
                
                // Show file name
                fileName.innerHTML = `<i class="fas fa-file-csv"></i> ${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
                fileName.style.display = 'block';
                
                // Update upload area appearance
                uploadArea.style.borderColor = 'var(--success)';
                uploadArea.style.background = 'var(--success-light)';
                
                // Update submit button
                submitBtn.innerHTML = '<i class="fas fa-check"></i> Archivo Listo - Procesar';
                submitBtn.style.background = 'linear-gradient(135deg, var(--success), #059669)';
                submitBtn.disabled = false;
            }
        }

        // Form submission with progress simulation
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Por favor, selecciona un archivo antes de continuar.');
                return;
            }
            
            // Show progress
            progressContainer.style.display = 'block';
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
            
            // Simulate progress
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress > 90) progress = 90;
                
                progressBar.style.width = progress + '%';
                
                if (progress >= 90) {
                    clearInterval(interval);
                }
            }, 200);
        });

        // Modal functions
        function showFormatModal() {
            document.getElementById('formatModal').classList.add('active');
        }

        function closeFormatModal() {
            document.getElementById('formatModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('formatModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeFormatModal();
            }
        });

        // Auto-hide alerts after 8 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                }, 8000);
            });

            // Mostrar indicador de scroll en móviles
            const tableContainer = document.getElementById('tableContainer');
            const scrollIndicator = document.getElementById('scrollIndicator');
            
            if (tableContainer && scrollIndicator) {
                function checkScrollNeed() {
                    if (window.innerWidth <= 768 && tableContainer.scrollWidth > tableContainer.clientWidth) {
                        scrollIndicator.style.display = 'block';
                    } else {
                        scrollIndicator.style.display = 'none';
                    }
                }
                
                checkScrollNeed();
                window.addEventListener('resize', checkScrollNeed);
                
                // Ocultar indicador después de hacer scroll
                tableContainer.addEventListener('scroll', function() {
                    if (this.scrollLeft > 10) {
                        scrollIndicator.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>
</html>
