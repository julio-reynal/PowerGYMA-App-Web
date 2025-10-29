<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Mensaje de Contacto</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #FF6B00 0%, #0066FF 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
            margin: -30px -30px 20px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .info-row {
            margin: 15px 0;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        .label {
            font-weight: bold;
            color: #0066FF;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            color: #333;
        }
        .message-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            border-left: 4px solid #FF6B00;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 Nuevo Mensaje de Contacto</h1>
            <p style="margin: 5px 0 0 0; font-size: 14px;">POWERGYMA - Sistema de Contacto</p>
        </div>

        <div class="info-row">
            <span class="label">👤 Nombre Completo:</span>
            <span class="value">{{ $data['fullName'] }}</span>
        </div>

        <div class="info-row">
            <span class="label">🏢 Empresa:</span>
            <span class="value">{{ $data['companyName'] }}</span>
        </div>

        <div class="info-row">
            <span class="label">📧 Correo Electrónico:</span>
            <span class="value"><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></span>
        </div>

        <div class="info-row">
            <span class="label">📞 Teléfono:</span>
            <span class="value">{{ $data['phone'] }}</span>
        </div>

        <div class="info-row">
            <span class="label">🏭 Sector Industrial:</span>
            <span class="value">{{ ucfirst($data['industry']) }}</span>
        </div>

        @if(!empty($data['budget']))
        <div class="info-row">
            <span class="label">💰 Presupuesto Estimado:</span>
            <span class="value">{{ $data['budget'] }}</span>
        </div>
        @endif

        @if(!empty($data['consultType']))
        <div class="info-row">
            <span class="label">💬 Tipo de Consulta Preferida:</span>
            <span class="value">
                @if($data['consultType'] === 'videocall')
                    Videollamada
                @elseif($data['consultType'] === 'presential')
                    Visita presencial
                @elseif($data['consultType'] === 'phone')
                    Llamada telefónica
                @endif
            </span>
        </div>
        @endif

        @if(!empty($data['message']))
        <div class="message-box">
            <span class="label">📝 Mensaje:</span>
            <p class="value" style="margin: 10px 0 0 0; white-space: pre-wrap;">{{ $data['message'] }}</p>
        </div>
        @endif

        <div class="footer">
            <p>Este mensaje fue enviado desde el formulario de contacto de POWERGYMA</p>
            <p>Fecha: {{ date('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
