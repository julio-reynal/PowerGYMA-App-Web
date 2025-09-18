@extends('layouts.admin')

@section('title', 'Detalles Excel Demo')
@section('page-title', 'Detalles del Archivo Excel Demo')
@section('page-description', 'Información detallada del procesamiento del archivo Excel para demo.')

@section('content')
<div class="space-y-6">
    <!-- Información del archivo -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
        <div class="p-6 border-b dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-magic text-orange-500 mr-2"></i>
                    Archivo Excel Demo
                </h3>
                <div class="flex items-center space-x-2">
                    @if($upload->status === 'completed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Completado
                        </span>
                    @elseif($upload->status === 'failed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i>
                            Error
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1"></i>
                            Procesando
                        </span>
                    @endif
                    
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                        <i class="fas fa-magic mr-1"></i>
                        DEMO
                    </span>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Archivo Original
                        </label>
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $upload->original_filename }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Tamaño del Archivo
                        </label>
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ number_format($upload->file_size / 1024, 1) }} KB</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Subido por
                        </label>
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $upload->adminUser->name ?? 'Usuario no disponible' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Fecha de Subida
                        </label>
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $upload->created_at->isoFormat('LLLL') }}</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Registros Procesados
                        </label>
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $upload->records_processed ?? 'N/A' }}</p>
                    </div>
                    
                    @if(isset($upload->processing_summary['target_month']))
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Mes Objetivo (Demo)
                        </label>
                        <p class="text-sm text-gray-900 dark:text-gray-100 font-medium text-orange-600">
                            {{ \Carbon\Carbon::parse($upload->processing_summary['target_month'] . '-01')->locale('es')->isoFormat('MMMM YYYY') }}
                        </p>
                    </div>
                    @endif
                    
                    @if(isset($upload->processing_summary['csv_year']))
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Año Original de los Datos
                        </label>
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $upload->processing_summary['csv_year'] }}</p>
                    </div>
                    @endif
                    
                    @if($upload->processed_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Fecha de Procesamiento
                        </label>
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $upload->processed_at->isoFormat('LLLL') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Detalles de procesamiento demo -->
    @if(isset($upload->processing_summary['demo_mode']))
    <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-xl">
        <div class="p-6">
            <h4 class="text-lg font-semibold text-orange-800 dark:text-orange-200 mb-4 flex items-center">
                <i class="fas fa-magic mr-2"></i>
                Información del Procesamiento Demo
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex justify-between">
                    <span class="text-orange-700 dark:text-orange-300">Modo Demo:</span>
                    <span class="font-medium text-orange-800 dark:text-orange-200">
                        {{ $upload->processing_summary['demo_mode'] ? 'Activado' : 'Desactivado' }}
                    </span>
                </div>
                
                @if(isset($upload->processing_summary['converted_to_previous_month']))
                <div class="flex justify-between">
                    <span class="text-orange-700 dark:text-orange-300">Fechas Convertidas:</span>
                    <span class="font-medium text-orange-800 dark:text-orange-200">
                        {{ $upload->processing_summary['converted_to_previous_month'] ? 'Sí' : 'No' }}
                    </span>
                </div>
                @endif
                
                @if(isset($upload->processing_summary['demo_year']) && isset($upload->processing_summary['demo_month']))
                <div class="flex justify-between">
                    <span class="text-orange-700 dark:text-orange-300">Año/Mes Demo:</span>
                    <span class="font-medium text-orange-800 dark:text-orange-200">
                        {{ $upload->processing_summary['demo_year'] }}/{{ str_pad($upload->processing_summary['demo_month'], 2, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                @endif
                
                @if(isset($upload->processing_summary['original_year']))
                <div class="flex justify-between">
                    <span class="text-orange-700 dark:text-orange-300">Año Original:</span>
                    <span class="font-medium text-orange-800 dark:text-orange-200">
                        {{ $upload->processing_summary['original_year'] }}
                    </span>
                </div>
                @endif
            </div>
            
            <div class="mt-4 p-3 bg-orange-100 dark:bg-orange-900/30 rounded-lg">
                <p class="text-sm text-orange-800 dark:text-orange-200">
                    <i class="fas fa-info-circle mr-2"></i>
                    Este archivo fue procesado específicamente para el modo demo. Las fechas fueron convertidas automáticamente 
                    del año {{ $upload->processing_summary['original_year'] ?? 'original' }} al mes anterior actual para simular datos históricos.
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Error si existe -->
    @if($upload->status === 'failed' && $upload->error_message)
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
        <div class="p-6">
            <h4 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Error de Procesamiento
            </h4>
            <p class="text-sm text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900/30 p-3 rounded-lg">
                {{ $upload->error_message }}
            </p>
        </div>
    </div>
    @endif

    <!-- Acciones -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
        <div class="p-6">
            <h4 class="text-lg font-semibold mb-4">Acciones</h4>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.demo-excel.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a la Lista
                </a>
                
                @if($upload->status === 'failed')
                    <form method="POST" action="{{ route('admin.demo-excel.reprocess', $upload->id) }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-redo mr-2"></i>
                            Reprocesar
                        </button>
                    </form>
                @endif
                
                <a href="{{ route('demo.dashboard') }}" 
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-eye mr-2"></i>
                    Ver Dashboard Demo
                </a>
                
                <a href="{{ route('admin.demo-excel.refresh') }}" 
                   class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Refrescar Demo
                </a>
                
                <form method="POST" action="{{ route('admin.demo-excel.destroy', $upload->id) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors"
                            onclick="return confirm('¿Estás seguro de que quieres eliminar este archivo de demo?')">
                        <i class="fas fa-trash mr-2"></i>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection