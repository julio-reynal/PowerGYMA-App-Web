@extends('layouts.clientes')

@section('title', 'Casos de Éxito - PowerGYMA')

@push('styles')
    @vite(['resources/css/components.css', 'resources/css/clientes.css'])
@endpush

@section('content')
<!-- Header Component -->
@include('components.header')

<div class="clientes-container">
    <!-- Sección Hero -->
    <section class="hero-section">
        <div class="hero-background">
            <div class="hero-overlay"></div>
            <div class="hero-pattern"></div>
        </div>
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Nuestros Casos de Éxito</h1>
                <p class="hero-description">
                    Descubre cómo hemos transformado la gestión energética de empresas líderes con soluciones innovadoras y resultados medibles
                </p>
            </div>
        </div>
    </section>

    <!-- Sección de Casos de Éxito -->
    <section class="casos-section">
        <div class="casos-grid">
            @foreach($casosExito as $caso)
            <div class="caso-card">
                <div class="caso-header">
                    <div class="caso-info">
                        <span class="caso-sector">{{ $caso['sector'] }}</span>
                        <h3 class="caso-titulo">{{ $caso['titulo'] }}</h3>
                    </div>
                    @if($caso['logo_cliente'])
                    <div class="caso-logo">
                        <img src="{{ asset('Img/' . $caso['logo_cliente']) }}" alt="Logo cliente">
                    </div>
                    @endif
                </div>

                <!-- El Desafío -->
                <div class="caso-bloque desafio-bloque">
                    <div class="bloque-header">
                        <div class="bloque-icon">
                            <img src="{{ asset('Img/971e2994d9beae8af8957afc10fd569fe7553926.svg') }}" alt="Desafío" class="critical">
                        </div>
                        <h4 class="bloque-titulo">El Desafío</h4>
                    </div>
                    <p class="bloque-texto">{{ $caso['desafio'] }}</p>
                </div>

                <!-- La Solución -->
                <div class="caso-bloque solucion-bloque">
                    <div class="solucion-borde"></div>
                    <div class="bloque-header">
                        <div class="bloque-icon">
                            <img src="{{ asset('Img/bfe4745b428cc271205b230a2545a9bb0dc21460.svg') }}" alt="Solución" class="critical">
                        </div>
                        <h4 class="bloque-titulo">La Solución POWERGYMA</h4>
                    </div>
                    <p class="bloque-texto">{{ $caso['solucion'] }}</p>
                </div>

                <!-- Los Resultados -->
                <div class="caso-bloque resultados-bloque">
                    <div class="bloque-header">
                        <div class="bloque-icon">
                            <img src="{{ asset('Img/ee49ee71b0f8cc1a076e2aff38e18b53e671b07a.svg') }}" alt="Resultados" class="critical">
                        </div>
                        <h4 class="bloque-titulo">Los Resultados</h4>
                    </div>
                    
                    <div class="resultados-content">
                        <div class="resultados-info">
                            <p class="resultado-descripcion">{{ $caso['resultado_descripcion'] }}</p>
                            
                            <div class="resultados-metricas">
                                <div class="metrica">
                                    <div class="metrica-valor">{{ $caso['resultado_porcentaje'] }}</div>
                                    <div class="metrica-label">{{ $caso['resultado_texto'] }}</div>
                                </div>
                                <div class="metrica">
                                    <div class="metrica-valor">{{ $caso['resultado_monto'] }}</div>
                                    <div class="metrica-label">{{ $caso['resultado_monto_texto'] }}</div>
                                </div>
                                @if(isset($caso['resultado_extra']))
                                <div class="metrica">
                                    <div class="metrica-valor">{{ $caso['resultado_extra'] }}</div>
                                    <div class="metrica-label">{{ $caso['resultado_extra_texto'] }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="resultado-circular">
                            <div class="circular-progress" data-percentage="{{ str_replace(['%', '-'], '', $caso['resultado_circular']) }}">
                                <div class="circular-bg"></div>
                                <div class="circular-fill"></div>
                                <div class="circular-text">{{ $caso['resultado_circular'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Sección de Resultados Comprobables -->
    <section class="resultados-section">
        <div class="resultados-container">
            <div class="resultados-info">
                <h2 class="resultados-titulo">Resultados comprobables</h2>
                <p class="resultados-descripcion">
                    Nuestros clientes experimentan una clara reducción en sus costos energéticos, con soluciones personalizadas que garantizan resultados medibles y duraderos.
                </p>
                <div class="estadisticas-generales">
                    <div class="estadistica">
                        <div class="estadistica-valor">{{ $estadisticas['ahorro_promedio'] }}</div>
                        <div class="estadistica-label">ahorro promedio</div>
                    </div>
                    <div class="estadistica">
                        <div class="estadistica-valor">{{ $estadisticas['empresas_confian'] }}</div>
                        <div class="estadistica-label">empresas confían en nosotros</div>
                    </div>
                </div>
            </div>
            <div class="resultados-imagen">
                <img src="{{ asset('Img/2c2d2909db7fbe751e87f40fffea033415244ff7.png') }}" alt="Sistema POWERGYMA" class="critical">
            </div>
        </div>
    </section>

    <!-- Sección de Testimonios -->
    <section class="testimonios-section">
        @if(count($testimonios) > 0)
        <div class="testimonio-container">
            <div class="testimonio-quote">"</div>
            <blockquote class="testimonio-texto">
                {{ $testimonios[0]['texto'] }}
            </blockquote>
            <cite class="testimonio-autor">{{ $testimonios[0]['autor'] }}</cite>
            @if($testimonios[0]['logo'])
            <div class="testimonio-logo">
                <img src="{{ asset('Img/' . $testimonios[0]['logo']) }}" alt="{{ $testimonios[0]['empresa'] }}" class="critical">
            </div>
            @endif
        </div>
        @endif
    </section>

    <!-- Sección Call to Action -->
    <section class="cta-section">
        <div class="cta-container">
            <div class="cta-content">
                <h2 class="cta-titulo">¿Quieres ser nuestro próximo caso de éxito?</h2>
                <p class="cta-descripcion">
                    Descubre cómo nuestras soluciones de gestión energética pueden transformar tu empresa y reducir significativamente tus costes operativos.
                </p>
                <a href="#" class="cta-button">
                    Solicitar Consulta Gratuita
                    <img src="{{ asset('Img/c0b5440a65fd21a0aa828a6b90d9b46701d40523.svg') }}" alt="Arrow" class="critical">
                </a>
            </div>
            
            <!-- Beneficios -->
            <div class="beneficios-grid">
                <div class="decoracion-izq">
                    <img src="{{ asset('Img/3dcddb6b0c407a862277f3220f8086548963b7dc.svg') }}" alt="Decoración" class="critical">
                </div>
                <div class="decoracion-der">
                    <img src="{{ asset('Img/ae6b43449b697d0e964c140b331692a7f27027b8.svg') }}" alt="Decoración" class="critical">
                </div>
                
                @foreach($beneficios as $beneficio)
                <div class="beneficio-card">
                    <div class="beneficio-icon">
                        <img src="{{ asset('Img/' . $beneficio['icono']) }}" alt="{{ $beneficio['titulo'] }}" class="critical">
                    </div>
                    <h4 class="beneficio-titulo">{{ $beneficio['titulo'] }}</h4>
                    <p class="beneficio-descripcion">{{ $beneficio['descripcion'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

<!-- Contact Section -->
<section id="contactanos" class="contact-section-figma">
    <div class="contact-container">
        <div class="contact-content">
            <!-- Contact Header -->
            <div class="contact-header">
                <div class="contact-badge">
                    <span>Contáctanos</span>
                </div>
                <h1 class="contact-title">¿Listo para transformar tu gestión energética?</h1>
                <p class="contact-subtitle">Hablemos de cómo POWERGYMA puede diseñar una estrategia a la medida de tus objetivos. El primer paso hacia un futuro más eficiente empieza aquí.</p>
            </div>
            
            <!-- Main Content Grid -->
            <div class="contact-main-grid">
                <!-- Contact Form Container -->
                <div class="contact-form-container">
                    <form class="contact-form-figma">
                        <!-- First Row -->
                        <div class="form-row">
                            <div class="form-group">
                                <label>
                                    <img src="assets/icons/165f92fcd0a7cd05d67278e28a9b9f703b245b84.svg" alt="user">
                                    Nombre completo
                                </label>
                                <div class="input-wrapper">
                                    <input type="text" placeholder="Tu nombre y apellidos" name="fullName" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>
                                    <img src="assets/icons/6e90d1375acabd6e696db24dc9f3754aabd5e7eb.svg" alt="company">
                                    Nombre de la Empresa
                                </label>
                                <div class="input-wrapper">
                                    <input type="text" placeholder="Nombre de tu empresa" name="companyName" required>
                                </div>
                            </div>
                        </div>

                        <!-- Second Row -->
                        <div class="form-row">
                            <div class="form-group">
                                <label>
                                    <img src="assets/icons/a15e2de8f4a6a51c4059c293374e092d0fcf384e.svg" alt="email">
                                    Correo Electrónico
                                </label>
                                <div class="input-wrapper">
                                    <input type="email" placeholder="ejemplo@empresa.com" name="email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>
                                    <img src="assets/icons/3b1908e4ca3063f5f1bac73863f5e4441fdb1bf7.svg" alt="phone">
                                    Teléfono
                                </label>
                                <div class="input-wrapper">
                                    <input type="tel" placeholder="+34 600 000 000" name="phone" required>
                                </div>
                            </div>
                        </div>

                        <!-- Third Row -->
                        <div class="form-row">
                            <div class="form-group">
                                <label>
                                    <img src="assets/icons/6e90d1375acabd6e696db24dc9f3754aabd5e7eb.svg" alt="industry">
                                    Sector Industrial
                                </label>
                                <div class="select-wrapper">
                                    <select name="industry" required>
                                        <option value="">empresa</option>
                                        <option value="manufacturera">Manufacturera</option>
                                        <option value="alimentaria">Alimentaria</option>
                                        <option value="quimica">Química</option>
                                        <option value="textil">Textil</option>
                                        <option value="automocion">Automoción</option>
                                        <option value="construccion">Construcción</option>
                                        <option value="energia">Energía</option>
                                        <option value="otros">Otros</option>
                                    </select>
                                    <img src="assets/icons/fcd593075edbfd7b47ef7f3777600b10998212d5.svg" alt="arrow" class="select-arrow">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>
                                    <img src="assets/icons/1baed7c5c463ef657db5862136dd31ce3f5101a5.svg" alt="budget">
                                    Presupuesto Estimado
                                </label>
                                <div class="input-wrapper">
                                    <input type="text" placeholder="9999999999" name="budget">
                                </div>
                            </div>
                        </div>

                        <!-- Textarea Group -->
                        <div class="textarea-group">
                            <label>
                                <img src="assets/icons/a15e2de8f4a6a51c4059c293374e092d0fcf384e.svg" alt="message">
                                ¿En qué podemos ayudarte?
                            </label>
                            <div class="textarea-wrapper">
                                <textarea placeholder="Describe brevemente tu proyecto o necesidad..." name="message" rows="4"></textarea>
                            </div>
                        </div>

                        <!-- Radio Group -->
                        <div class="radio-group">
                            <div class="radio-label">Tipo de consulta preferida:</div>
                            <div class="radio-options">
                                <label class="radio-option">
                                    <input type="radio" name="consultType" value="videocall">
                                    <span class="radio-custom"></span>
                                    <img src="assets/icons/01f3c469e1028b0743bbe547d3191d318bc2bcaa.svg" alt="videocall">
                                    Videollamada
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="consultType" value="presential">
                                    <span class="radio-custom"></span>
                                    <img src="assets/icons/2dec80535915fd2395827d4f24332008ffa94525.svg" alt="visit">
                                    Visita presencial
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="consultType" value="phone">
                                    <span class="radio-custom"></span>
                                    <img src="assets/icons/3b1908e4ca3063f5f1bac73863f5e4441fdb1bf7.svg" alt="phone">
                                    Llamada telefónica
                                </label>
                            </div>
                        </div>

                        <!-- Checkbox Group -->
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="privacyPolicy" required>
                                <span class="checkbox-custom"></span>
                                He leído y acepto la política de privacidad y el tratamiento de mis datos
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="submit-container">
                            <button type="submit" class="submit-btn-figma">
                                Solicitar una Consulta
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Contact Info Sidebar -->
                <div class="contact-info-sidebar">
                <!-- Map Container -->
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d1378.956052933266!2d-76.99582709033639!3d-12.16155331036798!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1s%20AV.%20GAVIOTAS%20NRO.%201805%20DPTO.%20701%20INT.!5e0!3m2!1ses!2spe!4v1758309380370!5m2!1ses!2spe" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                    <!-- Contact Details Section -->
                    <div class="contact-details-section">
                        <h2 class="contact-details-title">Información de contacto</h2>
                        
                        <div class="contact-details-list">
                            <div class="contact-detail-item">
                                <div class="contact-icon-container">
                                    <img src="assets/icons/64a712fd2c9ea22db909b60876b8e68608bdaf56.svg" alt="phone">
                                </div>
                                <div class="contact-detail-content">
                                    <p class="contact-detail-title">Teléfono</p>
                                    <p class="contact-detail-text">+51 946 432 574 / +51 970 894 954</p>
                                </div>
                            </div>

                            <div class="contact-detail-item">
                                <div class="contact-icon-container">
                                    <img src="assets/icons/22c50f6a1746dac5e71615d864b78c4fc2dfa597.svg" alt="email">
                                </div>
                                <div class="contact-detail-content">
                                    <p class="contact-detail-title">Correo Electrónico</p>
                                    <p class="contact-detail-text">info@powergyma.com</p>
                                </div>
                            </div>

                            <div class="contact-detail-item large">
                                <div class="contact-icon-container">
                                    <img src="assets/icons/b8076a3af624703032b9ad11661685bca69a1bf0.svg" alt="address">
                                </div>
                                <div class="contact-detail-content">
                                    <p class="contact-detail-title">Dirección</p>
                                    <p class="contact-detail-text">AV. GAVIOTAS NRO. 1805<br> LIMA - LIMA - SANTIAGO DE SURCO</p>
                                </div>
                            </div>

                            <div class="contact-detail-item large">
                                <div class="contact-icon-container">
                                    <img src="assets/icons/a3a52c7d2408c1916625d9895ddab09f141fb5a0.svg" alt="hours">
                                </div>
                                <div class="contact-detail-content">
                                    <p class="contact-detail-title">Horario de Atención</p>
                                    <p class="contact-detail-text">Lun - Vie: 9:00 - 18:00<br>Sábados: 10:00 - 14:00</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Icons -->
                        <div class="contact-social-iconsaa">
                            <a href="https://www.facebook.com/people/Power-GYMA/61581443061373/" target="_blank" class="social-icon-f">
                                <img src="assets/icons/1c82bff56120f7a8612dd55bfe910c82f150186e.svg" alt="Facebook">
                            </a>
                            <a href="https://www.linkedin.com/company/power-gyma/about/" target="_blank" class="social-icon-f">
                                <img src="assets/icons/a0ab1de4c5e1466b7919a577eb8162580d2d4c1e.svg" alt="LinkedIn">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gradient Divider -->
    <div class="contact-gradient-divider"></div>
</section>

<!-- Footer Component -->
@include('components.footer')

@endsection

@push('scripts')
    @vite(['resources/js/components.js', 'resources/js/clientes.js'])
@endpush