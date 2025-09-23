{{-- Componente de Contacto basado en diseño de Figma --}}
<section class="contact-section">
    <div class="contact-container">
        {{-- Título principal --}}
        <div class="contact-header">
            <h2 class="contact-title">¿Listo para transformar tu gestión energética?</h2>
        </div>
        
        {{-- Subtítulo --}}
        <div class="contact-subtitle-wrapper">
            <div class="contact-subtitle">
                <p>Hablemos de cómo POWERGYMA puede diseñar una estrategia a la medida de tus objetivos. El primer paso hacia un futuro más eficiente empieza aquí.</p>
            </div>
        </div>
        
        {{-- Contenedor principal del formulario y mapa --}}
        <div class="contact-main-container">
            <div class="contact-form-wrapper">
                {{-- Título del formulario --}}
                <div class="contact-form-header">
                    <h3 class="contact-form-title">Contacta con nosotros</h3>
                </div>
                
                {{-- Contenido: Formulario y información de contacto --}}
                <div class="contact-content">
                    {{-- Formulario --}}
                    <div class="contact-form">
                        <form action="#" method="POST" class="contact-form-fields">
                            @csrf
                            {{-- Fila de nombre y email --}}
                            <div class="form-row">
                                {{-- Campo Nombre --}}
                                <div class="form-field">
                                    <label class="form-label">
                                        <span class="label-text">Nombre</span>
                                        <span class="required-asterisk">*</span>
                                    </label>
                                    <input type="text" name="nombre" class="form-input" placeholder="Tu nombre" required>
                                </div>
                                
                                {{-- Campo Email --}}
                                <div class="form-field">
                                    <label class="form-label">
                                        <span class="label-text">Email</span>
                                        <span class="required-asterisk">*</span>
                                    </label>
                                    <input type="email" name="email" class="form-input" placeholder="tucorreo@ejemplo.com" required>
                                </div>
                            </div>
                            
                            {{-- Campo Asunto --}}
                            <div class="form-field-full">
                                <label class="form-label">
                                    <span class="label-text">Asunto</span>
                                </label>
                                <input type="text" name="asunto" class="form-input" placeholder="¿En qué podemos ayudarte?">
                            </div>
                            
                            {{-- Campo Mensaje --}}
                            <div class="form-field-full">
                                <label class="form-label">
                                    <span class="label-text">Mensaje</span>
                                    <span class="required-asterisk">*</span>
                                </label>
                                <textarea name="mensaje" class="form-textarea" placeholder="Detállanos tu consulta y nos pondremos en contacto contigo lo antes posible" required></textarea>
                            </div>
                            
                            {{-- Botón enviar --}}
                            <div class="form-submit">
                                <button type="submit" class="submit-button">Enviar mensaje</button>
                            </div>
                        </form>
                    </div>
                    
                    {{-- Información de contacto y mapa --}}
                    <div class="contact-info">
                        {{-- Mapa --}}
                        <div class="contact-map" style="padding:0; height:166px;">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1950.1374838478514!2d-76.9955349067459!3d-12.161673684276678!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105b83081fb2da3%3A0xde9e03b556e34384!2sDPTO.%20701%2C%20Av.%20las%20Gaviotas%201805%2C%20Santiago%20de%20Surco%2015054!5e0!3m2!1ses!2spe!4v1758414069512!5m2!1ses!2spe" width="100%" height="150" style="border:0; border-radius:12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        
                        {{-- Información de contacto --}}
                        <div class="contact-details">
                            {{-- Teléfono --}}
                            <div class="contact-item">
                                <div class="contact-icon">
                             <img src="/Img/Ico/icons/contact-phone-icon.svg" 
                                 alt="Teléfono" 
                                 class="icon critical">
                                </div>
                                <div class="contact-text">
                                    <span>+51 946 432 574 / +51 970 894 954</span>
                                </div>
                            </div>
                            
                            {{-- Email --}}
                            <div class="contact-item">
                                <div class="contact-icon">
                             <img src="/Img/Ico/icons/contact-email-icon.svg" 
                                 alt="Email" 
                                 class="icon critical">
                                </div>
                                <div class="contact-text">
                                    <span>info@powergyma.com</span>
                                </div>
                            </div>
                            
                            {{-- Dirección --}}
                            <div class="contact-item">
                                <div class="contact-icon">
                             <img src="/Img/Ico/icons/contact-address-icon.svg" 
                                 alt="Ubicación" 
                                 class="icon critical">
                                </div>
                                <div class="contact-text">
                                    <span>Av. Gaviotas Nro. 1805 Lima - Lima - Santiago De Surco</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
