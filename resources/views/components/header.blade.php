<!-- Header Component -->
<div class="header-container">
    <div class="logo">
        <img src="assets/icons/7f131e3ebf5d584ec2316a2e8cf8d25184bccec0.svg" alt="PowerGYMA Logo">
    </div>
    
    <nav class="main-nav">
        <ul class="nav-menu">
            <li class="nav-item active">
                <a href="#inicio">Inicio</a>
            </li>
            <li class="nav-item">
                <a href="#servicios">Servicios</a>
            </li>
            <li class="nav-item">
                <a href="#nosotros">Nosotros</a>
            </li>
            <li class="nav-item">
                <a href="#clientes">Clientes</a>
            </li>
            <li class="nav-item">
                <a href="#contacto">Contacto</a>
            </li>
        </ul>
    </nav>
    
    <div class="header-cta">
        <a href="{{ route('login') }}" class="btn btn-access">Acceso Clientes</a>
    </div>
    
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" aria-label="Menú móvil">
        <span></span>
        <span></span>
        <span></span>
    </button>
</div>
