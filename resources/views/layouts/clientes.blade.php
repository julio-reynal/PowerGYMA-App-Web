<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PowerGYMA') }} - @yield('title', 'Clientes')</title>

    {{-- Favicon y PWA meta tags --}}
    @include('components.favicon')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Reset default styles --}}
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            font-family: 'Inter', sans-serif !important;
            background: #111827 !important;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
            color: #ffffff;
        }
        
        #app {
            min-height: 100vh;
            background: transparent;
        }
    </style>

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>
    <div id="app">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>