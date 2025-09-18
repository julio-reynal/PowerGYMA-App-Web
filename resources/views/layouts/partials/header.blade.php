<!-- Header -->
<header class="flex items-center justify-between h-16 px-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <!-- Left Section -->
    <div class="flex items-center gap-4">
        <!-- Mobile menu button -->
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700 transition-colors">
            <i class="fas fa-bars text-lg"></i>
        </button>
        
        <!-- Page Title -->
        <div class="hidden md:block">
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                @yield('page-title', 'Dashboard')
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                @yield('page-description', 'Panel de administración')
            </p>
        </div>
    </div>

    <!-- Right Section -->
    <div class="flex items-center gap-3">
        <!-- Theme Toggle -->
        <button onclick="toggleTheme()" 
                id="theme-toggle"
                class="p-2.5 rounded-lg text-gray-500 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700 transition-all duration-200"
                title="Cambiar tema">
            <i id="theme-icon-light" class="fas fa-moon text-lg"></i>
            <i id="theme-icon-dark" class="fas fa-sun text-lg hidden"></i>
        </button>

        <!-- Divider -->
        <div class="h-6 w-px bg-gray-200 dark:bg-gray-600"></div>

        <!-- User Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" 
                    class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <!-- Avatar -->
                <img class="h-8 w-8 rounded-full ring-2 ring-gray-200 dark:ring-gray-600" 
                     src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3B82F6&color=fff&bold=true" 
                     alt="{{ auth()->user()->name }}">
                
                <!-- User info (hidden on mobile) -->
                <div class="hidden md:block text-left">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Administrador</p>
                </div>
                
                <!-- Dropdown arrow -->
                <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200" 
                   x-bind:class="open ? 'rotate-180' : ''"></i>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" 
                 @click.away="open = false" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 scale-95 translate-y-1" 
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                 x-transition:leave="transition ease-in duration-150" 
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                 x-transition:leave-end="opacity-0 scale-95 translate-y-1" 
                 class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50 overflow-hidden">
                
                <!-- User Info Header -->
                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex items-center gap-3">
                        <img class="h-10 w-10 rounded-full" 
                             src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3B82F6&color=fff&bold=true" 
                             alt="Avatar">
                        <div>
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Logout Button -->
                <div class="p-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="flex items-center w-full px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition-colors group">
                            <i class="fas fa-sign-out-alt mr-3 group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">Cerrar Sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
