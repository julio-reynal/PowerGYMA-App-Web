<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Upload - Power GYMA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-md border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-file-excel text-green-600 text-2xl"></i>
                    <h1 class="text-2xl font-bold text-gray-900">Detalles del Archivo</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.excel.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Volver a la Lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Información básica -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">
                <i class="fas fa-info-circle mr-2 text-blue-600"></i>Información del Archivo
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre del Archivo</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $upload->original_filename }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subido por</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $upload->adminUser->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fecha de Subida</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $upload->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Estado</label>
                    <div class="mt-1">
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
                                <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">
                                    <i class="fas fa-clock mr-1"></i>Pendiente
                                </span>
                        @endswitch
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Registros Procesados</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $upload->records_processed }}</p>
                </div>
                
                @if($upload->processed_at)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fecha de Procesamiento</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $upload->processed_at->format('d/m/Y H:i:s') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Resumen de procesamiento -->
        @if($upload->processing_summary)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">
                <i class="fas fa-chart-bar mr-2 text-green-600"></i>Resumen de Procesamiento
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-day text-blue-600 text-2xl mr-3"></i>
                        <div>
                            <p class="text-2xl font-bold text-blue-600">{{ $upload->processing_summary['daily_evaluations'] ?? 0 }}</p>
                            <p class="text-sm text-blue-700">Evaluaciones Diarias</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt text-green-600 text-2xl mr-3"></i>
                        <div>
                            <p class="text-2xl font-bold text-green-600">{{ $upload->processing_summary['monthly_data'] ?? 0 }}</p>
                            <p class="text-sm text-green-700">Datos Mensuales</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Errores (si los hay) -->
        @if($upload->error_message)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">
                <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>Mensaje de Error
            </h2>
            
            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ $upload->error_message }}</p>
                    </div>
                </div>
            </div>

            @if($upload->status === 'failed')
            <div class="mt-4">
                <form action="{{ route('admin.excel.reprocess', $upload->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-redo mr-2"></i>Reprocesar Archivo
                    </button>
                </form>
            </div>
            @endif
        </div>
        @endif

    </div>
</body>
</html>
