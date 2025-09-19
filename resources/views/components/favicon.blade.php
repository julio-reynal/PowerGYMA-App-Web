{{-- Meta tags para favicon y PWA --}}
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

{{-- Favicons para diferentes tamaños --}}
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}">

{{-- Apple Touch Icon --}}
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}">
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}">

{{-- Microsoft Tiles --}}
<meta name="msapplication-TileImage" content="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}">
<meta name="msapplication-TileColor" content="#007bff">
<meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">

{{-- PWA Manifest --}}
<link rel="manifest" href="{{ asset('site.webmanifest') }}">

{{-- Theme colors --}}
<meta name="theme-color" content="#007bff">
<meta name="msapplication-navbutton-color" content="#007bff">
<meta name="apple-mobile-web-app-status-bar-style" content="#007bff">

{{-- PWA meta tags --}}
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="PowerGYMA">
<meta name="application-name" content="PowerGYMA">

{{-- Preload favicon para mejor rendimiento --}}
<link rel="preload" href="{{ asset('favicon.svg') }}" as="image" type="image/svg+xml">
<link rel="preload" href="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}" as="image" type="image/svg+xml">