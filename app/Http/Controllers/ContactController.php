<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
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
            Log::info('=== CONTACTO RECIBIDO VÍA RESEND ===', [
                'email' => $data['email'],
                'company' => $data['companyName'],
                'name' => $data['fullName'],
                'industry' => $data['industry'],
                'timestamp' => now()->toDateTimeString()
            ]);
            
            // Configuración de Resend
            Log::info('📧 Configuración Resend', [
                'mailer' => config('mail.default'),
                'from' => config('mail.from.address'),
                'from_name' => config('mail.from.name'),
            ]);
            
            // Enviar email con Resend usando Mailable
            try {
                Log::info('🚀 Enviando email vía Resend API...');
                
                // Destinatario: donde quieres recibir los contactos
                $recipientEmail = env('CONTACT_EMAIL', 'infopowergyma@gmail.com');
                
                // Enviar usando el Mailable optimizado para Resend
                Mail::to($recipientEmail)->send(new ContactFormMail($data));
                
                Log::info('✅ Email enviado exitosamente vía Resend', [
                    'to' => $recipientEmail,
                    'from' => config('mail.from.address'),
                    'subject' => 'Nuevo contacto - ' . $data['companyName'],
                    'company' => $data['companyName'],
                    'client_email' => $data['email'],
                    'tags' => ['contact-form', 'website', 'powergyma']
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.'
                ]);
                
            } catch (\Exception $mailError) {
                // Log detallado del error de Resend
                Log::error('❌ ERROR al enviar email con Resend', [
                    'error' => $mailError->getMessage(),
                    'code' => $mailError->getCode(),
                    'file' => $mailError->getFile(),
                    'line' => $mailError->getLine(),
                    'company' => $data['companyName'],
                    'client_email' => $data['email']
                ]);
                
                // Retornar error específico al cliente
                return response()->json([
                    'success' => false,
                    'message' => 'Error al enviar el mensaje. Por favor, intenta de nuevo o contáctanos por teléfono.',
                    'debug' => config('app.debug') ? $mailError->getMessage() : null
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('❌ Error crítico en formulario de contacto', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el mensaje. Por favor, intenta de nuevo más tarde.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
