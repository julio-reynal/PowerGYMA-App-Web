@extends('layouts.admin')

@section('title', 'Crear Usuario Demo')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header moderno -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Crear Usuario Demo</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Configure un usuario con acceso temporal al sistema</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors">Dashboard</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('admin.users') }}" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors">Usuarios</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-gray-900 dark:text-white font-medium">Crear Usuario Demo</span>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Alertas -->
        @if($errors->any())
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Hay errores en el formulario</h3>
                        <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-sm text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Formulario principal -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('admin.demo.store') }}" class="space-y-0">
                @csrf

                <!-- Información Personal -->
                <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información Personal</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nombre Completo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('name') border-red-500 @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Nombres y apellidos completos"
                                   maxlength="255"
                                   required>
                            @error('name')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Correo Electrónico <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('email') border-red-500 @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="usuario@empresa.com"
                                   maxlength="255"
                                   required>
                            @error('email')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="tipo_documento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tipo de Documento <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('tipo_documento') border-red-500 @enderror" 
                                    id="tipo_documento" 
                                    name="tipo_documento" 
                                    required>
                                <option value="">Seleccionar tipo...</option>
                                <option value="DNI" {{ old('tipo_documento') === 'DNI' ? 'selected' : '' }}>DNI</option>
                                <option value="CE" {{ old('tipo_documento') === 'CE' ? 'selected' : '' }}>Carné de Extranjería</option>
                                <option value="PASAPORTE" {{ old('tipo_documento') === 'PASAPORTE' ? 'selected' : '' }}>Pasaporte</option>
                                <option value="RUC" {{ old('tipo_documento') === 'RUC' ? 'selected' : '' }}>RUC</option>
                            </select>
                            @error('tipo_documento')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="numero_documento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Número de Documento <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('numero_documento') border-red-500 @enderror" 
                                   id="numero_documento" 
                                   name="numero_documento" 
                                   value="{{ old('numero_documento') }}" 
                                   placeholder="12345678"
                                   maxlength="20"
                                   required>
                            @error('numero_documento')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Fecha de Nacimiento
                            </label>
                            <input type="date" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('fecha_nacimiento') border-red-500 @enderror" 
                                   id="fecha_nacimiento" 
                                   name="fecha_nacimiento" 
                                   value="{{ old('fecha_nacimiento') }}" 
                                   max="{{ date('Y-m-d', strtotime('-18 years')) }}">
                            @error('fecha_nacimiento')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="genero" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Género
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('genero') border-red-500 @enderror" 
                                    id="genero" 
                                    name="genero">
                                <option value="">Seleccionar género...</option>
                                <option value="M" {{ old('genero') === 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('genero') === 'F' ? 'selected' : '' }}>Femenino</option>
                                <option value="O" {{ old('genero') === 'O' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('genero')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-green-100 dark:bg-green-900/20 rounded-lg">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información de Contacto</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label for="telefono" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Teléfono Principal <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('telefono') border-red-500 @enderror" 
                                   id="telefono" 
                                   name="telefono" 
                                   value="{{ old('telefono') }}" 
                                   placeholder="999 123 456"
                                   maxlength="20"
                                   required>
                            @error('telefono')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="telefono_celular" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Teléfono Celular
                            </label>
                            <input type="tel" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('telefono_celular') border-red-500 @enderror" 
                                   id="telefono_celular" 
                                   name="telefono_celular" 
                                   value="{{ old('telefono_celular') }}" 
                                   placeholder="987 654 321"
                                   maxlength="20">
                            @error('telefono_celular')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="telefono_fijo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Teléfono Fijo
                            </label>
                            <input type="tel" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('telefono_fijo') border-red-500 @enderror" 
                                   id="telefono_fijo" 
                                   name="telefono_fijo" 
                                   value="{{ old('telefono_fijo') }}" 
                                   placeholder="(01) 234-5678"
                                   maxlength="20">
                            @error('telefono_fijo')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="direccion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Dirección Personal
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('direccion') border-red-500 @enderror" 
                                   id="direccion" 
                                   name="direccion" 
                                   value="{{ old('direccion') }}" 
                                   placeholder="Av. Lima 123, Miraflores"
                                   maxlength="255">
                            @error('direccion')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="puesto_trabajo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Puesto de Trabajo
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('puesto_trabajo') border-red-500 @enderror" 
                                   id="puesto_trabajo" 
                                   name="puesto_trabajo" 
                                   value="{{ old('puesto_trabajo') }}" 
                                   placeholder="Gerente de Operaciones"
                                   maxlength="255">
                            @error('puesto_trabajo')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Información de Ubicación -->
                <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-orange-100 dark:bg-orange-900/20 rounded-lg">
                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información de Ubicación</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label for="departamento_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Departamento <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('departamento_id') border-red-500 @enderror" 
                                    id="departamento_id" 
                                    name="departamento_id" 
                                    required>
                                <option value="">Seleccionar departamento...</option>
                                <option value="1" {{ old('departamento_id') == '1' ? 'selected' : '' }}>Lima</option>
                                <option value="2" {{ old('departamento_id') == '2' ? 'selected' : '' }}>Arequipa</option>
                                <option value="3" {{ old('departamento_id') == '3' ? 'selected' : '' }}>Cusco</option>
                                <option value="4" {{ old('departamento_id') == '4' ? 'selected' : '' }}>La Libertad</option>
                                <option value="5" {{ old('departamento_id') == '5' ? 'selected' : '' }}>Piura</option>
                                <option value="6" {{ old('departamento_id') == '6' ? 'selected' : '' }}>Lambayeque</option>
                            </select>
                            @error('departamento_id')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="provincia_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Provincia <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('provincia_id') border-red-500 @enderror" 
                                    id="provincia_id" 
                                    name="provincia_id" 
                                    required>
                                <option value="">Seleccionar provincia...</option>
                            </select>
                            @error('provincia_id')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="distrito" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Distrito
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('distrito') border-red-500 @enderror" 
                                   id="distrito" 
                                   name="distrito" 
                                   value="{{ old('distrito') }}" 
                                   placeholder="Miraflores"
                                   maxlength="100">
                            @error('distrito')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Configuración de Acceso -->
                <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900/20 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Configuración de Acceso</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('password') border-red-500 @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Mínimo 8 caracteres"
                                   minlength="8"
                                   required>
                            @error('password')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400">Incluye mayúsculas, minúsculas y números</p>
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Confirmar Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Repita la contraseña"
                                   minlength="8"
                                   required>
                        </div>

                        <!-- Campo oculto para rol de demo -->
                        <input type="hidden" name="role" value="demo">
                    </div>
                </div>

                <!-- Configuración de Demo (Específico para usuarios demo) -->
                <div class="p-8 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/10 dark:to-pink-900/10">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-pink-100 dark:bg-pink-900/20 rounded-lg">
                            <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Configuración de Demo</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label for="expires_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Fecha de Expiración <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-700 dark:text-white transition-colors @error('expires_at') border-red-500 @enderror" 
                                   id="expires_at" 
                                   name="expires_at" 
                                   value="{{ old('expires_at', date('Y-m-d', strtotime('+30 days'))) }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   required>
                            @error('expires_at')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400">Fecha límite de acceso al sistema</p>
                        </div>

                        <div class="space-y-2">
                            <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Estado del Usuario <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-700 dark:text-white transition-colors @error('is_active') border-red-500 @enderror" 
                                    id="is_active" 
                                    name="is_active" 
                                    required>
                                <option value="">Seleccionar estado...</option>
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('is_active')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400">Controla si el usuario puede acceder</p>
                        </div>
                    </div>
                </div>

                <!-- Información de la Empresa -->
                <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información de la Empresa</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label for="ruc_empresa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                RUC de la Empresa <span class="text-red-500">*</span>
                            </label>
                            <div class="flex space-x-2">
                                <input type="text" 
                                       class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('ruc_empresa') border-red-500 @enderror" 
                                       id="ruc_empresa" 
                                       name="ruc_empresa" 
                                       value="{{ old('ruc_empresa') }}" 
                                       placeholder="20123456789"
                                       maxlength="11"
                                       pattern="[0-9]{11}"
                                       required>
                                <button type="button" 
                                        id="search-ruc"
                                        class="px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <span>Buscar</span>
                                </button>
                            </div>
                            @error('ruc_empresa')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <div id="ruc-status" class="hidden"></div>
                        </div>

                        <div class="space-y-2">
                            <label for="razon_social" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Razón Social <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('razon_social') border-red-500 @enderror" 
                                   id="razon_social" 
                                   name="razon_social" 
                                   value="{{ old('razon_social') }}" 
                                   placeholder="Empresa Ejemplo S.A.C."
                                   maxlength="255"
                                   required>
                            @error('razon_social')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="giro_empresa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Giro de la Empresa <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('giro_empresa') border-red-500 @enderror" 
                                    id="giro_empresa" 
                                    name="giro_empresa" 
                                    required>
                                <option value="">Seleccionar giro empresarial...</option>
                                <option value="comercio" {{ old('giro_empresa') === 'comercio' ? 'selected' : '' }}>Comercio</option>
                                <option value="servicios" {{ old('giro_empresa') === 'servicios' ? 'selected' : '' }}>Servicios</option>
                                <option value="manufactura" {{ old('giro_empresa') === 'manufactura' ? 'selected' : '' }}>Manufactura</option>
                                <option value="construccion" {{ old('giro_empresa') === 'construccion' ? 'selected' : '' }}>Construcción</option>
                                <option value="tecnologia" {{ old('giro_empresa') === 'tecnologia' ? 'selected' : '' }}>Tecnología</option>
                                <option value="salud" {{ old('giro_empresa') === 'salud' ? 'selected' : '' }}>Salud</option>
                                <option value="educacion" {{ old('giro_empresa') === 'educacion' ? 'selected' : '' }}>Educación</option>
                                <option value="transporte" {{ old('giro_empresa') === 'transporte' ? 'selected' : '' }}>Transporte</option>
                                <option value="alimentario" {{ old('giro_empresa') === 'alimentario' ? 'selected' : '' }}>Alimentario</option>
                                <option value="textil" {{ old('giro_empresa') === 'textil' ? 'selected' : '' }}>Textil</option>
                                <option value="mineria" {{ old('giro_empresa') === 'mineria' ? 'selected' : '' }}>Minería</option>
                                <option value="agroindustria" {{ old('giro_empresa') === 'agroindustria' ? 'selected' : '' }}>Agroindustria</option>
                                <option value="otros" {{ old('giro_empresa') === 'otros' ? 'selected' : '' }}>Otros</option>
                            </select>
                            @error('giro_empresa')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nombre Comercial
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('company_name') border-red-500 @enderror" 
                                   id="company_name" 
                                   name="company_name" 
                                   value="{{ old('company_name') }}" 
                                   placeholder="Nombre comercial o marca"
                                   maxlength="255">
                            @error('company_name')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400">Si es diferente a la razón social</p>
                        </div>

                        <div class="space-y-2">
                            <label for="direccion_empresa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Dirección de la Empresa
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('direccion_empresa') border-red-500 @enderror" 
                                   id="direccion_empresa" 
                                   name="direccion_empresa" 
                                   value="{{ old('direccion_empresa') }}" 
                                   placeholder="Av. Javier Prado Este 123, San Isidro"
                                   maxlength="255">
                            @error('direccion_empresa')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="company_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Teléfono de la Empresa
                            </label>
                            <input type="tel" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('company_phone') border-red-500 @enderror" 
                                   id="company_phone" 
                                   name="company_phone" 
                                   value="{{ old('company_phone') }}" 
                                   placeholder="(01) 234-5678"
                                   maxlength="20">
                            @error('company_phone')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label for="company_activity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Actividad Principal
                            </label>
                            <textarea class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('company_activity') border-red-500 @enderror resize-none" 
                                      id="company_activity" 
                                      name="company_activity" 
                                      rows="3"
                                      placeholder="Descripción de la actividad principal de la empresa..."
                                      maxlength="500">{{ old('company_activity') }}</textarea>
                            @error('company_activity')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="company_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Empresa Asociada
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('company_id') border-red-500 @enderror" 
                                    id="company_id" 
                                    name="company_id">
                                <option value="">Seleccionar empresa...</option>
                                @foreach($companies ?? [] as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                        {{ $company->razon_social }} (RUC: {{ $company->ruc }})
                                    </option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400">Empresa a la que pertenece el usuario (opcional)</p>
                        </div>
                    </div>
                </div>

                <!-- Comentarios Adicionales -->
                <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg">
                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información Adicional</h2>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="comentarios_adicionales" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Comentarios Adicionales
                        </label>
                        <textarea class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors @error('comentarios_adicionales') border-red-500 @enderror" 
                                  id="comentarios_adicionales" 
                                  name="comentarios_adicionales" 
                                  rows="4" 
                                  maxlength="500" 
                                  placeholder="Comentarios adicionales sobre el usuario demo...">{{ old('comentarios_adicionales') }}</textarea>
                        @error('comentarios_adicionales')
                            <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 dark:text-gray-400">Máximo 500 caracteres</p>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="px-8 py-6 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                    <a href="{{ route('admin.users') }}" 
                       class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Cancelar</span>
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-lg font-medium transition-colors flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Crear Usuario Demo</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript para funcionalidad dinámica -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sistema de cascada de departamentos y provincias con API real
    const departamentoSelect = document.getElementById('departamento_id');
    const provinciaSelect = document.getElementById('provincia_id');

    // Cargar departamentos desde la API
    async function cargarDepartamentos() {
        try {
            const response = await fetch('/api/v1/locations/departamentos');
            const result = await response.json();
            
            if (response.ok && result.success) {
                // Limpiar departamentos existentes
                departamentoSelect.innerHTML = '<option value="">Seleccionar departamento...</option>';
                
                // Agregar departamentos desde la base de datos
                result.data.forEach(function(departamento) {
                    const option = document.createElement('option');
                    option.value = departamento.id;
                    option.textContent = departamento.nombre;
                    option.setAttribute('data-codigo', departamento.codigo);
                    departamentoSelect.appendChild(option);
                });
                
                console.log(`✓ Cargados ${result.data.length} departamentos desde la base de datos`);
            } else {
                console.error('Error al cargar departamentos:', result.message);
                // Fallback a mensaje de error
                departamentoSelect.innerHTML = '<option value="">Error al cargar departamentos</option>';
            }
        } catch (error) {
            console.error('Error de conexión al cargar departamentos:', error);
            departamentoSelect.innerHTML = '<option value="">Error de conexión</option>';
        }
    }

    // Cargar provincias por departamento desde la API
    async function cargarProvinciasPorDepartamento(departamentoId) {
        try {
            // Limpiar provincias mientras carga
            provinciaSelect.innerHTML = '<option value="">Cargando provincias...</option>';
            
            const response = await fetch(`/api/v1/locations/provincias/departamento/${departamentoId}`);
            const result = await response.json();
            
            if (response.ok && result.success) {
                // Limpiar y agregar opción por defecto
                provinciaSelect.innerHTML = '<option value="">Seleccionar provincia...</option>';
                
                // Agregar provincias desde la base de datos
                result.data.forEach(function(provincia) {
                    const option = document.createElement('option');
                    option.value = provincia.id;
                    option.textContent = provincia.nombre;
                    option.setAttribute('data-codigo', provincia.codigo);
                    provinciaSelect.appendChild(option);
                });
                
                console.log(`✓ Cargadas ${result.data.length} provincias para departamento ID ${departamentoId}`);
            } else {
                console.warn('No se encontraron provincias:', result.message);
                provinciaSelect.innerHTML = '<option value="">No hay provincias disponibles</option>';
            }
        } catch (error) {
            console.error('Error al cargar provincias:', error);
            provinciaSelect.innerHTML = '<option value="">Error al cargar provincias</option>';
        }
    }

    if (departamentoSelect && provinciaSelect) {
        // Cargar departamentos al iniciar
        cargarDepartamentos();

        // Manejar cambio de departamento
        departamentoSelect.addEventListener('change', function() {
            const departamentoId = this.value;
            
            if (departamentoId) {
                cargarProvinciasPorDepartamento(departamentoId);
            } else {
                provinciaSelect.innerHTML = '<option value="">Seleccionar provincia...</option>';
            }
        });

        // Restaurar valores seleccionados si existen (old values)
        const oldDepartamento = '{{ old("departamento_id") }}';
        const oldProvincia = '{{ old("provincia_id") }}';
        
        if (oldDepartamento) {
            // Esperar a que los departamentos se carguen
            setTimeout(function() {
                departamentoSelect.value = oldDepartamento;
                
                if (oldDepartamento) {
                    cargarProvinciasPorDepartamento(oldDepartamento).then(() => {
                        if (oldProvincia) {
                            setTimeout(() => {
                                provinciaSelect.value = oldProvincia;
                            }, 100);
                        }
                    });
                }
            }, 500);
        }
    }

    // Sistema de búsqueda y autocompletado de RUC
    const rucInput = document.getElementById('ruc_empresa');
    const razonSocialInput = document.getElementById('razon_social');
    const searchRucBtn = document.getElementById('search-ruc');
    const rucStatus = document.getElementById('ruc-status');

    // Función para buscar RUC en la base de datos
    async function buscarRUC(ruc) {
        if (!ruc || ruc.length !== 11) {
            mostrarStatusRUC('error', 'El RUC debe tener exactamente 11 dígitos');
            return;
        }

        try {
            mostrarStatusRUC('loading', 'Buscando RUC en la base de datos...');
            searchRucBtn.disabled = true;
            searchRucBtn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg><span>Buscando...</span>';

            const response = await fetch(`/api/v1/companies/ruc/${ruc}`);
            const result = await response.json();

            if (response.ok && result.success && result.data) {
                // RUC encontrado en la base de datos
                razonSocialInput.value = result.data.razon_social || result.data.nombre || '';
                mostrarStatusRUC('success', `✓ Empresa encontrada: ${result.data.razon_social || result.data.nombre}`);
            } else {
                // RUC no encontrado en la base de datos local
                mostrarStatusRUC('error', 'RUC no encontrado en la base de datos. Ingrese la razón social manualmente.');
                razonSocialInput.focus();
            }
        } catch (error) {
            console.error('Error al buscar RUC:', error);
            mostrarStatusRUC('error', 'Error de conexión. Verifique su conexión e intente nuevamente.');
        } finally {
            searchRucBtn.disabled = false;
            searchRucBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg><span>Buscar</span>';
        }
    }

    // Función para mostrar el estado de la búsqueda
    function mostrarStatusRUC(tipo, mensaje) {
        rucStatus.classList.remove('hidden');
        rucStatus.className = `p-3 rounded-lg text-sm font-medium ${tipo === 'success' ? 'bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-800' : 
                                                                    tipo === 'error' ? 'bg-red-100 dark:bg-red-900/20 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800' : 
                                                                    'bg-purple-100 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800'}`;
        rucStatus.textContent = mensaje;

        if (tipo === 'success' || tipo === 'error') {
            setTimeout(() => {
                rucStatus.classList.add('hidden');
            }, 5000);
        }
    }

    // Event listeners para el RUC
    if (rucInput && searchRucBtn) {
        // Buscar al hacer clic en el botón
        searchRucBtn.addEventListener('click', function() {
            const ruc = rucInput.value.trim();
            buscarRUC(ruc);
        });

        // Buscar al presionar Enter
        rucInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const ruc = this.value.trim();
                buscarRUC(ruc);
            }
        });

        // Validar formato mientras escribe
        rucInput.addEventListener('input', function() {
            const ruc = this.value.trim();
            rucStatus.classList.add('hidden');
            
            // Solo permitir números
            this.value = this.value.replace(/[^0-9]/g, '');
            
            if (ruc.length > 0 && ruc.length < 11) {
                mostrarStatusRUC('error', `Faltan ${11 - ruc.length} dígitos`);
            }
        });

        // Buscar automáticamente cuando complete 11 dígitos
        let timeoutId;
        rucInput.addEventListener('input', function() {
            const ruc = this.value.trim();
            if (ruc.length === 11) {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => {
                    if (this.value.trim() === ruc) {
                        buscarRUC(ruc);
                    }
                }, 1000);
            }
        });
    }
});
</script>
@endsection
