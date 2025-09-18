<!-- Mobile Overlay - Solo visible en móviles cuando el sidebar está abierto -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden"></div>

<!-- Sidebar -->
<aside 
    class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-gray-800 shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col"
    :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">

    <div class="flex items-center justify-between h-20 border-b border-gray-200 dark:border-gray-700 flex-shrink-0 px-4">
        <!-- Logo -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center">
            <img src="/Img/Ico/Ico-Pw.svg" alt="Power GYMA Logo" class="h-12">
        </a>
        
        <!-- Close button para móviles -->
        <button @click="sidebarOpen = false" 
                class="lg:hidden p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700 transition-colors">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" 
           @click="window.innerWidth < 1024 && (sidebarOpen = false)"
           class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg scale-105' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
            <i class="fas fa-tachometer-alt w-6 text-center"></i>
            <span class="mx-4 font-medium">Dashboard</span>
        </a>

        <a href="{{ route('admin.users') }}" 
           @click="window.innerWidth < 1024 && (sidebarOpen = false)"
           class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users*') ? 'bg-blue-600 text-white shadow-lg scale-105' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
            <i class="fas fa-users w-6 text-center"></i>
            <span class="mx-4 font-medium">Usuarios</span>
        </a>

        <a href="{{ route('admin.demo-requests.index') }}" 
           @click="window.innerWidth < 1024 && (sidebarOpen = false)"
           class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.demo-requests*') ? 'bg-blue-600 text-white shadow-lg scale-105' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
            <i class="fas fa-clipboard-list w-6 text-center"></i>
            <span class="mx-4 font-medium">Solicitudes Demo</span>
            @if(($demo_stats['pendientes'] ?? 0) > 0)
                <span class="ml-auto text-xs font-semibold text-white bg-red-500 rounded-full w-5 h-5 flex items-center justify-center">{{ $demo_stats['pendientes'] }}</span>
            @endif
        </a>

        <a href="{{ route('admin.excel.index') }}" 
           @click="window.innerWidth < 1024 && (sidebarOpen = false)"
           class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.excel.index') || request()->routeIs('admin.excel.show') || request()->routeIs('admin.excel.reprocess') ? 'bg-blue-600 text-white shadow-lg scale-105' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
            <i class="fas fa-file-excel w-6 text-center"></i>
            <span class="mx-4 font-medium">Gestión Excel</span>
        </a>

        <a href="{{ route('admin.demo-excel.index') }}" 
           @click="window.innerWidth < 1024 && (sidebarOpen = false)"
           class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.demo-excel*') ? 'bg-orange-600 text-white shadow-lg scale-105' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
            <i class="fas fa-magic w-6 text-center"></i>
            <span class="mx-4 font-medium">Excel Demo</span>
            <span class="ml-auto text-xs font-semibold text-orange-500 bg-orange-100 dark:bg-orange-900 px-2 py-1 rounded-full">DEMO</span>
        </a>
    </nav>

    <!-- Footer del sidebar -->
    <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex-shrink-0">
        <div class="text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Power GYMA v1.0
            </p>
        </div>
    </div>
</aside>