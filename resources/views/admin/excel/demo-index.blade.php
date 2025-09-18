@extends('layouts.admin')

@section('title', 'Gestión Excel - Demo')
@section('page-title', 'Gestión de Archivos Excel para Demo')
@section('page-description', 'Subir archivos Excel que se mostrarán como datos del mes anterior en el demo.')

@section('content')
<div class="space-y-6">
    <!-- Info sobre modo demo -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                    Modo Demo - Conversión Automática de Fechas
                </h3>
                <p class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                    Los archivos subidos aquí se procesarán especialmente para el demo. Las fechas del Excel (ej: 17-sept) 
                    se convertirán automáticamente al mes anterior (ej: 17-ago) para simular datos históricos en el dashboard de demo.
                </p>
                <p class="mt-1 text-xs text-blue-600 dark:text-blue-400">
                    Mes objetivo actual: <strong>{{ now()->subMonth()->locale('es')->isoFormat('MMMM YYYY') }}</strong>
                </p>
            </div>
        </div>
    </div>

    <!-- Subir archivo Excel para Demo -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
        <div class="p-6 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold flex items-center">
                <i class="fas fa-upload text-blue-500 mr-2"></i>
                Subir Archivo Excel para Demo
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                Las fechas se convertirán automáticamente al mes anterior
            </p>
        </div>
        
        <div class="p-6">
            <form action="{{ route('admin.demo-excel.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="excel_file" class="block text-sm font-medium mb-2">
                            Archivo CSV <span class="text-red-500">*</span>
                        </label>
                        <input type="file" 
                               id="excel_file" 
                               name="excel_file" 
                               accept=".csv" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <p class="text-xs text-gray-500 mt-1">Solo archivos CSV. Máximo 10MB.</p>
                    </div>
                    
                    <div>
                        <label for="csv_year" class="block text-sm font-medium mb-2">
                            Año de los datos originales <span class="text-red-500">*</span>
                        </label>
                        <select id="csv_year" 
                                name="csv_year" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            @for($year = now()->year; $year >= now()->year - 5; $year--)
                                <option value="{{ $year }}" {{ $year == now()->year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Año original de las fechas en el Excel</p>
                    </div>
                </div>
                
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Importante:</strong> Las fechas como "17-sept" se convertirán automáticamente a "17-ago" (mes anterior) 
                        para mostrar datos históricos en el demo.
                    </p>
                </div>
                
                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.demo-excel.download-template') }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        <i class="fas fa-download mr-1"></i>
                        Descargar plantilla de ejemplo
                    </a>
                    
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-upload mr-2"></i>
                        Procesar para Demo
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Acciones rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('demo.dashboard') }}" 
           class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
            <div class="flex items-center">
                <i class="fas fa-eye text-green-500 text-xl mr-3"></i>
                <div>
                    <h3 class="font-medium text-green-800 dark:text-green-200">Ver Dashboard Demo</h3>
                    <p class="text-sm text-green-600 dark:text-green-400">Ver cómo se ven los datos</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.demo-excel.refresh') }}" 
           class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4 hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
            <div class="flex items-center">
                <i class="fas fa-sync-alt text-purple-500 text-xl mr-3"></i>
                <div>
                    <h3 class="font-medium text-purple-800 dark:text-purple-200">Refrescar Demo</h3>
                    <p class="text-sm text-purple-600 dark:text-purple-400">Actualizar caché de datos</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('admin.excel.index') }}" 
           class="bg-gray-50 dark:bg-gray-900/20 border border-gray-200 dark:border-gray-800 rounded-lg p-4 hover:bg-gray-100 dark:hover:bg-gray-900/30 transition-colors">
            <div class="flex items-center">
                <i class="fas fa-file-excel text-gray-500 text-xl mr-3"></i>
                <div>
                    <h3 class="font-medium text-gray-800 dark:text-gray-200">Excel Normal</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Gestión Excel estándar</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Lista de archivos subidos para demo -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
        <div class="p-6 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold">Archivos Excel de Demo</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Historial de archivos procesados para el modo demo</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Archivo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Mes Objetivo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Registros</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($uploads as $upload)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium">{{ $upload->original_filename }}</div>
                                <div class="text-xs text-gray-500">{{ number_format($upload->file_size / 1024, 1) }} KB</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($upload->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Completado
                                    </span>
                                @elseif($upload->status === 'failed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Error
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Procesando
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if(isset($upload->processing_summary['target_month']))
                                    {{ \Carbon\Carbon::parse($upload->processing_summary['target_month'] . '-01')->locale('es')->isoFormat('MMMM YYYY') }}
                                @else
                                    {{ now()->subMonth()->locale('es')->isoFormat('MMMM YYYY') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                {{ $upload->records_processed ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $upload->created_at->isoFormat('LLL') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.demo-excel.show', $upload->id) }}" 
                                   class="text-blue-600 hover:text-blue-900">Ver</a>
                                
                                @if($upload->status === 'failed')
                                    <a href="{{ route('admin.demo-excel.reprocess', $upload->id) }}" 
                                       class="text-yellow-600 hover:text-yellow-900">Reintentar</a>
                                @endif
                                
                                <form method="POST" action="{{ route('admin.demo-excel.destroy', $upload->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('¿Estás seguro de que quieres eliminar este archivo de demo?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-3xl mb-3"></i>
                                <p>No hay archivos de demo subidos aún.</p>
                                <p class="text-sm">Sube tu primer archivo CSV para comenzar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($uploads->hasPages())
            <div class="px-6 py-3 border-t dark:border-gray-700">
                {{ $uploads->links() }}
            </div>
        @endif
    </div>
</div>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar mensaje de éxito
            console.log('Archivo procesado exitosamente para demo');
        });
    </script>
@endif
@endsection