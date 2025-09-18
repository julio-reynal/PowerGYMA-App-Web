@extends('layouts.admin')

@section('title', 'Crear Usuario')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header moderno -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Crear Nuevo Usuario</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Complete la información para crear un usuario en el sistema</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('admin.users') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Usuarios</a>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-gray-900 dark:text-white font-medium">Crear Usuario</span>
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
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-0">
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
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('name') border-red-500 @enderror" 
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
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('email') border-red-500 @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="usuario@ejemplo.com"
                                   required>
                            @error('email')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('password') border-red-500 @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Mínimo 8 caracteres"
                                   required>
                            @error('password')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Confirmar Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Repetir contraseña"
                                   required>
                        </div>

                        <div class="space-y-2">
                            <label for="tipo_documento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tipo de Documento <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('tipo_documento') border-red-500 @enderror" 
                                    id="tipo_documento" 
                                    name="tipo_documento" 
                                    required>
                                <option value="">Seleccionar tipo...</option>
                                <option value="DNI" {{ old('tipo_documento') === 'DNI' ? 'selected' : '' }}>DNI</option>
                                <option value="RUC" {{ old('tipo_documento') === 'RUC' ? 'selected' : '' }}>RUC</option>
                                <option value="CE" {{ old('tipo_documento') === 'CE' ? 'selected' : '' }}>Carné de Extranjería</option>
                                <option value="PASAPORTE" {{ old('tipo_documento') === 'PASAPORTE' ? 'selected' : '' }}>Pasaporte</option>
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
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('numero_documento') border-red-500 @enderror" 
                                   id="numero_documento" 
                                   name="numero_documento" 
                                   value="{{ old('numero_documento') }}" 
                                   placeholder="Número del documento"
                                   maxlength="20"
                                   required>
                            @error('numero_documento')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="puesto_trabajo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Puesto de Trabajo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('puesto_trabajo') border-red-500 @enderror" 
                                   id="puesto_trabajo" 
                                   name="puesto_trabajo" 
                                   value="{{ old('puesto_trabajo') }}" 
                                   placeholder="Cargo o posición"
                                   maxlength="100"
                                   required>
                            @error('puesto_trabajo')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="telefono_celular" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Teléfono Celular <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('telefono_celular') border-red-500 @enderror" 
                                   id="telefono_celular" 
                                   name="telefono_celular" 
                                   value="{{ old('telefono_celular') }}" 
                                   placeholder="999 999 999"
                                   maxlength="15"
                                   required>
                            @error('telefono_celular')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="direccion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Dirección Personal
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('direccion') border-red-500 @enderror" 
                                   id="direccion" 
                                   name="direccion" 
                                   value="{{ old('direccion') }}" 
                                   placeholder="Dirección completa"
                                   maxlength="255">
                            @error('direccion')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Fecha de Nacimiento
                            </label>
                            <input type="date" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('fecha_nacimiento') border-red-500 @enderror" 
                                   id="fecha_nacimiento" 
                                   name="fecha_nacimiento" 
                                   value="{{ old('fecha_nacimiento') }}"
                                   max="{{ now()->subYears(18)->format('Y-m-d') }}">
                            @error('fecha_nacimiento')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="genero" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Género
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('genero') border-red-500 @enderror" 
                                    id="genero" 
                                    name="genero">
                                <option value="">Seleccionar género...</option>
                                <option value="masculino" {{ old('genero') === 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('genero') === 'femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="otro" {{ old('genero') === 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('genero')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
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
                            <label for="company_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Empresa Asociada
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('company_id') border-red-500 @enderror" 
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

                        <div class="space-y-2">
                            <label for="ruc_empresa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                RUC de la Empresa <span class="text-red-500">*</span>
                            </label>
                            <div class="flex space-x-2">
                                <input type="text" 
                                       class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('ruc_empresa') border-red-500 @enderror" 
                                       id="ruc_empresa" 
                                       name="ruc_empresa" 
                                       value="{{ old('ruc_empresa') }}" 
                                       placeholder="20123456789"
                                       maxlength="11"
                                       pattern="[0-9]{11}"
                                       required>
                                <button type="button" 
                                        id="search-ruc"
                                        class="px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <span>Buscar</span>
                                </button>
                            </div>
                            @error('ruc_empresa')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400">11 dígitos del RUC. Presiona buscar para autocompletar</p>
                            <div id="ruc-status" class="hidden p-3 rounded-lg text-sm font-medium"></div>
                        </div>

                        <div class="space-y-2">
                            <label for="razon_social" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Razón Social <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('razon_social') border-red-500 @enderror" 
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
                                Giro de la Empresa
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('giro_empresa') border-red-500 @enderror" 
                                    id="giro_empresa" 
                                    name="giro_empresa">
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
                            <label for="telefono_fijo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Teléfono Fijo de la Empresa
                            </label>
                            <input type="tel" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('telefono_fijo') border-red-500 @enderror" 
                                   id="telefono_fijo" 
                                   name="telefono_fijo" 
                                   value="{{ old('telefono_fijo') }}" 
                                   placeholder="01 123 4567"
                                   maxlength="15">
                            @error('telefono_fijo')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="departamento_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Departamento <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('departamento_id') border-red-500 @enderror" 
                                    id="departamento_id" 
                                    name="departamento_id" 
                                    required>
                                <option value="">Seleccionar departamento...</option>
                                @foreach($departamentos ?? [] as $departamento)
                                    <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                        {{ $departamento->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('departamento_id')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="provincia_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Provincia <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('provincia_id') border-red-500 @enderror" 
                                    id="provincia_id" 
                                    name="provincia_id" 
                                    required>
                                <option value="">Primero selecciona un departamento</option>
                            </select>
                            @error('provincia_id')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="distrito" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Distrito <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('distrito') border-red-500 @enderror" 
                                   id="distrito" 
                                   name="distrito" 
                                   value="{{ old('distrito') }}" 
                                   placeholder="Nombre del distrito"
                                   maxlength="255"
                                   required>
                            @error('distrito')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2 lg:col-span-3">
                            <label for="direccion_empresa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Dirección de la Empresa <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('direccion_empresa') border-red-500 @enderror" 
                                   id="direccion_empresa" 
                                   name="direccion_empresa" 
                                   value="{{ old('direccion_empresa') }}" 
                                   placeholder="Dirección completa de la empresa"
                                   maxlength="255"
                                   required>
                            @error('direccion_empresa')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Configuración del Sistema -->
                <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900/20 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Configuración del Sistema</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Rol del Usuario <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('role') border-red-500 @enderror" 
                                    id="role" 
                                    name="role" 
                                    required>
                                <option value="">Seleccionar rol...</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="cliente" {{ old('role') === 'cliente' ? 'selected' : '' }}>Cliente</option>
                                <option value="demo" {{ old('role') === 'demo' ? 'selected' : '' }}>Demo</option>
                            </select>
                            @error('role')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2" id="expires-field" style="display: none;">
                            <label for="expires_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Fecha de Expiración <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('expires_at') border-red-500 @enderror" 
                                   id="expires_at" 
                                   name="expires_at" 
                                   value="{{ old('expires_at', now()->addDays(30)->format('Y-m-d')) }}"
                                   min="{{ now()->addDay()->format('Y-m-d') }}">
                            @error('expires_at')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400">Solo para usuarios demo</p>
                        </div>

                        <div class="space-y-2">
                            <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Estado del Usuario <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('is_active') border-red-500 @enderror" 
                                    id="is_active" 
                                    name="is_active" 
                                    required>
                                <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('is_active')
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400">El usuario podrá acceder si está activo</p>
                        </div>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="p-8">
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
                        <textarea class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-colors @error('comentarios_adicionales') border-red-500 @enderror" 
                                  id="comentarios_adicionales" 
                                  name="comentarios_adicionales" 
                                  rows="4" 
                                  maxlength="500" 
                                  placeholder="Comentarios adicionales sobre el usuario...">{{ old('comentarios_adicionales') }}</textarea>
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
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Crear Usuario</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript para funcionalidad dinámica -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar fecha de expiración según el rol
    const roleSelect = document.getElementById('role');
    const expiresField = document.getElementById('expires-field');
    const expiresInput = document.getElementById('expires_at');
    
    function toggleExpiresField() {
        if (roleSelect.value === 'demo') {
            expiresField.style.display = 'block';
            expiresInput.required = true;
        } else {
            expiresField.style.display = 'none';
            expiresInput.required = false;
            expiresInput.value = '';
        }
    }
    
    roleSelect.addEventListener('change', toggleExpiresField);
    
    // Inicializar al cargar si ya hay un rol seleccionado
    if (roleSelect.value === 'demo') {
        toggleExpiresField();
    }

    // Sistema de búsqueda y autocompletado de RUC
    const rucInput = document.getElementById('ruc_empresa');
    const razonSocialInput = document.getElementById('razon_social');
    const searchRucBtn = document.getElementById('search-ruc');
    const rucStatus = document.getElementById('ruc-status');

    // Función para buscar RUC en la base de datos
    async function buscarRUC(ruc) {
        if (!ruc || ruc.length !== 11) return;
        
        rucStatus.innerHTML = '<span class="text-blue-600">🔍 Buscando información del RUC...</span>';
        rucStatus.classList.remove('hidden');
        rucStatus.className = 'p-3 rounded-lg text-sm font-medium bg-blue-50 border border-blue-200';
        
        try {
            const response = await fetch(`/api/v1/company/search-ruc/${ruc}`);
            const result = await response.json();
            
            if (response.ok && result.success && result.data) {
                const company = result.data;
                
                // Autocompletar campos con los datos encontrados
                if (company.razon_social) {
                    document.getElementById('razon_social').value = company.razon_social;
                }
                if (company.direccion) {
                    document.getElementById('direccion_empresa').value = company.direccion;
                }
                
                rucStatus.innerHTML = '<span class="text-green-600">✓ RUC encontrado y datos autocompletados</span>';
                rucStatus.className = 'p-3 rounded-lg text-sm font-medium bg-green-50 border border-green-200';
                
                setTimeout(() => {
                    rucStatus.classList.add('hidden');
                }, 3000);
            } else {
                rucStatus.classList.add('hidden');
            }
        } catch (error) {
            console.error('Error al buscar RUC:', error);
            rucStatus.classList.add('hidden');
        }
    }

    // Event listener para el botón de búsqueda
    if (searchRucBtn) {
        searchRucBtn.addEventListener('click', function() {
            const ruc = rucInput.value.trim();
            if (ruc.length === 11) {
                buscarRUC(ruc);
            } else {
                alert('Por favor ingrese un RUC válido de 11 dígitos');
                rucInput.focus();
            }
        });
    }

    // Sistema de cascada de departamentos y provincias con API real
    const departamentoSelect = document.getElementById('departamento_id');
    const provinciaSelect = document.getElementById('provincia_id');

    // Cargar provincias según departamento seleccionado
    async function cargarProvincias(departamentoId) {
        try {
            const url = `/api/v1/locations/provincias/departamento/${departamentoId}`;
            console.log('🔄 Intentando cargar provincias desde:', url);
            
            const response = await fetch(url);
            console.log('📡 Respuesta API provincias:', response.status, response.statusText);
            
            const result = await response.json();
            console.log('📊 Datos provincias recibidos:', result);
            
            if (response.ok && result.success) {
                // Limpiar provincias existentes
                provinciaSelect.innerHTML = '<option value="">Seleccionar provincia...</option>';
                
                // Agregar provincias desde la base de datos
                result.data.forEach(provincia => {
                    const option = document.createElement('option');
                    option.value = provincia.id;
                    option.textContent = provincia.nombre;
                    provinciaSelect.appendChild(option);
                });
                
                console.log('✅ Provincias cargadas exitosamente:', result.data.length);
            } else {
                console.error('❌ Error al cargar provincias:', result.message);
                // Fallback para provincias de Lima si es el departamento 15
                if (departamentoId == 15) {
                    cargarProvinciasLimaEstaticas();
                } else {
                    provinciaSelect.innerHTML = '<option value="">Error al cargar provincias</option>';
                }
            }
        } catch (error) {
            console.error('💥 Error en la conexión al cargar provincias:', error);
            // Fallback para provincias de Lima si es el departamento 15
            if (departamentoId == 15) {
                cargarProvinciasLimaEstaticas();
            } else {
                provinciaSelect.innerHTML = '<option value="">Error de conexión</option>';
            }
        }
    }

    // Fallback para provincias de Lima
    function cargarProvinciasLimaEstaticas() {
        console.log('🔄 Cargando provincias de Lima como fallback');
        const provinciasLima = [
            {id: 134, nombre: 'Lima'},
            {id: 135, nombre: 'Barranca'},
            {id: 136, nombre: 'Cajatambo'},
            {id: 137, nombre: 'Canta'},
            {id: 138, nombre: 'Cañete'},
            {id: 139, nombre: 'Huaral'},
            {id: 140, nombre: 'Huarochirí'},
            {id: 141, nombre: 'Huaura'},
            {id: 142, nombre: 'Oyón'},
            {id: 143, nombre: 'Yauyos'}
        ];

        provinciaSelect.innerHTML = '<option value="">Seleccionar provincia...</option>';
        
        provinciasLima.forEach(provincia => {
            const option = document.createElement('option');
            option.value = provincia.id;
            option.textContent = provincia.nombre;
            provinciaSelect.appendChild(option);
        });
        
        console.log('✅ Provincias de Lima cargadas como fallback:', provinciasLima.length);
    }

    // Event listener para cambio de departamento
    departamentoSelect.addEventListener('change', function() {
        const departamentoId = this.value;
        
        if (departamentoId) {
            cargarProvincias(departamentoId);
        } else {
            provinciaSelect.innerHTML = '<option value="">Primero selecciona un departamento</option>';
        }
    });

    // Inicializar - Los departamentos ya vienen cargados desde PHP
    // Solo necesitamos manejar la carga dinámica de provincias
    console.log('✅ Departamentos ya cargados desde PHP. Solo inicializando carga de provincias.');

    // Autocompletado dinámico para RUC con timeout
    let timeoutId;

    if (rucInput) {
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