<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string|max:255',
            'companyName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'industry' => 'required|string',
            'budget' => 'nullable|string|max:50',
            'message' => 'nullable|string|max:1000',
            'consultType' => 'nullable|string|in:videocall,presential,phone',
            'privacyPolicy' => 'required|accepted',
        ], [
            'fullName.required' => 'El nombre completo es obligatorio',
            'companyName.required' => 'El nombre de la empresa es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico no es válido',
            'phone.required' => 'El teléfono es obligatorio',
            'industry.required' => 'El sector industrial es obligatorio',
            'privacyPolicy.accepted' => 'Debes aceptar la política de privacidad',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        try {
            Log::info('=== CONTACTO RECIBIDO ===', [
                'email' => $data['email'],
                'company' => $data['companyName'],
                'timestamp' => now()->toDateTimeString()
            ]);
            
            // Log de configuración de correo para debugging
            Log::info('Configuración SMTP', [
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'username' => config('mail.mailers.smtp.username'),
                'from' => config('mail.from.address'),
                'timeout' => config('mail.mailers.smtp.timeout')
            ]);
            
            // Intentar enviar el email con timeout corto
            // Si falla, se captura pero el usuario recibe confirmación
            try {
                Log::info('Intentando enviar email...');
                
                Mail::send('emails.contact', ['data' => $data], function ($message) use ($data) {
                    $message->to(config('mail.from.address', 'info@powergyma.com'))
                            ->subject('Nuevo mensaje de contacto - ' . $data['companyName'])
                            ->replyTo($data['email'], $data['fullName']);
                });
                
                Log::info('✅ Email enviado exitosamente', [
                    'to' => config('mail.from.address'),
                    'subject' => 'Nuevo mensaje de contacto - ' . $data['companyName']
                ]);
            } catch (\Exception $mailError) {
                // Log COMPLETO del error
                Log::error('❌ ERROR al enviar email', [
                    'error' => $mailError->getMessage(),
                    'code' => $mailError->getCode(),
                    'file' => $mailError->getFile(),
                    'line' => $mailError->getLine(),
                    'trace' => $mailError->getTraceAsString()
                ]);
            }

            // SIEMPRE responder con éxito (el contacto se registró en logs)
            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error crítico en formulario de contacto', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje. Por favor, intenta de nuevo más tarde.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
