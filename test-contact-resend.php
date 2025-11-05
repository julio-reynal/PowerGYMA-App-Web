<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

echo "🚀 Probando formulario de contacto con Resend optimizado...\n\n";

// Datos de prueba del formulario
$testData = [
    'fullName' => 'Juan Pérez Test',
    'companyName' => 'Empresa Test S.A.',
    'email' => 'test@example.com',
    'phone' => '+51 999 888 777',
    'industry' => 'manufactura',
    'budget' => '$10,000 - $50,000',
    'message' => 'Este es un mensaje de prueba desde el formulario de contacto. Estamos interesados en conocer más sobre sus servicios.',
    'consultType' => 'videocall',
    'privacyPolicy' => true,
];

echo "📋 Datos del contacto:\n";
echo "   Nombre: {$testData['fullName']}\n";
echo "   Empresa: {$testData['companyName']}\n";
echo "   Email: {$testData['email']}\n";
echo "   Teléfono: {$testData['phone']}\n";
echo "   Industria: {$testData['industry']}\n\n";

try {
    echo "📧 Configuración Resend:\n";
    echo "   Mailer: " . config('mail.default') . "\n";
    echo "   From: " . config('mail.from.address') . "\n";
    echo "   From Name: " . config('mail.from.name') . "\n";
    echo "   To: " . env('CONTACT_EMAIL') . "\n\n";
    
    echo "🚀 Enviando email...\n";
    
    // Enviar usando el Mailable optimizado
    Mail::to(env('CONTACT_EMAIL', 'infopowergyma@gmail.com'))
        ->send(new ContactFormMail($testData));
    
    echo "\n✅ ¡EMAIL ENVIADO EXITOSAMENTE VÍA RESEND!\n\n";
    echo "📊 Características de Resend utilizadas:\n";
    echo "   ✓ Tags: contact-form, website, powergyma\n";
    echo "   ✓ Metadata: company, industry, source\n";
    echo "   ✓ Reply-To: {$testData['email']}\n";
    echo "   ✓ HTML Template: emails.contact\n\n";
    
    echo "📧 Revisa tu bandeja: " . env('CONTACT_EMAIL') . "\n";
    echo "📊 Dashboard de Resend: https://resend.com/emails\n\n";
    
    echo "💡 En el dashboard podrás ver:\n";
    echo "   • Estado del envío (delivered, bounced, etc.)\n";
    echo "   • Tags aplicados (contact-form, website, powergyma)\n";
    echo "   • Metadata (company, industry, source)\n";
    echo "   • Tiempo de entrega\n";
    echo "   • Aperturas y clicks (si activas tracking)\n\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERROR al enviar: " . $e->getMessage() . "\n";
    echo "📝 Archivo: " . $e->getFile() . "\n";
    echo "📝 Línea: " . $e->getLine() . "\n\n";
    echo "🔍 Verifica:\n";
    echo "   1. API Key en .env: RESEND_API_KEY\n";
    echo "   2. Email remitente: MAIL_FROM_ADDRESS (debe ser dominio verificado)\n";
    echo "   3. Email destinatario: CONTACT_EMAIL\n";
}
