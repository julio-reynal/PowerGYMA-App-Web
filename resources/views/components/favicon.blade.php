{{-- Favicon implementación robusta para Railway --}}
{{-- Enlaces principales en orden de prioridad --}}
<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

{{-- Rutas absolutas como fallback --}}
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/Img/Ico/Ico-Pw-Redes.svg" type="image/svg+xml">

{{-- Apple Touch Icons esenciales --}}
<link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
<link rel="apple-touch-icon" href="{{ asset('Img/Ico/Ico-Pw-Redes.svg') }}" sizes="180x180">

{{-- Meta tags PWA --}}
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
<meta name="theme-color" content="#007bff">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="PowerGYMA">
<meta name="application-name" content="PowerGYMA">

{{-- Fallbacks para navegadores antiguos --}}
<meta name="msapplication-TileColor" content="#007bff">
<meta name="msapplication-TileImage" content="{{ asset('favicon.svg') }}">

{{-- Meta tags adicionales para Railway --}}
<meta property="og:image" content="{{ asset('favicon.svg') }}">
<meta name="twitter:image" content="{{ asset('favicon.svg') }}">