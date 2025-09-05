<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Excel - Power GYMA Admin</title>
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
            background: var(--card); 
            border-bottom: 1px solid var(--border); 
            padding: 1.5rem 2rem; 
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        
        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .header-title h1 {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--info));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
        }
        
        .excel-icon {
            font-size: 2.5rem;
            color: #22c55e;
            background: var(--success-light);
            padding: 0.75rem;
            border-radius: var(--radius);
        }
        
        /* Botones */
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
        }
        
        .btn-primary { 
            background: linear-gradient(135deg, var(--primary), var(--primary-dark)); 
            color: white; 
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
        }
        
        .btn-info {
            background: linear-gradient(135deg, var(--info), #0891b2);
            color: white;
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, var(--text-muted), #475569);
            color: white;
        }
        
        /* Container */
        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        /* Cards */
        .card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, var(--primary-light), var(--info-light));
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Alertas modernas */
        .alert {
            padding: 1.25rem 1.5rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            border: 2px solid;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }
        
        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }
        
        .alert-success {
            background: var(--success-light);
            color: #065f46;
            border-color: var(--success);
        }
        
        .alert-success::before {
            background: var(--success);
        }
        
        .alert-error {
            background: var(--danger-light);
            color: #991b1b;
            border-color: var(--danger);
        }
        
        .alert-error::before {
            background: var(--danger);
        }
        
        .alert-warning {
            background: var(--warning-light);
            color: #92400e;
            border-color: var(--warning);
        }
        
        .alert-warning::before {
            background: var(--warning);
        }
        
        .alert-info {
            background: var(--info-light);
            color: #0c4a6e;
            border-color: var(--info);
        }
        
        .alert-info::before {
            background: var(--info);
        }
        
        .alert-icon {
            font-size: 1.5rem;
            margin-top: 0.125rem;
        }
        
        .alert-content {
            flex: 1;
        }
        
        .alert-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }
        
        .alert-details {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        /* Upload área moderna */
        .upload-area {
            border: 3px dashed var(--border);
            border-radius: var(--radius);
            padding: 3rem;
            text-align: center;
            background: linear-gradient(135deg, var(--card), var(--border-light));
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .upload-area:hover {
            border-color: var(--primary);
            background: linear-gradient(135deg, var(--primary-light), var(--info-light));
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
        }
        
        .upload-text {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .upload-hint {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        /* File input personalizado */
        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        
        /* Progress bar */
        .progress-container {
            background: var(--border-light);
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 1rem;
        }
        
        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--success), var(--info));
            border-radius: 4px;
            transition: width 0.3s ease;
            width: 0%;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .header {
                padding: 1rem;
            }
            
            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .container {
                padding: 0 1rem;
            }
            
            .upload-area {
                padding: 2rem 1rem;
            }
            
            .upload-icon {
                font-size: 3rem;
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
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>
</head>

<body>
    <!-- Header moderno -->
    <div class="header">
        <div class="header-content">
            <div class="header-title">
                <div class="excel-icon">
                    <i class="fas fa-file-excel"></i>
                </div>
                <div>
                    <h1>Gestión de Archivos Excel</h1>
                    <p style="color: var(--text-muted); font-size: 1rem; margin: 0;">
                        Procesamiento inteligente de datos de riesgo
                    </p>
                </div>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('admin.excel.template') }}" class="btn btn-success">
                    <i class="fas fa-download"></i>
                    Descargar Plantilla
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="container fade-in">
    <div class="container fade-in">
        
        <!-- Mensajes de éxito/error mejorados -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle alert-icon"></i>
                <div class="alert-content">
                    <div class="alert-title">¡Archivo procesado exitosamente!</div>
                    <div class="alert-details">{{ session('success') }}</div>
                    @if(session('upload_summary'))
                        <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #059669;">
                            <strong>📊 Resumen del procesamiento:</strong>
                            <ul style="margin-top: 0.5rem; margin-left: 1rem;">
                                <li>✅ Evaluaciones diarias: <strong>{{ session('upload_summary')['daily_evaluations'] ?? 0 }}</strong></li>
                                <li>📅 Datos mensuales: <strong>{{ session('upload_summary')['monthly_data'] ?? 0 }}</strong></li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle alert-icon"></i>
                <div class="alert-content">
                    <div class="alert-title">Error al procesar archivo</div>
                    <div class="alert-details">{{ session('error') }}</div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle alert-icon"></i>
                <div class="alert-content">
                    <div class="alert-title">Se encontraron errores en el formulario</div>
                    <div class="alert-details">
                        <ul style="margin-top: 0.5rem;">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Panel de subida mejorado -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-cloud-upload-alt"></i>
                    Subir Nuevo Archivo Excel/CSV
                </h2>
                <span style="background: var(--success-light); color: #065f46; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.85rem; font-weight: 500;">
                    <i class="fas fa-shield-check"></i>
                    Sistema activo
                </span>
            </div>
            
            <div class="card-body">
                <!-- Alerta sobre formato de archivo -->
                <div class="alert alert-warning">
                    <i class="fas fa-file-csv alert-icon"></i>
                    <div class="alert-content">
                        <div class="alert-title">⚠️ Solo archivos CSV admitidos actualmente</div>
                        <div class="alert-details">
                            <p><strong>Importante:</strong> El sistema está optimizado para archivos CSV (.csv).</p>
                            <p>💡 <strong>Tip:</strong> Si tiene un archivo Excel, guárdelo como CSV: <strong>Archivo → Guardar como → CSV (delimitado por comas)</strong></p>
                        </div>
                    </div>
                </div>

                <!-- Documentación del formato -->
                <div class="alert alert-info">
                    <i class="fas fa-info-circle alert-icon"></i>
                    <div class="alert-content">
                        <div class="alert-title">📋 Formato requerido del archivo CSV</div>
                        <div class="alert-details">
                            <p style="margin-bottom: 1rem;">El archivo debe contener <strong>DOS SECCIONES claramente definidas</strong>:</p>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-top: 1rem;">
                                <!-- Sección 1: Revisión de Riesgo Diario -->
                                <div style="background: rgba(59, 130, 246, 0.1); padding: 1rem; border-radius: var(--radius-sm); border-left: 4px solid var(--primary);">
                                    <h4 style="margin: 0 0 0.75rem 0; color: var(--primary); font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                                        🎯 SECCIÓN 1: Revisión de Riesgo Diario
                                    </h4>
                                    <div style="background: var(--card); padding: 0.75rem; border-radius: var(--radius-sm); border: 1px solid var(--border);">
                                        <p style="margin: 0 0 0.5rem 0; font-weight: 500; font-size: 0.9rem;">Formato requerido:</p>
                                        <pre style="font-size: 0.8rem; background: var(--border-light); padding: 0.75rem; border-radius: 4px; margin: 0; border: 1px solid var(--border); overflow-x: auto;">FECHA: 25-ago
RIESGO: Alto
HORA INICIO: 19:00
HORA FIN: 20:00</pre>
                                    </div>
                                </div>

                                <!-- Sección 2: Revisión Mensual -->
                                <div style="background: rgba(16, 185, 129, 0.1); padding: 1rem; border-radius: var(--radius-sm); border-left: 4px solid var(--success);">
                                    <h4 style="margin: 0 0 0.75rem 0; color: var(--success); font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                                        📅 SECCIÓN 2: Revisión de Riesgo Mensual
                                    </h4>
                                    <div style="background: var(--card); padding: 0.75rem; border-radius: var(--radius-sm); border: 1px solid var(--border);">
                                        <p style="margin: 0 0 0.5rem 0; font-weight: 500; font-size: 0.9rem;">Formato por día:</p>
                                        <pre style="font-size: 0.8rem; background: var(--border-light); padding: 0.75rem; border-radius: 4px; margin: 0; border: 1px solid var(--border); overflow-x: auto;">1-ago,Alto
2-ago,Bajo
3-ago,Moderado
...</pre>
                                    </div>
                                </div>
                            </div>
                            
                            <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(245, 158, 11, 0.1); border-radius: var(--radius-sm); border: 1px solid var(--warning);">
                                <p style="margin: 0; font-weight: 500; color: var(--warning);">
                                    <i class="fas fa-star"></i> <strong>Niveles válidos de riesgo:</strong> 
                                    Muy Bajo, Bajo, Moderado, Alto, Crítico, No procede
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Formulario de subida mejorado -->
                <form action="{{ route('admin.excel.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <div class="upload-area" id="uploadArea">
                        <i class="fas fa-cloud-upload-alt upload-icon pulse"></i>
                        <div class="upload-text">Arrastra y suelta tu archivo CSV aquí</div>
                        <div class="upload-hint">o haz clic para seleccionar un archivo</div>
                        <input type="file" name="excel_file" id="fileInput" class="file-input" accept=".csv,.xlsx,.xls" required>
                        <div class="progress-container" id="progressContainer" style="display: none;">
                            <div class="progress-bar" id="progressBar"></div>
                        </div>
                        <div id="fileName" style="margin-top: 1rem; font-weight: 500; color: var(--primary); display: none;"></div>
                    </div>
                    
                    <div style="text-align: center; margin-top: 1.5rem;">
                        <button type="submit" class="btn btn-primary" id="submitBtn" style="font-size: 1.1rem; padding: 1rem 2rem;">
                            <i class="fas fa-upload"></i>
                            Procesar Archivo
                        </button>
                    </div>
                </form>
            </div>
        </div>
                            <p class="mt-2">
                                <strong>Niveles válidos:</strong> Muy Bajo, Bajo, Moderado, Alto, Crítico, No procede
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('admin.excel.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="flex items-center justify-center w-full">
                    <label for="excel_file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click para subir</span> o arrastra el archivo</p>
                            <p class="text-xs text-gray-500">CSV (.csv) (MAX. 10MB)</p>
                        </div>
                        <input id="excel_file" name="excel_file" type="file" class="hidden" accept=".csv" required />
                    </label>
                </div>
                <!-- Año para las fechas sin año del CSV -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="csv_year" class="block text-sm font-medium text-gray-700 mb-1">Año de los datos (para fechas como 25-ago)</label>
                        <?php $currentYear = now()->year; ?>
                        <select id="csv_year" name="csv_year" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="{{ $currentYear }}" selected>{{ $currentYear }}</option>
                            <option value="{{ $currentYear + 1 }}">{{ $currentYear + 1 }}</option>
                            <option value="{{ $currentYear - 1 }}">{{ $currentYear - 1 }}</option>
                            <option value="{{ $currentYear - 2 }}">{{ $currentYear - 2 }}</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">El archivo CSV no incluye año. Se usará este año para interpretar las fechas.</p>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.excel.template') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                            <i class="fas fa-download mr-1"></i>Descargar plantilla CSV
                        </a>
                        <button type="button" onclick="showFormatModal()" class="text-green-600 hover:text-green-800 text-sm">
                            <i class="fas fa-question-circle mr-1"></i>Ver formato detallado
                        </button>
                    </div>
                    <button id="submitBtn" type="submit" class="bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-2 rounded-lg transition duration-200" disabled>
                        <i class="fas fa-upload mr-2"></i>Subir / Actualizar información
                    </button>
                </div>
            </form>
        </div>

        <!-- Historial de uploads -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">
                    <i class="fas fa-history mr-2 text-green-600"></i>Historial de Archivos Procesados
                </h2>
            </div>

            @if($uploads->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archivo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registros</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($uploads as $upload)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-file-excel text-green-600 mr-2"></i>
                                            <span class="text-sm text-gray-900">{{ $upload->original_filename }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $upload->adminUser->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($upload->status)
                                            @case('completed')
                                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                                    <i class="fas fa-check-circle mr-1"></i>Completado
                                                </span>
                                                @break
                                            @case('failed')
                                                <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">
                                                    <i class="fas fa-times-circle mr-1"></i>Error
                                                </span>
                                                @break
                                            @case('processing')
                                                <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">
                                                    <i class="fas fa-spinner fa-spin mr-1"></i>Procesando
                                                </span>
                                                @break
                                            @default
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
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                        <thead>
                            <tr style="background: var(--bg); border-bottom: 2px solid var(--border);">
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-muted);">
                                    <i class="fas fa-file-alt"></i> Archivo
                                </th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-muted);">
                                    <i class="fas fa-user-shield"></i> Administrador
                                </th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-muted);">
                                    <i class="fas fa-traffic-light"></i> Estado
                                </th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-muted);">
                                    <i class="fas fa-chart-bar"></i> Registros
                                </th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-muted);">
                                    <i class="fas fa-calendar-plus"></i> Procesado
                                </th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-muted);">
                                    <i class="fas fa-cog"></i> Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($uploads as $upload)
                                <tr style="border-bottom: 1px solid var(--border-light); transition: background 0.2s ease;" 
                                    onmouseover="this.style.background='var(--border-light)'" 
                                    onmouseout="this.style.background='transparent'">
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <div style="width: 40px; height: 40px; background: var(--success-light); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-file-csv" style="color: var(--success); font-size: 1.2rem;"></i>
                                            </div>
                                            <div>
                                                <div style="font-weight: 500; color: var(--text);">{{ $upload->original_filename }}</div>
                                                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ number_format($upload->file_size / 1024, 1) }} KB</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <div style="width: 32px; height: 32px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.8rem;">
                                                {{ strtoupper(substr($upload->adminUser->name ?? 'A', 0, 2)) }}
                                            </div>
                                            <span style="font-weight: 500;">{{ $upload->adminUser->name ?? 'Admin' }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem;">
                                        @switch($upload->status)
                                            @case('completed')
                                                <span style="background: var(--success-light); color: #065f46; padding: 0.4rem 0.8rem; border-radius: 50px; font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                    <i class="fas fa-check-circle"></i> Completado
                                                </span>
                                                @break
                                            @case('failed')
                                                <span style="background: var(--danger-light); color: #991b1b; padding: 0.4rem 0.8rem; border-radius: 50px; font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                    <i class="fas fa-times-circle"></i> Error
                                                </span>
                                                @break
                                            @case('processing')
                                                <span style="background: var(--warning-light); color: #92400e; padding: 0.4rem 0.8rem; border-radius: 50px; font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                    <i class="fas fa-spinner fa-spin"></i> Procesando
                                                </span>
                                                @break
                                            @default
                                                <span style="background: var(--text-light); color: var(--text); padding: 0.4rem 0.8rem; border-radius: 50px; font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                    <i class="fas fa-clock"></i> Pendiente
                                                </span>
                                        @endswitch
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="font-weight: 600; color: var(--primary); font-size: 1.1rem;">
                                            {{ number_format($upload->records_processed) }}
                                        </div>
                                        <div style="font-size: 0.8rem; color: var(--text-muted);">registros</div>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="font-weight: 500;">{{ $upload->created_at->format('d/m/Y') }}</div>
                                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $upload->created_at->format('H:i') }}</div>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 0.5rem;">
                                            <a href="{{ route('admin.excel.show', $upload->id) }}" 
                                               style="padding: 0.5rem; background: var(--info-light); color: #0c4a6e; border-radius: var(--radius-sm); text-decoration: none; display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; transition: all 0.2s ease;"
                                               onmouseover="this.style.transform='scale(1.1)'"
                                               onmouseout="this.style.transform='scale(1)'"
                                               title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($upload->status === 'failed')
                                                <form action="{{ route('admin.excel.reprocess', $upload->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" 
                                                            style="padding: 0.5rem; background: var(--warning-light); color: #92400e; border: none; border-radius: var(--radius-sm); cursor: pointer; display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; transition: all 0.2s ease;"
                                                            onmouseover="this.style.transform='scale(1.1)'"
                                                            onmouseout="this.style.transform='scale(1)'"
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
                                                        style="padding: 0.5rem; background: var(--danger-light); color: #991b1b; border: none; border-radius: var(--radius-sm); cursor: pointer; display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; transition: all 0.2s ease;"
                                                        onmouseover="this.style.transform='scale(1.1)'"
                                                        onmouseout="this.style.transform='scale(1)'"
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
                    <div style="padding: 1.5rem; border-top: 1px solid var(--border); background: var(--border-light); display: flex; justify-content: center;">
                        {{ $uploads->links() }}
                    </div>
                @endif
            @else
                <div style="padding: 4rem 2rem; text-align: center; color: var(--text-muted);">
                    <i class="fas fa-inbox" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <div style="font-size: 1.2rem; margin-bottom: 0.5rem; font-weight: 500;">No hay archivos procesados aún</div>
                    <div style="font-size: 1rem;">¡Sube tu primer archivo Excel para comenzar!</div>
                </div>
            @endif
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
                const validTypes = ['.csv', '.xlsx', '.xls'];
                const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
                
                if (!validTypes.includes(fileExtension)) {
                    alert('Por favor, selecciona un archivo CSV, XLSX o XLS válido.');
                    return;
                }
                
                // Show file name
                fileName.textContent = `📄 ${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
                fileName.style.display = 'block';
                
                // Update upload area appearance
                uploadArea.style.borderColor = 'var(--success)';
                uploadArea.style.background = 'var(--success-light)';
                
                // Update submit button
                submitBtn.innerHTML = '<i class="fas fa-check"></i> Archivo Listo - Procesar';
                submitBtn.style.background = 'linear-gradient(135deg, var(--success), #059669)';
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
        });
    </script>
</body>
</html>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center"><span class="w-4 h-4 bg-orange-500 rounded mr-2"></span><code>Alto</code></div>
                                    <div class="flex items-center"><span class="w-4 h-4 bg-red-500 rounded mr-2"></span><code>Crítico</code></div>
                                    <div class="flex items-center"><span class="w-4 h-4 bg-gray-500 rounded mr-2"></span><code>No procede</code></div>
                                </div>
                            </div>
                        </div>

                        <!-- Errores comunes -->
                        <div>
                            <h4 class="text-md font-semibold text-red-600 mb-2">⚠️ Errores Comunes a Evitar</h4>
                            <div class="bg-red-50 p-4 rounded-lg">
                                <ul class="text-sm space-y-1">
                                    <li>❌ <code>25/08/2025</code> → ✅ <code>25-ago</code></li>
                                    <li>❌ <code>Medio</code> → ✅ <code>Moderado</code></li>
                                    <li>❌ <code>19:00:00</code> → ✅ <code>19:00</code></li>
                                    <li>❌ <code>N/A</code> → ✅ <code>No procede</code></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6 pt-4 border-t">
                    <button onclick="closeFormatModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Preview del archivo seleccionado + habilitar botón de envío
        document.getElementById('excel_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const fileName = file?.name;
            const label = e.target.closest('label');
            const submitBtn = document.getElementById('submitBtn');
            if (fileName && label) {
                label.querySelector('p').innerHTML = `<span class="font-semibold">Archivo seleccionado:</span> ${fileName}`;
            } else if (label) {
                label.querySelector('p').innerHTML = '<span class="font-semibold">Click para subir</span> o arrastra el archivo';
            }
            if (submitBtn) {
                submitBtn.disabled = !file;
            }
        });

        // Funciones del modal
        function showFormatModal() {
            document.getElementById('formatModal').classList.remove('hidden');
        }

        function closeFormatModal() {
            document.getElementById('formatModal').classList.add('hidden');
        }

        // Cerrar modal al hacer click fuera
        document.getElementById('formatModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeFormatModal();
            }
        });
    </script>
</body>
</html>
