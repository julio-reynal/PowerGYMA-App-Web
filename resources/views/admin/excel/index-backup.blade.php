@extends('layouts.admin-common')

@section('title', 'Gestión de Excel')
@section('page-title', 'Gestión de Excel')

@section('additional-styles')
<style>
    /* Estilos mejorados para gestión de excel */
    .upload-section {
        background: var(--card);
        border-radius: var(--radius);
        padding: 2rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        margin-bottom: 2rem;
    }

    .upload-zone {
        border: 3px dashed var(--border);
        border-radius: var(--radius);
        padding: 3rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        background: var(--bg-secondary);
        overflow: hidden;
    }

    .upload-zone::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.6s;
    }

    .upload-zone:hover::before {
        left: 100%;
    }

    .upload-zone:hover {
        border-color: var(--primary);
        background: var(--primary-light);
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .upload-zone.dragover {
        border-color: var(--success);
        background: var(--success-light);
        transform: scale(1.02);
    }

    .upload-zone.uploading {
        border-color: var(--warning);
        background: var(--warning-light);
        pointer-events: none;
    }

    .upload-icon {
        font-size: 4rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .upload-zone:hover .upload-icon {
        color: var(--primary);
        transform: scale(1.1);
    }

    .upload-progress {
        display: none;
        margin-top: 1rem;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: var(--border);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--info));
        border-radius: 4px;
        width: 0%;
        transition: width 0.3s ease;
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200px 0; }
        100% { background-position: 200px 0; }
    }

    .loading-spinner {
        display: none;
        width: 2rem;
        height: 2rem;
        border: 3px solid var(--border);
        border-top: 3px solid var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 1rem auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .files-table {
        background: var(--card);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        overflow: hidden;
        margin-top: 2rem;
    }

    .table-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, var(--primary-light), var(--info-light));
    }

    .table-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .files-stats {
        display: flex;
        gap: 1rem;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .file-row {
        border-top: 1px solid var(--border);
        transition: all 0.3s ease;
        animation: slideInUp 0.4s ease-out;
    }

    .file-row:hover {
        background: var(--border-light);
        transform: translateX(4px);
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .file-icon-wrapper {
        background: var(--success-light);
        color: var(--success);
        padding: 0.75rem;
        border-radius: 50%;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .file-row:hover .file-icon-wrapper {
        transform: scale(1.1);
    }

    .file-details {
        flex: 1;
    }

    .file-name {
        font-weight: 600;
        color: var(--text);
        margin-bottom: 0.25rem;
    }

    .file-meta {
        color: var(--text-muted);
        font-size: 0.85rem;
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        letter-spacing: 0.05em;
        box-shadow: var(--shadow);
    }

    .status-processing {
        background: linear-gradient(135deg, var(--warning), #d97706);
        color: white;
        animation: pulse 2s infinite;
    }

    .status-completed {
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
    }

    .status-failed {
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: white;
    }

    .status-pending {
        background: linear-gradient(135deg, var(--info), #0891b2);
        color: white;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        padding: 0.5rem;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .btn-view { background: var(--info); color: white; }
    .btn-retry { background: var(--warning); color: white; }
    .btn-delete { background: var(--danger); color: white; }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-muted);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .records-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
    }

    .records-count {
        font-weight: 600;
        color: var(--text);
    }

    .records-total {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .processing-indicator {
        display: inline-block;
        width: 0.5rem;
        height: 0.5rem;
        background: var(--warning);
        border-radius: 50%;
        animation: blink 1.5s infinite;
        margin-left: 0.5rem;
    }

    @keyframes blink {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0.3; }
    }

    .upload-tips {
        background: var(--info-light);
        border: 1px solid var(--info);
        border-radius: var(--radius-sm);
        padding: 1rem;
        margin-top: 1rem;
        color: var(--text);
    }

    .upload-tips h4 {
        margin: 0 0 0.5rem 0;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .upload-tips ul {
        margin: 0;
        padding-left: 1.5rem;
        font-size: 0.85rem;
    }

    @media (max-width: 768px) {
        .upload-zone {
            padding: 2rem 1rem;
        }

        .files-stats {
            flex-direction: column;
            gap: 0.5rem;
        }

        .file-meta {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div style="margin-bottom: 2rem;">
        <nav style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">
            <a href="{{ route('admin.dashboard') }}" style="color: var(--primary); text-decoration: none;">Dashboard</a>
            <i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i>
            <span>Gestión de Excel</span>
        </nav>
    </div>

    <!-- Header mejorado -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--text); margin: 0; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-file-excel" style="color: var(--success);"></i>
                Gestión de Excel
            </h2>
            <p style="color: var(--text-muted); margin: 0.5rem 0 0 0;">Carga y procesa archivos Excel/CSV de datos de riesgo empresarial</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <button class="btn btn-info" onclick="downloadTemplate()">
                <i class="fas fa-download"></i>Descargar Plantilla
            </button>
            <button class="btn" style="background: var(--border); color: var(--text);" onclick="refreshPage()">
                <i class="fas fa-sync"></i>Actualizar
            </button>
        </div>
    </div>

    <!-- Upload Section mejorada -->
    <div class="upload-section">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h3 style="color: var(--text); margin-bottom: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                <i class="fas fa-cloud-upload-alt" style="color: var(--primary);"></i>
                Subir Archivo Excel/CSV
            </h3>
            <p style="color: var(--text-muted); margin: 0;">Soporta archivos CSV con datos de riesgo. Máximo 10MB.</p>
        </div>

        <form id="upload-form" action="{{ route('admin.excel.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="upload-zone" class="upload-zone" onclick="document.getElementById('excel-file').click()">
                <div class="upload-icon">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <h4 id="upload-text" style="color: var(--text); margin-bottom: 0.5rem; font-weight: 600;">
                    Arrastra tu archivo aquí o haz clic para seleccionar
                </h4>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 0.9rem;">
                    Formatos: .csv, .txt • Tamaño máximo: 10MB
                </p>
                
                <input type="file" id="excel-file" name="excel_file" accept=".csv,.txt" style="display: none;" required>
                <input type="hidden" name="csv_year" value="{{ date('Y') }}">
                
                <div style="display: flex; gap: 1rem; justify-content: center; align-items: center;">
                    <button type="submit" id="upload-btn" class="btn btn-primary">
                        <i class="fas fa-upload"></i>Subir Archivo
                    </button>
                    <span style="color: var(--text-muted); font-size: 0.85rem;">
                        Año: {{ date('Y') }}
                    </span>
                </div>

                <!-- Indicadores de progreso -->
                <div class="upload-progress" id="upload-progress">
                    <div style="margin-bottom: 0.5rem; color: var(--text); font-weight: 600;">
                        <span id="progress-text">Subiendo archivo...</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" id="progress-fill"></div>
                    </div>
                    <div style="margin-top: 0.5rem; font-size: 0.85rem; color: var(--text-muted);">
                        <span id="progress-details">Preparando...</span>
                    </div>
                </div>

                <div class="loading-spinner" id="loading-spinner"></div>
            </div>
        </form>

        <!-- Tips de uso -->
        <div class="upload-tips">
            <h4><i class="fas fa-info-circle"></i> Consejos para una carga exitosa:</h4>
            <ul>
                <li>Usa la plantilla CSV proporcionada para garantizar el formato correcto</li>
                <li>Asegúrate de que las fechas estén en formato YYYY-MM-DD</li>
                <li>Los valores de riesgo deben estar entre 0 y 1</li>
                <li>Verifica que no haya celdas vacías en campos obligatorios</li>
            </ul>
        </div>
    </div>

    <!-- Tabla de archivos mejorada -->
    <div class="files-table">
        <div class="table-header">
            <h3 class="table-title">
                <i class="fas fa-table"></i>
                Archivos Subidos
            </h3>
            <div class="files-stats">
                <div class="stat-item">
                    <i class="fas fa-file"></i>
                    <span>{{ $uploads->total() ?? 0 }} total</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ $uploads->where('status', 'completed')->count() ?? 0 }} completados</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ $uploads->where('status', 'failed')->count() ?? 0 }} errores</span>
                </div>
            </div>
        </div>

        <div style="overflow-x: auto;">
            @if($uploads && $uploads->count() > 0)
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-secondary);">
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text); border-bottom: 2px solid var(--border);">
                            <i class="fas fa-file"></i> Archivo
                        </th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text); border-bottom: 2px solid var(--border);">
                            <i class="fas fa-flag"></i> Estado
                        </th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--text); border-bottom: 2px solid var(--border);">
                            <i class="fas fa-chart-bar"></i> Registros
                        </th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text); border-bottom: 2px solid var(--border);">
                            <i class="fas fa-clock"></i> Fecha
                        </th>
                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--text); border-bottom: 2px solid var(--border);">
                            <i class="fas fa-cogs"></i> Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($uploads as $upload)
                        <tr class="file-row">
                            <td style="padding: 1.25rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div class="file-icon-wrapper">
                                        <i class="fas fa-file-csv"></i>
                                    </div>
                                    <div class="file-details">
                                        <div class="file-name">{{ $upload->original_filename ?? $upload->filename }}</div>
                                        <div class="file-meta">
                                            <span><i class="fas fa-weight"></i> {{ number_format($upload->file_size / 1024, 1) }} KB</span>
                                            <span><i class="fas fa-user"></i> {{ $upload->adminUser->name ?? 'Sistema' }}</span>
                                            @if($upload->processing_summary && isset($upload->processing_summary['csv_year']))
                                                <span><i class="fas fa-calendar"></i> Año {{ $upload->processing_summary['csv_year'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1.25rem;">
                                @php
                                    $statusClass = match($upload->status) {
                                        'completed' => 'status-completed',
                                        'failed' => 'status-failed', 
                                        'processing' => 'status-processing',
                                        default => 'status-pending'
                                    };
                                    $statusIcon = match($upload->status) {
                                        'completed' => 'fas fa-check-circle',
                                        'failed' => 'fas fa-times-circle',
                                        'processing' => 'fas fa-spinner fa-spin',
                                        default => 'fas fa-clock'
                                    };
                                    $statusText = match($upload->status) {
                                        'completed' => 'Completado',
                                        'failed' => 'Error',
                                        'processing' => 'Procesando',
                                        default => 'Pendiente'
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    <i class="{{ $statusIcon }}"></i>
                                    {{ $statusText }}
                                    @if($upload->status === 'processing')
                                        <span class="processing-indicator"></span>
                                    @endif
                                </span>
                            </td>
                            <td style="padding: 1.25rem; text-align: center;">
                                <div class="records-info">
                                    <span class="records-count">{{ number_format($upload->records_processed ?? 0) }}</span>
                                    @if($upload->processing_summary && isset($upload->processing_summary['total_rows']))
                                        <span class="records-total">de {{ number_format($upload->processing_summary['total_rows']) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 1.25rem; color: var(--text);">
                                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                    <span style="font-weight: 600;">{{ $upload->created_at->format('d/m/Y') }}</span>
                                    <span style="font-size: 0.85rem; color: var(--text-muted);">{{ $upload->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td style="padding: 1.25rem;">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.excel.show', $upload) }}" class="btn-action btn-view" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($upload->status === 'failed')
                                        <form method="POST" action="{{ route('admin.excel.reprocess', $upload) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-action btn-retry" title="Reprocesar">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.excel.destroy', $upload) }}" style="display: inline;" 
                                          onsubmit="return confirm('¿Estás seguro de que deseas eliminar este archivo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-file-excel"></i>
                </div>
                <h3 style="margin-bottom: 0.5rem; color: var(--text);">No hay archivos subidos</h3>
                <p style="margin-bottom: 1.5rem;">Sube tu primer archivo Excel/CSV para comenzar a gestionar los datos de riesgo</p>
                <button class="btn btn-primary" onclick="document.getElementById('excel-file').click()">
                    <i class="fas fa-plus"></i>Subir Primer Archivo
                </button>
            </div>
            @endif
        </div>

        @if($uploads && $uploads->hasPages())
        <div style="padding: 1.5rem; border-top: 1px solid var(--border); background: var(--bg-secondary);">
            {{ $uploads->links() }}
        </div>
        @endif
    </div>
@endsection

@section('additional-scripts')
<script>
    // Variables globales
    const uploadZone = document.getElementById('upload-zone');
    const fileInput = document.getElementById('excel-file');
    const uploadForm = document.getElementById('upload-form');
    const uploadBtn = document.getElementById('upload-btn');
    const uploadText = document.getElementById('upload-text');
    const uploadProgress = document.getElementById('upload-progress');
    const progressFill = document.getElementById('progress-fill');
    const progressText = document.getElementById('progress-text');
    const progressDetails = document.getElementById('progress-details');
    const loadingSpinner = document.getElementById('loading-spinner');

    // Drag and drop functionality mejorado
    let dragCounter = 0;

    uploadZone.addEventListener('dragenter', function(e) {
        e.preventDefault();
        dragCounter++;
        this.classList.add('dragover');
    });

    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
    });

    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dragCounter--;
        if (dragCounter === 0) {
            this.classList.remove('dragover');
        }
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dragCounter = 0;
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            
            // Validar tipo de archivo
            if (!file.name.toLowerCase().endsWith('.csv') && !file.name.toLowerCase().endsWith('.txt')) {
                showNotification('Error: Solo se permiten archivos CSV (.csv) o TXT (.txt)', 'error');
                return;
            }
            
            // Validar tamaño (10MB = 10485760 bytes)
            if (file.size > 10485760) {
                showNotification('Error: El archivo es demasiado grande. Máximo 10MB permitido.', 'error');
                return;
            }
            
            fileInput.files = files;
            updateUploadUI(file);
            
            // Auto submit después de un breve delay para mostrar la UI
            setTimeout(() => {
                submitUploadForm();
            }, 500);
        }
    });

    // Manejar selección de archivos
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            const file = this.files[0];
            updateUploadUI(file);
        }
    });

    // Actualizar UI cuando se selecciona un archivo
    function updateUploadUI(file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024).toFixed(1) + ' KB';
        
        uploadText.innerHTML = `
            <i class="fas fa-file-csv" style="color: var(--success); margin-right: 0.5rem;"></i>
            Archivo seleccionado: <strong>${fileName}</strong>
        `;
        
        // Mostrar información del archivo
        const uploadIcon = uploadZone.querySelector('.upload-icon i');
        uploadIcon.className = 'fas fa-file-check';
        uploadIcon.style.color = 'var(--success)';
        
        // Agregar detalles del archivo
        const existingDetails = uploadZone.querySelector('.file-details');
        if (existingDetails) {
            existingDetails.remove();
        }
        
        const fileDetails = document.createElement('div');
        fileDetails.className = 'file-details';
        fileDetails.style.cssText = `
            margin-top: 1rem;
            padding: 1rem;
            background: var(--success-light);
            border-radius: var(--radius-sm);
            color: var(--success);
            font-size: 0.9rem;
        `;
        fileDetails.innerHTML = `
            <div style="display: flex; justify-content: center; gap: 2rem;">
                <span><i class="fas fa-weight"></i> Tamaño: ${fileSize}</span>
                <span><i class="fas fa-file-alt"></i> Tipo: ${file.type || 'text/csv'}</span>
                <span><i class="fas fa-calendar"></i> Año: {{ date('Y') }}</span>
            </div>
        `;
        
        uploadZone.appendChild(fileDetails);
    }

    // Manejar envío del formulario con animaciones
    uploadForm.addEventListener('submit', function(e) {
        e.preventDefault();
        submitUploadForm();
    });

    function submitUploadForm() {
        if (!fileInput.files.length) {
            showNotification('Por favor selecciona un archivo', 'warning');
            return;
        }

        // Mostrar estado de carga
        uploadZone.classList.add('uploading');
        uploadBtn.disabled = true;
        uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>Subiendo...';
        
        // Mostrar progreso
        uploadProgress.style.display = 'block';
        loadingSpinner.style.display = 'block';
        
        // Simular progreso de carga
        let progress = 0;
        const progressInterval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 90) {
                progress = 90;
                clearInterval(progressInterval);
                progressText.textContent = 'Procesando archivo...';
                progressDetails.textContent = 'Validando datos y estructura...';
            }
            
            progressFill.style.width = progress + '%';
            
            if (progress < 30) {
                progressDetails.textContent = 'Subiendo archivo al servidor...';
            } else if (progress < 60) {
                progressDetails.textContent = 'Validando formato y estructura...';
            } else if (progress < 90) {
                progressDetails.textContent = 'Preparando para procesamiento...';
            }
        }, 200);

        // Enviar formulario usando fetch para mejor control
        const formData = new FormData(uploadForm);
        
        fetch(uploadForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token')
            }
        })
        .then(response => {
            clearInterval(progressInterval);
            progressFill.style.width = '100%';
            progressText.textContent = 'Completado';
            progressDetails.textContent = 'Redirigiendo...';
            
            if (response.ok) {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                throw new Error('Error en la respuesta del servidor');
            }
        })
        .catch(error => {
            clearInterval(progressInterval);
            resetUploadUI();
            showNotification('Error al subir el archivo: ' + error.message, 'error');
        });
    }

    // Resetear UI de upload
    function resetUploadUI() {
        uploadZone.classList.remove('uploading', 'dragover');
        uploadBtn.disabled = false;
        uploadBtn.innerHTML = '<i class="fas fa-upload"></i>Subir Archivo';
        uploadProgress.style.display = 'none';
        loadingSpinner.style.display = 'none';
        progressFill.style.width = '0%';
        
        uploadText.textContent = 'Arrastra tu archivo aquí o haz clic para seleccionar';
        
        const uploadIcon = uploadZone.querySelector('.upload-icon i');
        uploadIcon.className = 'fas fa-cloud-upload-alt';
        uploadIcon.style.color = 'var(--text-muted)';
        
        const fileDetails = uploadZone.querySelector('.file-details');
        if (fileDetails) {
            fileDetails.remove();
        }
        
        fileInput.value = '';
    }

    // Sistema de notificaciones
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            color: white;
            font-weight: 600;
            z-index: 1000;
            animation: slideInRight 0.3s ease-out;
            max-width: 400px;
            box-shadow: var(--shadow-lg);
        `;
        
        const colors = {
            success: 'var(--success)',
            error: 'var(--danger)',
            warning: 'var(--warning)',
            info: 'var(--info)'
        };
        
        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-times-circle',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };
        
        notification.style.background = colors[type] || colors.info;
        notification.innerHTML = `
            <i class="${icons[type] || icons.info}" style="margin-right: 0.5rem;"></i>
            ${message}
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease-in forwards';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 5000);
    }

    // Función para actualizar página
    function refreshPage() {
        window.location.reload();
    }

    // Función para descargar plantilla Excel mejorada
    function downloadTemplate() {
        // Crear una plantilla CSV con estructura completa y mejores ejemplos
        const headers = [
            'fecha',
            'empresa_id',
            'riesgo_operacional',
            'riesgo_financiero', 
            'riesgo_estrategico',
            'riesgo_cumplimiento',
            'energia_consumida',
            'energia_generada',
            'observaciones'
        ];
        
        const exampleData = [
            '2024-01-15,1,0.3,0.2,0.1,0.1,1250,950,Evaluación mensual enero - Riesgo bajo',
            '2024-02-15,1,0.4,0.3,0.2,0.15,1380,1100,Evaluación mensual febrero - Incremento operacional',
            '2024-03-15,1,0.25,0.15,0.1,0.08,1150,890,Evaluación mensual marzo - Mejora significativa',
            '2024-04-15,1,0.35,0.25,0.18,0.12,1420,1200,Evaluación mensual abril - Situación estable',
            '2024-05-15,1,0.45,0.35,0.25,0.18,1580,1350,Evaluación mensual mayo - Revisión de procesos'
        ];
        
        const csvContent = `# Plantilla de Datos de Riesgo - Power GYMA
# Instrucciones:
# - fecha: Formato YYYY-MM-DD
# - empresa_id: ID numérico de la empresa (usar 1 para datos demo)
# - riesgo_*: Valores entre 0.0 y 1.0 (0 = sin riesgo, 1 = riesgo máximo)
# - energia_*: Valores en kWh (números enteros)
# - observaciones: Texto descriptivo (opcional)
#
${headers.join(',')}
${exampleData.join('\n')}`;
        
        // Crear y descargar archivo
        const blob = new Blob(['\uFEFF' + csvContent], { 
            type: 'text/csv;charset=utf-8;' 
        });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `PowerGYMA_Plantilla_Riesgo_${new Date().toISOString().split('T')[0]}.csv`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        showNotification('Plantilla descargada exitosamente', 'success');
    }

    // Auto-refresh para archivos en procesamiento
    const processingFiles = document.querySelectorAll('.status-processing');
    if (processingFiles.length > 0) {
        setTimeout(() => {
            window.location.reload();
        }, 10000); // Refresh cada 10 segundos si hay archivos procesándose
    }

    // Agregar estilos para animaciones
    if (!document.getElementById('upload-animations')) {
        const style = document.createElement('style');
        style.id = 'upload-animations';
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }

    // Mostrar mensajes de éxito/error del servidor
    @if(session('success'))
        showNotification('{{ session("success") }}', 'success');
    @endif
    
    @if(session('error'))
        showNotification('{{ session("error") }}', 'error');
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            showNotification('{{ $error }}', 'error');
        @endforeach
    @endif
</script>
@endsection