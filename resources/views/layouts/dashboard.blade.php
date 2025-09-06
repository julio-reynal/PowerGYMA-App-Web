<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, viewport-fit=cover" />
  <meta name="format-detection" content="telephone=no" />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />
  <meta name="theme-color" content="#111827" />
  <title>@yield('title', 'Dashboard - Power GYMA')</title>
  @vite(['resources/css/dashboard.css', 'resources/js/chart-theme.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  @stack('head')
</head>
<body class="app">
  <a href="#main-content" class="skip-link">Saltar al contenido principal</a>
  <div class="layout">
    <aside class="sidebar" role="complementary" aria-label="Barra lateral">
      @include('partials.sidebar')
    </aside>
    <div style="display:flex;flex-direction:column;min-height:100vh;">
      <header class="topbar" role="banner" aria-label="Barra superior">
        @include('partials.topbar')
      </header>
      <main id="main-content" class="content" role="main" tabindex="-1" aria-label="Contenido principal">
        @yield('content')
      </main>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <script>
    (function () {
      const main = document.getElementById('main-content');
      if (!main) return;
      if (location.hash === '#main-content') {
        main.focus();
      }
      const skip = document.querySelector('.skip-link');
      if (skip) {
        skip.addEventListener('click', function () {
          setTimeout(() => main.focus(), 0);
        });
      }
    })();
  </script>
  @stack('scripts')
</body>
</html>
