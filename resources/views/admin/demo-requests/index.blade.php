@extends('layouts.admin')

@section('title', 'Solicitudes de Demo')
@section('page-title', 'Solicitudes de Demo')
@section('page-description', 'Gestiona las solicitudes de demostración del sistema.')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Bandeja de Solicitudes</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Revisa y gestiona las nuevas solicitudes de demo.</p>
            </div>
            <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105 flex items-center gap-2" onclick="exportToCSV()">
                <i class="fas fa-file-excel"></i>
                <span>Exportar a CSV</span>
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <x-stat-card icon="fa-clock" label="Pendientes" :value="$estadisticas['pendientes'] ?? 0" color="yellow" />
            <x-stat-card icon="fa-phone-alt" label="Contactados" :value="$estadisticas['contactados'] ?? 0" color="blue" />
            <x-stat-card icon="fa-calendar-check" label="Programados" :value="$estadisticas['programados'] ?? 0" color="indigo" />
            <x-stat-card icon="fa-check-circle" label="Completados" :value="$estadisticas['completados'] ?? 0" color="green" />
        </div>

        <!-- Filters -->
        <div class="mb-4">
            <div class="relative">
                <select id="filter-status" class="appearance-none w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 py-3 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Filtrar por estado (Todos)</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="aprobado">Aprobado</option>
                    <option value="contactado">Contactado</option>
                    <option value="rechazado">Rechazado</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>

        <!-- Requests Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 rounded-l-lg">Solicitante</th>
                        <th scope="col" class="px-6 py-3">Empresa</th>
                        <th scope="col" class="px-6 py-3">Estado</th>
                        <th scope="col" class="px-6 py-3">Fecha</th>
                        <th scope="col" class="px-6 py-3 text-center rounded-r-lg">Acciones</th>
                    </tr>
                </thead>
                <tbody id="requests-table-body">
                    @forelse($solicitudes ?? [] as $request)
                        <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 dark:text-white">{{ $request->nombre }}</div>
                                <div class="text-gray-500">{{ $request->email }}</div>
                                @if($request->telefono_celular)
                                    <div class="text-gray-500"><i class="fas fa-phone-alt mr-1"></i>{{ $request->telefono_celular }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold">{{ $request->empresa }}</div>
                                @if($request->ruc_empresa)
                                    <div class="text-xs text-gray-500">RUC: {{ $request->ruc_empresa }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusConfig = [
                                        'pendiente' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900', 'text' => 'text-yellow-800 dark:text-yellow-200'],
                                        'aprobado' => ['bg' => 'bg-green-100 dark:bg-green-900', 'text' => 'text-green-800 dark:text-green-200'],
                                        'rechazado' => ['bg' => 'bg-red-100 dark:bg-red-900', 'text' => 'text-red-800 dark:text-red-200'],
                                        'contactado' => ['bg' => 'bg-blue-100 dark:bg-blue-900', 'text' => 'text-blue-800 dark:text-blue-200'],
                                    ];
                                    $config = $statusConfig[$request->estado] ?? $statusConfig['pendiente'];
                                @endphp
                                <span data-status="{{ $request->estado }}" class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $config['bg'] }} {{ $config['text'] }}">
                                    {{ ucfirst($request->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold">{{ $request->created_at->isoFormat('LL') }}</div>
                                <div class="text-xs text-gray-500">{{ $request->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('admin.demo-requests.show', $request) }}" class="text-gray-500 hover:text-blue-600 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-all" title="Ver Detalles">
                                        <i class="fas fa-eye fa-lg"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.demo-requests.update', $request) }}" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="estado" value="contactado">
                                        <button type="submit" class="text-gray-500 hover:text-green-600 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-all" title="Marcar como Contactado">
                                            <i class="fas fa-phone-alt fa-lg"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.demo-requests.destroy', $request) }}" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta solicitud?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-600 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-all" title="Eliminar Solicitud">
                                            <i class="fas fa-trash-alt fa-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-16">
                                <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-inbox text-7xl mb-6 opacity-30 text-blue-400"></i>
                                    <h3 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-2">Bandeja Vacía</h3>
                                    <p>No hay solicitudes de demo por el momento.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterStatus = document.getElementById('filter-status');
        const tableBody = document.getElementById('requests-table-body');
        const rows = tableBody.querySelectorAll('tr');

        filterStatus.addEventListener('change', function() {
            const selectedStatus = this.value.toLowerCase();
            rows.forEach(row => {
                if (row.querySelector('td[colspan]')) {
                    row.style.display = ''; // Show the 'empty' message row
                    return;
                }
                const statusElement = row.querySelector('span[data-status]');
                const status = statusElement ? statusElement.dataset.status.toLowerCase() : '';
                if (selectedStatus === '' || status === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    function exportToCSV() {
        const table = document.querySelector('tbody');
        if (!table) {
            alert('No hay datos para exportar');
            return;
        }

        const rows = Array.from(table.querySelectorAll('tr'));
        if (rows.length === 0 || (rows.length === 1 && rows[0].querySelector('td[colspan]'))) {
            alert('No hay solicitudes para exportar.');
            return;
        }

        const csvData = [];
        const headers = ['ID', 'Nombre', 'Email', 'Teléfono', 'Empresa', 'RUC', 'Estado', 'Fecha Solicitud'];
        csvData.push(headers.join(','));

        rows.forEach((row, index) => {
            if (row.querySelector('td[colspan]')) return;

            const cells = row.querySelectorAll('td');
            const solicitanteCell = cells[0];
            const empresaCell = cells[1];
            const estadoCell = cells[2];
            const fechaCell = cells[3];

            const nombre = solicitanteCell.querySelector('.font-bold').textContent.trim();
            const email = solicitanteCell.querySelector('.text-gray-500').textContent.trim();
            const telefono = solicitanteCell.querySelector('.fa-phone-alt') ? solicitanteCell.lastChild.textContent.trim() : '';
            const empresa = empresaCell.querySelector('.font-semibold').textContent.trim();
            const ruc = empresaCell.querySelector('.text-xs') ? empresaCell.querySelector('.text-xs').textContent.replace('RUC: ', '').trim() : '';
            const estado = estadoCell.querySelector('span[data-status]').textContent.trim();
            const fecha = fechaCell.querySelector('.font-semibold').textContent.trim();

            const rowData = [
                index + 1,
                `"${nombre}"`,
                `"${email}"`,
                `"${telefono}"`,
                `"${empresa}"`,
                `"${ruc}"`,
                `"${estado}"`,
                `"${fecha}"`
            ];
            csvData.push(rowData.join(','));
        });

        const csvContent = '\uFEFF' + csvData.join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `solicitudes_demo_${new Date().toISOString().split('T')[0]}.csv`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }
</script>
@endpush
