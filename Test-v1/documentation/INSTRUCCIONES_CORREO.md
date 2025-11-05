# Configuración del Sistema de Envío de Correos - POWERGYMA

## ✅ Archivos Creados

1. **ContactController.php** - Controlador para manejar el envío de correos
2. **contact.blade.php** - Plantilla HTML del correo electrónico
3. **contact-form.js** - JavaScript para el formulario (con validación y mensajes)
4. **Ruta agregada** - `/contacto/enviar` en web.php

## 📋 Pasos para Configurar

### 1. Configurar el archivo `.env`

Abre tu archivo `.env` y configura las siguientes variables de correo:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-correo@gmail.com
MAIL_PASSWORD=tu-contraseña-de-aplicación
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-correo@gmail.com
MAIL_FROM_NAME="POWERGYMA"
```

### 2. Configurar Gmail (si usas Gmail)

Para usar Gmail necesitas generar una **Contraseña de Aplicación**:

1. Ve a tu cuenta de Google: https://myaccount.google.com/
2. Ve a **Seguridad**
3. Activa la **Verificación en 2 pasos** (si no está activada)
4. Busca **Contraseñas de aplicaciones**
5. Genera una nueva contraseña para "Correo"
6. Copia esa contraseña y úsala en `MAIL_PASSWORD` del `.env`

### 3. Otras Opciones de Correo

#### Usando Mailtrap (para pruebas)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=tu-username-mailtrap
MAIL_PASSWORD=tu-password-mailtrap
MAIL_ENCRYPTION=tls
```

#### Usando SendGrid
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=tu-api-key-de-sendgrid
MAIL_ENCRYPTION=tls
```

#### Usando Mailgun
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=tu-username@tu-dominio.mailgun.org
MAIL_PASSWORD=tu-password-mailgun
MAIL_ENCRYPTION=tls
```

### 4. Compilar los Assets

Ejecuta el siguiente comando para compilar el JavaScript:

```bash
npm run dev
```

O para producción:

```bash
npm run build
```

### 5. Cambiar el Correo de Destino

En el archivo `ContactController.php`, línea 44, cambia el correo donde quieres recibir los mensajes:

```php
$message->to('info@powergyma.com') // Cambia este correo
```

### 6. Probar el Formulario

1. Abre tu sitio web en el navegador
2. Ve a la sección de contacto
3. Llena el formulario
4. Haz clic en "Solicitar una Consulta"
5. Deberías ver un mensaje de éxito verde
6. Revisa tu correo electrónico

## 🔍 Solución de Problemas

### Error: "Connection could not be established"

**Solución**: Verifica que:
- Las credenciales del `.env` sean correctas
- El puerto no esté bloqueado por firewall
- Si usas Gmail, hayas generado la contraseña de aplicación

### Error: "Address in mailbox given does not comply"

**Solución**: Verifica que `MAIL_FROM_ADDRESS` sea un correo válido

### El formulario no envía

**Solución**: 
1. Abre la consola del navegador (F12)
2. Revisa si hay errores de JavaScript
3. Verifica que el archivo `contact-form.js` se esté cargando

### Los correos van a spam

**Solución**:
- Usa un servicio profesional como SendGrid o Mailgun
- Configura SPF y DKIM en tu dominio
- Evita palabras como "gratis", "oferta" en el asunto

## 📧 Personalización del Correo

Para personalizar la plantilla del correo, edita:
```
resources/views/emails/contact.blade.php
```

## 🎨 Personalización de Mensajes

Para cambiar los mensajes de validación, edita:
```
app/Http/Controllers/ContactController.php
```

En el array de mensajes personalizados (líneas 23-30)

## 📝 Campos del Formulario

Los siguientes campos se envían:
- ✅ Nombre completo (obligatorio)
- ✅ Nombre de la empresa (obligatorio)
- ✅ Correo electrónico (obligatorio)
- ✅ Teléfono (obligatorio)
- ✅ Sector industrial (obligatorio)
- ⭕ Presupuesto estimado (opcional)
- ⭕ Mensaje (opcional)
- ⭕ Tipo de consulta (opcional)
- ✅ Aceptación de política de privacidad (obligatorio)

## 🚀 Comando Rápido para Probar

Ejecuta esto en tu terminal para probar el envío de correos:

```bash
php artisan tinker
```

Luego ejecuta:

```php
Mail::raw('Correo de prueba', function ($message) {
    $message->to('tu-correo@example.com')
            ->subject('Prueba de correo');
});
```

Si esto funciona, tu configuración de correo está correcta.

---

## ✨ ¡Listo!

Una vez configurado todo, el formulario de contacto enviará correos automáticamente al correo que hayas especificado.
