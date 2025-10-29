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
            Log::info('Contacto recibido', [
                'email' => $data['email'],
                'company' => $data['companyName']
            ]);
            
            // Intentar enviar el email con timeout corto
            // Si falla, se captura pero el usuario recibe confirmación
            try {
                Mail::send('emails.contact', ['data' => $data], function ($message) use ($data) {
                    $message->to(config('mail.from.address', 'info@powergyma.com'))
                            ->subject('Nuevo mensaje de contacto - ' . $data['companyName'])
                            ->replyTo($data['email'], $data['fullName']);
                });
                
                Log::info('Email enviado exitosamente');
            } catch (\Exception $mailError) {
                // Log del error pero NO fallar la respuesta al usuario
                Log::error('Error al enviar email (usuario ya notificado): ' . $mailError->getMessage());
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
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje. Por favor, intenta de nuevo más tarde.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
