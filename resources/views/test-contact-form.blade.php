<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Formulario de Contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .message {
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .checkbox-group input {
            width: auto;
        }
    </style>
</head>
<body>
    <h1>Test Formulario de Contacto</h1>
    <div id="messages"></div>
    
    <form id="testForm">
        @csrf
        
        <div class="form-group">
            <label>Nombre completo *</label>
            <input type="text" name="fullName" required value="Juan Pérez">
        </div>
        
        <div class="form-group">
            <label>Empresa *</label>
            <input type="text" name="companyName" required value="Test Company">
        </div>
        
        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" required value="test@example.com">
        </div>
        
        <div class="form-group">
            <label>Teléfono *</label>
            <input type="tel" name="phone" required value="999888777">
        </div>
        
        <div class="form-group">
            <label>Sector Industrial *</label>
            <select name="industry" required>
                <option value="">Seleccionar...</option>
                <option value="manufacturera">Manufacturera</option>
                <option value="alimentaria">Alimentaria</option>
                <option value="quimica" selected>Química</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Presupuesto</label>
            <input type="text" name="budget" value="50000">
        </div>
        
        <div class="form-group">
            <label>Mensaje</label>
            <textarea name="message" rows="4">Mensaje de prueba del formulario de contacto</textarea>
        </div>
        
        <div class="form-group">
            <label>Tipo de consulta</label>
            <div>
                <label><input type="radio" name="consultType" value="videocall" checked> Videollamada</label>
                <label><input type="radio" name="consultType" value="presential"> Presencial</label>
                <label><input type="radio" name="consultType" value="phone"> Teléfono</label>
            </div>
        </div>
        
        <div class="form-group checkbox-group">
            <input type="checkbox" name="privacyPolicy" value="1" id="privacy" required>
            <label for="privacy">He leído y acepto la política de privacidad *</label>
        </div>
        
        <button type="submit" id="submitBtn">Enviar Formulario de Prueba</button>
    </form>
    
    <script>
        document.getElementById('testForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const messagesDiv = document.getElementById('messages');
            const submitBtn = document.getElementById('submitBtn');
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Enviando...';
            messagesDiv.innerHTML = '';
            
            const formData = new FormData(this);
            
            console.log('=== DATOS DEL FORMULARIO ===');
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }
            
            try {
                const response = await fetch('/contacto/enviar', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                console.log('Status:', response.status);
                const data = await response.json();
                console.log('Response:', data);
                
                if (response.ok && data.success) {
                    messagesDiv.innerHTML = `
                        <div class="message success">
                            <strong>✅ ¡Éxito!</strong><br>
                            ${data.message}
                        </div>
                    `;
                    this.reset();
                } else {
                    let errorHtml = '<div class="message error"><strong>❌ Errores:</strong><ul>';
                    if (data.errors) {
                        for (let [field, errors] of Object.entries(data.errors)) {
                            errorHtml += `<li><strong>${field}:</strong> ${errors.join(', ')}</li>`;
                        }
                    } else {
                        errorHtml += `<li>${data.message || 'Error desconocido'}</li>`;
                    }
                    errorHtml += '</ul></div>';
                    messagesDiv.innerHTML = errorHtml;
                }
            } catch (error) {
                console.error('Error:', error);
                messagesDiv.innerHTML = `
                    <div class="message error">
                        <strong>❌ Error de conexión</strong><br>
                        ${error.message}
                    </div>
                `;
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Enviar Formulario de Prueba';
            }
        });
    </script>
</body>
</html>
