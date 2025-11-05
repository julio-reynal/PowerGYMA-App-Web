<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

echo "🚀 Probando envío con Resend...\n\n";

try {
    Mail::raw('✅ hola de prueba powergyma ', function ($message) {
        $message->to('infopowergyma@gmail.com')
                ->subject('🎯 Test Resend prueba para optimizacion - PowerGYMA (desde dev@powergyma.com)')
                ->replyTo('infopowergyma@gmail.com');
    });
    
    echo "✅ EMAIL ENVIADO EXITOSAMENTE!\n";
    echo "📧 Remitente: dev@powergyma.com\n";
    echo "📧 Destinatario: infopowergyma@gmail.com\n";
    echo "📊 Ver envíos en: https://resend.com/emails\n\n";
    
} catch (\Exception $e) {
    echo "❌ ERROR al enviar: " . $e->getMessage() . "\n";
    echo "📝 Detalles: " . $e->getFile() . " línea " . $e->getLine() . "\n";
}
