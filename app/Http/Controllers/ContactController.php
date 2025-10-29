<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Log de entrada para debugging en Railway
        \Log::info('=== INICIO PROCESAMIENTO FORMULARIO CONTACTO ===', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'all_data' => $request->all()
        ]);

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
            \Log::warning('Validación fallida en formulario de contacto', [
                'errors' => $validator->errors()->toArray()
            ]);
            
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        try {
            // Log de configuración de correo (sin contraseña)
            \Log::info('Configuración de correo', [
                'mailer' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'from_address' => config('mail.from.address'),
                'username' => config('mail.mailers.smtp.username'),
            ]);
            
            // Guardar los datos en la base de datos para tener registro
            \Log::info('Formulario de contacto validado', ['data' => $data]);
            
            // Enviar el email - SINCRÓNICO para poder capturar errores
            \Mail::send('emails.contact', ['data' => $data], function ($message) use ($data) {
                $message->to(env('CONTACT_EMAIL', 'info@powergyma.com'))
                        ->subject('Nuevo mensaje de contacto - ' . $data['companyName'])
                        ->replyTo($data['email'], $data['fullName']);
            });

            \Log::info('Email enviado exitosamente', [
                'to' => env('CONTACT_EMAIL', 'info@powergyma.com'),
                'subject' => 'Nuevo mensaje de contacto - ' . $data['companyName']
            ]);

            // Responder al usuario
            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.'
            ]);

        } catch (\Exception $e) {
            // Log COMPLETO del error para debugging en Railway
            \Log::error('Error al procesar formulario de contacto', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'data' => $data ?? null,
                'mail_config' => [
                    'mailer' => config('mail.default'),
                    'host' => config('mail.mailers.smtp.host'),
                    'port' => config('mail.mailers.smtp.port'),
                ]
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje. Por favor, intenta de nuevo más tarde.',
                'debug' => config('app.debug') ? [
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => basename($e->getFile())
                ] : null
            ], 500);
        }
    }
}
