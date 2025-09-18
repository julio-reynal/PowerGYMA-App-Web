@extends('layouts.admin')

@section('title', 'Detalles de Carga de Excel')
@section('page-title', 'Detalles de Carga')
@section('page-description', 'Información detallada del archivo y su procesamiento.')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="flex justify-between items-center flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 truncate" title="{{ $upload->original_filename }}">{{ Str::limit($upload->original_filename, 40) }}</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Subido por {{ $upload->adminUser->name ?? 'Sistema' }} el {{ $upload->created_at->isoFormat('LL') }}</p>
        </div>
        <a href="{{ route('admin.excel.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg shadow-sm transition-all flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Volver al Listado</span>
        </a>
    </div>

    <!-- Status & Main Info Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column (Status & Summary) -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Status Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Estado</h3>
                @php
                    $statusConfig = [
                        'completed' => ['bg' => 'bg-green-100 dark:bg-green-900', 'text' => 'text-green-800 dark:text-green-200', 'icon' => 'fas fa-check-circle'],
                        'failed' => ['bg' => 'bg-red-100 dark:bg-red-900', 'text' => 'text-red-800 dark:text-red-200', 'icon' => 'fas fa-times-circle'],
                        'processing' => ['bg' => 'bg-blue-100 dark:bg-blue-900', 'text' => 'text-blue-800 dark:text-blue-200', 'icon' => 'fas fa-spinner fa-spin'],
                        'pending' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900', 'text' => 'text-yellow-800 dark:text-yellow-200', 'icon' => 'fas fa-clock'],
                    ];
                    $config = $statusConfig[$upload->status] ?? $statusConfig['pending'];
                @endphp
                <span class="px-6 py-3 rounded-full text-lg font-bold uppercase tracking-wider {{ $config['bg'] }} {{ $config['text'] }} inline-flex items-center gap-3">
                    <i class="{{ $config['icon'] }}"></i>
                    <span>{{ $upload->status_text }}</span>
                </span>
                @if($upload->processed_at)
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">Procesado el {{ $upload->processed_at->isoFormat('LLLL') }}</p>
                @endif
            </div>

            <!-- Actions Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Acciones</h3>
                <div class="space-y-2">
                    @if($upload->status === 'failed')
                        <form action="{{ route('admin.excel.reprocess', $upload) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center gap-2 transition-all">
                                <i class="fas fa-redo"></i> Reprocesar Archivo
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('admin.excel.destroy', $upload) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este archivo y sus registros? Esta acción es irreversible.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg flex items-center justify-center gap-2 transition-all">
                            <i class="fas fa-trash-alt"></i> Eliminar Archivo
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column (Details) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- File Details -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 flex items-center gap-4">
                    <i class="fas fa-file-alt text-2xl text-gray-500"></i>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Detalles del Archivo</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-info-item icon="fa-file-signature" label="Nombre Original" :value="$upload->original_filename" />
                    <x-info-item icon="fa-save" label="Nombre Almacenado" :value="$upload->filename" />
                    <x-info-item icon="fa-weight-hanging" label="Tamaño" value="{{ number_format($upload->file_size / 1024, 2) }} KB" />
                    <x-info-item icon="fa-calendar-day" label="Año de Datos" value="{{ $upload->processing_summary['csv_year'] ?? 'N/A' }}" />
                </div>
            </div>

            <!-- Processing Summary -->
            @if($upload->processing_summary)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 flex items-center gap-4">
                    <i class="fas fa-chart-pie text-2xl text-purple-500"></i>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Resumen del Procesamiento</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-3xl font-extrabold text-blue-600 dark:text-blue-400">{{ number_format($upload->processing_summary['total_rows'] ?? 0) }}</p>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Filas Totales</p>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-3xl font-extrabold text-green-600 dark:text-green-400">{{ number_format($upload->records_processed ?? 0) }}</p>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Registros Creados</p>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-3xl font-extrabold text-yellow-600 dark:text-yellow-400">{{ number_format($upload->processing_summary['warnings'] ?? 0) }}</p>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Advertencias</p>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-3xl font-extrabold text-red-600 dark:text-red-400">{{ number_format($upload->processing_summary['errors'] ?? 0) }}</p>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Errores</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Error Details -->
            @if($upload->error_message)
            <div class="bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-800 dark:text-red-300 p-6 rounded-lg shadow-md">
                <div class="flex items-start gap-4">
                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                    <div>
                        <h4 class="font-bold text-lg">Detalles del Error</h4>
                        <pre class="mt-2 text-sm whitespace-pre-wrap font-mono bg-red-200 dark:bg-red-800 p-4 rounded-md">{{ $upload->error_message }}</pre>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($upload->status === 'processing')
            setTimeout(() => window.location.reload(), 10000); // Auto-refresh every 10 seconds
        @endif
    });
</script>
@endpush