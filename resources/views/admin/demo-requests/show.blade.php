@extends('layouts.admin')

@section('title', 'Detalle de Solicitud de Demo')
@section('page-title', 'Detalle de Solicitud')
@section('page-description', 'Gestión completa de la solicitud #'.$demoRequest->id)

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="flex justify-between items-center flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Solicitud #{{ $demoRequest->id }}</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Recibida el {{ $demoRequest->created_at->isoFormat('LLLL') }}</p>
        </div>
        <a href="{{ route('admin.demo-requests.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg shadow-sm transition-all flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Volver al Listado</span>
        </a>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column (Details) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Requestor Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 flex items-center gap-4">
                    <i class="fas fa-user-tie text-2xl text-blue-500"></i>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Información del Solicitante</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-info-item icon="fa-user" label="Nombre" :value="$demoRequest->nombre" />
                    <x-info-item icon="fa-envelope" label="Email" :value="$demoRequest->email" type="email" />
                    <x-info-item icon="fa-phone" label="Teléfono" :value="$demoRequest->telefono" type="tel" />
                    <x-info-item icon="fa-mobile-alt" label="Celular" :value="$demoRequest->telefono_celular" type="tel" />
                    <x-info-item icon="fa-id-card" label="Tipo Documento" :value="$demoRequest->tipo_documento" />
                    <x-info-item icon="fa-hashtag" label="Nro. Documento" :value="$demoRequest->numero_documento" />
                </div>
            </div>

            <!-- Company Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 flex items-center gap-4">
                    <i class="fas fa-building text-2xl text-green-500"></i>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Información de la Empresa</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-info-item icon="fa-briefcase" label="Empresa" :value="$demoRequest->empresa" />
                    <x-info-item icon="fa-id-badge" label="RUC" :value="$demoRequest->ruc_empresa" />
                    <x-info-item icon="fa-industry" label="Giro" :value="$demoRequest->giro_empresa" />
                    <x-info-item icon="fa-user-tag" label="Cargo" :value="$demoRequest->cargo_puesto" />
                    <x-info-item icon="fa-map-marker-alt" label="Dirección" :value="$demoRequest->direccion" />
                    <x-info-item icon="fa-city" label="Ubicación" :value="$demoRequest->ciudad . ($demoRequest->provincia ? ' - ' . $demoRequest->provincia->nombre : '') . ($demoRequest->departamento ? ' - ' . $demoRequest->departamento->nombre : '')" />
                </div>
            </div>

            <!-- Comments -->
            @if($demoRequest->comentarios || $demoRequest->necesidades_especificas)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 flex items-center gap-4">
                    <i class="fas fa-comment-dots text-2xl text-yellow-500"></i>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Comentarios y Necesidades</h3>
                </div>
                <div class="p-6 space-y-4">
                    @if($demoRequest->comentarios)
                        <div>
                            <h4 class="font-semibold text-gray-600 dark:text-gray-300">Comentarios Adicionales:</h4>
                            <p class="text-gray-800 dark:text-gray-200 mt-1 italic">"{{ $demoRequest->comentarios }}"</p>
                        </div>
                    @endif
                    @if($demoRequest->necesidades_especificas)
                        <div>
                            <h4 class="font-semibold text-gray-600 dark:text-gray-300">Necesidades Específicas:</h4>
                            <p class="text-gray-800 dark:text-gray-200 mt-1 italic">"{{ $demoRequest->necesidades_especificas }}"</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif

        </div>

        <!-- Right Column (Status & Actions) -->
        <div class="space-y-8">
            
            <!-- Status Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Estado</h3>
                    @php
                        $statusConfig = [
                            'pendiente' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900', 'text' => 'text-yellow-800 dark:text-yellow-200', 'icon' => 'fa-clock'],
                            'contactado' => ['bg' => 'bg-blue-100 dark:bg-blue-900', 'text' => 'text-blue-800 dark:text-blue-200', 'icon' => 'fa-phone-alt'],
                            'programado' => ['bg' => 'bg-indigo-100 dark:bg-indigo-900', 'text' => 'text-indigo-800 dark:text-indigo-200', 'icon' => 'fa-calendar-check'],
                            'completado' => ['bg' => 'bg-green-100 dark:bg-green-900', 'text' => 'text-green-800 dark:text-green-200', 'icon' => 'fa-check-circle'],
                            'rechazado' => ['bg' => 'bg-red-100 dark:bg-red-900', 'text' => 'text-red-800 dark:text-red-200', 'icon' => 'fa-times-circle'],
                        ];
                        $config = $statusConfig[$demoRequest->estado] ?? $statusConfig['pendiente'];
                    @endphp
                    <span class="px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wider {{ $config['bg'] }} {{ $config['text'] }} inline-flex items-center gap-2">
                        <i class="fas {{ $config['icon'] }}"></i>
                        <span>{{ $demoRequest->estado_label }}</span>
                    </span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Última actualización: {{ $demoRequest->updated_at->diffForHumans() }}</p>
            </div>

            <!-- Actions Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Actualizar Solicitud</h3>
                <form method="POST" action="{{ route('admin.demo-requests.update', $demoRequest) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cambiar Estado</label>
                        <select name="estado" id="estado" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                            <option value="pendiente" @if($demoRequest->estado == 'pendiente') selected @endif>Pendiente</option>
                            <option value="contactado" @if($demoRequest->estado == 'contactado') selected @endif>Contactado</option>
                            <option value="programado" @if($demoRequest->estado == 'programado') selected @endif>Demo Programada</option>
                            <option value="completado" @if($demoRequest->estado == 'completado') selected @endif>Completado</option>
                            <option value="rechazado" @if($demoRequest->estado == 'rechazado') selected @endif>Rechazado</option>
                        </select>
                    </div>

                    <div>
                        <label for="fecha_demo_programada" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de Demo</label>
                        <input type="datetime-local" name="fecha_demo_programada" id="fecha_demo_programada" value="{{ $demoRequest->fecha_demo_programada ? $demoRequest->fecha_demo_programada->format('Y-m-d\TH:i') : '' }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                    </div>

                    <div>
                        <label for="notas_internas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notas Internas</label>
                        <textarea name="notas_internas" id="notas_internas" rows="5" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5" placeholder="Añadir notas de seguimiento...">{{ $demoRequest->notas_internas }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        <span>Actualizar Solicitud</span>
                    </button>
                </form>
            </div>

            @if($demoRequest->estado === 'completado')
                <div class="bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-200 p-4 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-2xl mr-3"></i>
                        <div>
                            <p class="font-bold">¡Demo Completada!</p>
                            <p>Puedes proceder a crear una cuenta de demostración para este usuario.</p>
                            <a href="{{ route('admin.users.create-demo') }}?demo_request={{ $demoRequest->id }}" class="mt-2 inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg text-sm">
                                <i class="fas fa-user-plus"></i> Crear Usuario Demo
                            </a>
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
        const estadoSelect = document.getElementById('estado');
        const fechaDemoInput = document.getElementById('fecha_demo_programada');

        estadoSelect.addEventListener('change', function() {
            if (this.value === 'programado' && !fechaDemoInput.value) {
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                tomorrow.setHours(10, 0, 0, 0);
                fechaDemoInput.value = tomorrow.toISOString().slice(0, 16);
            }
        });
    });
</script>
@endpush