@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')
@section('page-title', 'Gestión de Usuarios')
@section('page-description', 'Administra todos los usuarios del sistema Power GYMA')

@section('content')
    <!-- Actions Bar -->
    <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
        <div class="flex items-center gap-4 flex-wrap">
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-transform transform hover:scale-105 flex items-center gap-2 shadow-lg">
                <i class="fas fa-user-plus"></i>
                <span>Crear Usuario</span>
            </a>
            <a href="{{ route('admin.users.create-demo') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-lg font-semibold transition-transform transform hover:scale-105 flex items-center gap-2 shadow-lg">
                <i class="fas fa-user-clock"></i>
                <span>Crear Usuario Demo</span>
            </a>
        </div>
    </div>

    <!-- Grid de Estadísticas Principales -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card icon="fa-users" label="Total de Usuarios" :value="$users->total()" color="blue" />
        <x-stat-card icon="fa-user-check" label="Usuarios Activos" :value="$users->where('is_active', true)->count()" color="green" />
        <x-stat-card icon="fa-user-clock" label="Usuarios Demo" :value="$users->where('role', 'demo')->count()" color="yellow" />
        <x-stat-card icon="fa-user-shield" label="Administradores" :value="$users->where('role', 'admin')->count()" color="purple" />
    </div>

    <!-- Tabla de Usuarios -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-3">
                    <i class="fas fa-users text-blue-500"></i>
                    <span>Lista de Usuarios</span>
                </h3>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <input type="text" placeholder="Buscar..." 
                               class="pl-10 pr-4 py-2 w-64 border border-gray-300 dark:border-gray-600 rounded-full bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300"
                               id="search-users">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <div class="relative">
                        <select class="appearance-none pl-10 pr-4 py-2 w-48 border border-gray-300 dark:border-gray-600 rounded-full bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                id="filter-role">
                            <option value="">Todos los roles</option>
                            <option value="admin">Admin</option>
                            <option value="cliente">Cliente</option>
                            <option value="demo">Demo</option>
                        </select>
                        <i class="fas fa-filter absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3"><i class="fas fa-user mr-2"></i>Usuario</th>
                        <th scope="col" class="px-6 py-3"><i class="fas fa-tag mr-2"></i>Rol</th>
                        <th scope="col" class="px-6 py-3"><i class="fas fa-toggle-on mr-2"></i>Estado</th>
                        <th scope="col" class="px-6 py-3"><i class="fas fa-building mr-2"></i>Empresa</th>
                        <th scope="col" class="px-6 py-3"><i class="fas fa-calendar-alt mr-2"></i>Registro</th>
                        <th scope="col" class="px-6 py-3 text-center"><i class="fas fa-cogs mr-2"></i>Acciones</th>
                    </tr>
                </thead>
                <tbody id="users-table-body">
                    @forelse($users as $user)
                        <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold text-lg">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-base">{{ $user->name }}</div>
                                        <div class="text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleConfig = [
                                        'admin' => ['bg' => 'bg-red-100 dark:bg-red-900', 'text' => 'text-red-800 dark:text-red-200', 'icon' => 'fas fa-user-shield'],
                                        'cliente' => ['bg' => 'bg-green-100 dark:bg-green-900', 'text' => 'text-green-800 dark:text-green-200', 'icon' => 'fas fa-user'],
                                        'demo' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900', 'text' => 'text-yellow-800 dark:text-yellow-200', 'icon' => 'fas fa-user-clock'],
                                    ];
                                    $config = $roleConfig[$user->role] ?? $roleConfig['cliente'];
                                @endphp
                                <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $config['bg'] }} {{ $config['text'] }} inline-flex items-center gap-2">
                                    <i class="{{ $config['icon'] }}"></i>
                                    <span>{{ ucfirst($user->role) }}</span>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_active)
                                    <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 inline-flex items-center gap-2">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Activo</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 inline-flex items-center gap-2">
                                        <i class="fas fa-times-circle"></i>
                                        <span>Inactivo</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold">{{ $user->razon_social ?? 'N/A' }}</div>
                                @if($user->ruc_empresa)
                                    <div class="text-xs text-gray-500">RUC: {{ $user->ruc_empresa }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold">{{ $user->created_at->isoFormat('LL') }}</div>
                                <div class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="#" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-200 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-all" title="Ver detalles">
                                        <i class="fas fa-eye fa-lg"></i>
                                    </a>
                                    <a href="#" class="text-yellow-500 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-all" title="Editar">
                                        <i class="fas fa-edit fa-lg"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="{{ $user->is_active ? 'text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300' : 'text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300' }} p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-all" 
                                                title="{{ $user->is_active ? 'Desactivar' : 'Activar' }}">
                                            <i class="fas fa-{{ $user->is_active ? 'ban' : 'check-circle' }} fa-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-16">
                                <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-users text-7xl mb-6 opacity-30 text-blue-400"></i>
                                    <h3 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-2">No se encontraron usuarios</h3>
                                    <p class="mb-6">Parece que no hay nadie aquí. ¡Crea el primer usuario para empezar!</p>
                                    <div class="flex gap-4 flex-wrap justify-center">
                                        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-transform transform hover:scale-105 flex items-center gap-2 shadow-lg">
                                            <i class="fas fa-user-plus"></i>
                                            <span>Crear Usuario</span>
                                        </a>
                                        <a href="{{ route('admin.users.create-demo') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-3 rounded-lg font-semibold transition-transform transform hover:scale-105 flex items-center gap-2 shadow-lg">
                                            <i class="fas fa-user-clock"></i>
                                            <span>Crear Usuario Demo</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
            <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-users');
        const roleFilter = document.getElementById('filter-role');
        const tableBody = document.getElementById('users-table-body');
        const rows = tableBody.querySelectorAll('tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedRole = roleFilter.value.toLowerCase();

            rows.forEach(row => {
                if (row.querySelector('td[colspan]')) {
                    return;
                }

                const textContent = row.textContent.toLowerCase();
                const roleElement = row.querySelector('span[data-role]');
                const userRole = roleElement ? roleElement.dataset.role.toLowerCase() : '';

                const matchesSearch = textContent.includes(searchTerm);
                const matchesRole = selectedRole === '' || userRole === selectedRole;

                row.style.display = matchesSearch && matchesRole ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        roleFilter.addEventListener('change', filterTable);
        
        document.querySelectorAll('tbody tr').forEach(row => {
            const roleSpan = row.querySelector('td:nth-child(2) span');
            if (roleSpan) {
                const roleText = roleSpan.textContent.trim().toLowerCase();
                if (roleText.includes('admin')) {
                    roleSpan.dataset.role = 'admin';
                } else if (roleText.includes('cliente')) {
                    roleSpan.dataset.role = 'cliente';
                } else if (roleText.includes('demo')) {
                    roleSpan.dataset.role = 'demo';
                }
            }
        });
    });
</script>
@endpush