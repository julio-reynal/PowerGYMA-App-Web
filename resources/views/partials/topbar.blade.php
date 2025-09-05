@php($user = Auth::user())
<div style="display:flex;align-items:center;gap:12px;width:100%;">
  <div style="display:flex;align-items:center;gap:10px;">
    <div class="logo">Power GYMA</div>
    <span class="text-muted" style="font-size:.95rem;">@yield('title', 'Dashboard')</span>
  </div>
  <div style="margin-left:auto;display:flex;align-items:center;gap:10px;">
    <nav aria-label="Acciones de la barra superior">
      <div style="display:flex;align-items:center;gap:10px;">@yield('topbar-actions')</div>
    </nav>
    @auth
      <span class="text-muted">{{ $user->name }}</span>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="btn">Cerrar Sesión</button>
      </form>
      <a href="{{ route('logout.get') }}" class="btn" title="Salir (GET)">Salir</a>
    @endauth
  </div>
</div>
