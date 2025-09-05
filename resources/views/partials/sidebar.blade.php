@php($isCliente = request()->routeIs('cliente.*'))
@php($isDemo = request()->routeIs('demo.*'))
<nav role="navigation" aria-label="Navegación lateral">
  @if($isCliente)
    <div style="margin-bottom:10px;font-weight:700;color:var(--text-muted);">Cliente</div>
    <ul class="nav">
      <li><a class="{{ request()->routeIs('cliente.dashboard') ? 'active' : '' }}" href="{{ route('cliente.dashboard') }}" @if(request()->routeIs('cliente.dashboard')) aria-current="page" @endif>Dashboard</a></li>
      <li><a class="{{ request()->routeIs('cliente.reportes*') ? 'active' : '' }}" href="{{ route('cliente.reportes') }}" @if(request()->routeIs('cliente.reportes*')) aria-current="page" @endif>Reportes</a></li>
      <li><a class="{{ request()->routeIs('cliente.dashboard.export') ? 'active' : '' }}" href="{{ route('cliente.dashboard.export') }}" @if(request()->routeIs('cliente.dashboard.export')) aria-current="page" @endif>Exportar PDF</a></li>
      <li><a class="{{ request()->routeIs('cliente.instalaciones') ? 'active' : '' }}" href="{{ route('cliente.instalaciones') }}" @if(request()->routeIs('cliente.instalaciones')) aria-current="page" @endif>Instalaciones</a></li>
      <li><a class="{{ request()->routeIs('cliente.planes') ? 'active' : '' }}" href="{{ route('cliente.planes') }}" @if(request()->routeIs('cliente.planes')) aria-current="page" @endif>Planes</a></li>
      <li><a class="{{ request()->routeIs('cliente.reservas') ? 'active' : '' }}" href="{{ route('cliente.reservas') }}" @if(request()->routeIs('cliente.reservas')) aria-current="page" @endif>Reservas</a></li>
      <li><a class="{{ request()->routeIs('cliente.entrenamientos') ? 'active' : '' }}" href="{{ route('cliente.entrenamientos') }}" @if(request()->routeIs('cliente.entrenamientos')) aria-current="page" @endif>Entrenamientos</a></li>
    </ul>
  @elseif($isDemo)
    <div style="margin-bottom:10px;font-weight:700;color:var(--text-muted);">Demo</div>
    <ul class="nav">
      <li><a class="{{ request()->routeIs('demo.dashboard') ? 'active' : '' }}" href="{{ route('demo.dashboard') }}" @if(request()->routeIs('demo.dashboard')) aria-current="page" @endif>Dashboard Demo</a></li>
      <li><a class="{{ request()->routeIs('demo.info') ? 'active' : '' }}" href="{{ route('demo.info') }}" @if(request()->routeIs('demo.info')) aria-current="page" @endif>Información</a></li>
    </ul>
  @else
    <div style="margin-bottom:10px;font-weight:700;color:var(--text-muted);">General</div>
    <ul class="nav">
      @if(Route::has('dashboard'))
        <li><a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" @if(request()->routeIs('dashboard')) aria-current="page" @endif>Dashboard</a></li>
      @endif
      @if(Route::has('cliente.dashboard'))
        <li><a href="{{ route('cliente.dashboard') }}" @if(request()->routeIs('cliente.dashboard')) aria-current="page" @endif>Cliente</a></li>
      @endif
      @if(Route::has('demo.dashboard'))
        <li><a href="{{ route('demo.dashboard') }}" @if(request()->routeIs('demo.dashboard')) aria-current="page" @endif>Demo</a></li>
      @endif
    </ul>
  @endif
</nav>
