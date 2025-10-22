<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - POWERGYMA</title>
    
    {{-- Favicon y PWA meta tags --}}
    @include('components.favicon')
    
    <!-- Vite Assets -->
    @vite(['resources/css/main.css', 'resources/css/contacto-figma.css', 'resources/js/main.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header Component -->
    <header id="header">
        @include('components.header')
    </header>

    <!-- Main Content -->
    <main>
        @include('components.contacto-figma')
    </main>

    <footer id="footer">
        @include('components.footer')
    </footer>
</body>
</html>
