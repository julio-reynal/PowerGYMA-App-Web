@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Vista general del sistema Power GYMA.')

@section('content')
    <!-- Stats Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card icon="fa-users" label="Total de Usuarios" :value="$stats['total_users']" color="blue" />
        <x-stat-card icon="fa-user-check" label="Clientes Activos" :value="$stats['clientes_activos']" color="green" />
        <x-stat-card icon="fa-user-clock" label="Usuarios Demo" :value="$stats['demos_activos']" color="yellow" />
        <x-stat-card icon="fa-hourglass-half" label="Demos Pendientes" :value="$demo_stats['pendientes']" color="purple" />
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Recent Users -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Usuarios Recientes</h3>
                    <a href="{{ route('admin.users') }}" class="text-sm text-blue-500 hover:underline">Ver todos</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registro</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recent_users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center font-bold">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->isoFormat('LL') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12 text-gray-500">
                                        <i class="fas fa-users text-4xl mb-3"></i>
                                        <p>No hay usuarios recientes.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Demo Requests -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg mt-8">
                <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Solicitudes de Demo Recientes</h3>
                    <a href="{{ route('admin.demo-requests.index') }}" class="text-sm text-blue-500 hover:underline">Ver todas</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solicitante</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recent_demo_requests as $request)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium">{{ $request->nombre }}</div>
                                        <div class="text-sm text-gray-500">{{ $request->created_at->isoFormat('LLL') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $request->empresa }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeClass = match($request->estado) {
                                                'pendiente' => 'bg-yellow-100 text-yellow-800',
                                                'contactado' => 'bg-blue-100 text-blue-800',
                                                'programado' => 'bg-purple-100 text-purple-800',
                                                'completado' => 'bg-green-100 text-green-800',
                                                'rechazado' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                            {{ $request->estado_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.demo-requests.show', $request) }}" class="text-blue-500 hover:text-blue-700" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12 text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-3"></i>
                                        <p>No hay solicitudes de demo recientes.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- Risk System -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                <h3 class="text-xl font-bold mb-4 flex items-center"><i class="fas fa-shield-alt mr-3 text-blue-500"></i>Sistema de Riesgo</h3>
                @if(isset($hasTodayExcel) && $hasTodayExcel && isset($currentEval) && $currentEval)
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Nivel de Riesgo Actual</p>
                        <p class="text-4xl font-extrabold {{ $currentEval->risk_color_class }}">{{ $currentEval->risk_level }}</p>
                        <p class="text-sm text-gray-500">Puntaje: {{ number_format($currentEval->score, 2) }}</p>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Recomendación:</strong> {{ $currentEval->recommendation }}</p>
                    </div>
                    <div class="mt-6 text-center">
                        <button onclick="updateRiskSystem()" id="update-risk-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-all transform hover:scale-105">
                            <i class="fas fa-sync-alt mr-2"></i>Actualizar Sistema
                        </button>
                    </div>
                @else
                    <div class="text-center py-8 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <i class="fas fa-info-circle text-yellow-500 text-4xl mb-3"></i>
                        <p class="font-semibold">Datos no disponibles</p>
                        <p class="text-sm mt-1">Sube el archivo Excel de hoy para ver el estado del riesgo.</p>
                    </div>
                @endif
            </div>

            <!-- Data Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                <div class="p-6 border-b dark:border-gray-700">
                    <h3 class="text-lg font-semibold">Estadísticas de Datos</h3>
                </div>
                <div class="p-6 space-y-4">
                    @foreach($data_stats as $label => $value)
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ Str::title(str_replace('_', ' ', $label)) }}</p>
                            <p class="text-sm font-bold">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    async function updateRiskSystem() {
        const btn = document.getElementById('update-risk-btn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando...';

        try {
            const response = await fetch('/api/v1/risk/update-by-time', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
            const result = await response.json();
            if (result.success) {
                window.location.reload();
            } else {
                alert(result.message || 'Error al actualizar.');
            }
        } catch (error) {
            alert('Error de conexión.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>Actualizar Sistema';
        }
    }
</script>
@endpush