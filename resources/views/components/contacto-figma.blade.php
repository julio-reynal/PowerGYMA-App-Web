{{-- Componente de Contacto - Diseño Figma Exacto --}}
<section class="contact-section-figma-new" data-node-id="679-568">
    <div class="contact-container-new">
        {{-- Título principal --}}
        <div class="contact-header-new">
            <h1 class="contact-title-new">¿Listo para transformar tu gestión energética?</h1>
        </div>
        
        {{-- Subtítulo --}}
        <div class="contact-subtitle-wrapper-new">
            <p class="contact-subtitle-new">Hablemos de cómo POWERGYMA puede diseñar una estrategia a la medida de tus objetivos. El primer paso hacia un futuro más eficiente empieza aquí.</p>
        </div>
        
        {{-- Contenedor principal del formulario --}}
        <div class="contact-main-box">
            <div class="contact-box-wrapper">
                {{-- Título del formulario --}}
                <div class="contact-form-title-wrapper">
                    <h3 class="contact-form-title-new">Contacta con nosotros</h3>
                </div>
                
                {{-- Grid de 2 columnas: Formulario e Información --}}
                <div class="contact-grid-two-columns">
                    {{-- Columna 1: Formulario --}}
                    <div class="contact-form-column">
                        <form action="#" method="POST" class="contact-form-new">
                            @csrf
                            {{-- Fila: Nombre y Email --}}
                            <div class="form-row-new">
                                <div class="form-field-new">
                                    <label class="form-label-new">
                                        <span class="label-text-new">Nombre</span>
                                        <span class="asterisk-new">*</span>
                                    </label>
                                    <input type="text" name="nombre" class="form-input-new" placeholder="Tu nombre" required>
                                </div>
                                
                                <div class="form-field-new">
                                    <label class="form-label-new">
                                        <span class="label-text-new">Email</span>
                                        <span class="asterisk-new">*</span>
                                    </label>
                                    <input type="email" name="email" class="form-input-new" placeholder="tucorreo@ejemplo.com" required>
                                </div>
                            </div>
                            
                            {{-- Campo Asunto --}}
                            <div class="form-field-full-new">
                                <label class="form-label-new">
                                    <span class="label-text-new">Asunto</span>
                                </label>
                                <input type="text" name="asunto" class="form-input-new" placeholder="¿En qué podemos ayudarte?">
                            </div>
                            
                            {{-- Campo Mensaje --}}
                            <div class="form-field-full-new form-field-textarea">
                                <label class="form-label-new">
                                    <span class="label-text-new">Mensaje</span>
                                    <span class="asterisk-new">*</span>
                                </label>
                                <textarea name="mensaje" class="form-textarea-new" placeholder="Detállanos tu consulta y nos pondremos en contacto contigo lo antes posible" required></textarea>
                            </div>
                            
                            {{-- Botón enviar --}}
                            <div class="form-button-wrapper">
                                <button type="submit" class="submit-button-new">Enviar mensaje</button>
                            </div>
                        </form>
                    </div>
                    
                    {{-- Columna 2: Mapa e Información --}}
                    <div class="contact-info-column">
                        {{-- Mapa --}}
                        <div class="map-wrapper-new">
                            <div class="map-inner-new">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d1378.956052933266!2d-76.99582709033639!3d-12.16155331036798!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1s%20AV.%20GAVIOTAS%20NRO.%201805%20DPTO.%20701%20INT.!5e0!3m2!1ses!2spe!4v1758309380370!5m2!1ses!2spe" 
                                        width="100%" 
                                        height="100%" 
                                        style="border:0; border-radius:12px;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                        
                        {{-- Información de contacto --}}
                        <div class="contact-info-box">
                            {{-- Teléfono --}}
                            <div class="contact-info-item">
                                <div class="contact-icon-new">
                                    <img src="{{ asset('Img/Ico/icons/contact-phone-icon.svg') }}" alt="Teléfono">
                                </div>
                                <span class="contact-text-new">+51 946 432 574 / +51 970 894 954</span>
                            </div>
                            
                            {{-- Email --}}
                            <div class="contact-info-item">
                                <div class="contact-icon-new">
                                    <img src="{{ asset('Img/Ico/icons/contact-email-icon.svg') }}" alt="Email">
                                </div>
                                <span class="contact-text-new">info@powergyma.com</span>
                            </div>
                            
                            {{-- Dirección --}}
                            <div class="contact-info-item contact-info-item-address">
                                <div class="contact-icon-new contact-icon-address">
                                    <img src="{{ asset('Img/Ico/icons/contact-address-icon.svg') }}" alt="Ubicación">
                                </div>
                                <span class="contact-text-new contact-text-address">Av. Gaviotas Nro. 1805, Lima - Lima - Santiago De Surco</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
