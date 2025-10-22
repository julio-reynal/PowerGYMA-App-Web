<!-- Header Component -->
<header>
    <div class="header-container">
        <div class="logo">
            <img src="{{ asset('Img/Ico/icons/7f131e3ebf5d584ec2316a2e8cf8d25184bccec0.svg') }}" alt="PowerGYMA Logo">
        </div>
        
        <nav class="main-nav">
            <ul class="nav-menu">
                <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                    <a href="{{ url('/') }}">Inicio</a>
                </li>
                <li class="nav-item {{ Request::is('servicios*') ? 'active' : '' }}">
                    <a href="{{ route('servicios') }}">Servicios</a>
                </li>
                <li class="nav-item {{ Request::is('clientes*') ? 'active' : '' }}">
                    <a href="{{ route('clientes') }}">Clientes</a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/') }}#contactanos">Contacto</a>
                </li>
            </ul>
        </nav>
        
        <div class="header-cta">
            <a href="{{ url('/login') }}" class="btn btn-access">Acceso Clientes</a>
        </div>
        
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" aria-label="Menú móvil">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
