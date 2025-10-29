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
            // Log simple solo del contacto recibido
            Log::info('Contacto recibido: ' . $data['email'] . ' - ' . $data['companyName']);
            
            // Enviar el email de forma ASÍNCRONA usando later() para no bloquear
            // Si falla, se registra en logs pero el usuario ya recibió confirmación
            Mail::later(now()->addSeconds(2), 'emails.contact', ['data' => $data], function ($message) use ($data) {
                $message->to(config('mail.from.address', 'info@powergyma.com'))
                        ->subject('Nuevo mensaje de contacto - ' . $data['companyName'])
                        ->replyTo($data['email'], $data['fullName']);
            });

            // Responder INMEDIATAMENTE al usuario (no esperar el email)
            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.'
            ]);

        } catch (\Exception $e) {
            // Log simple del error
            Log::error('Error en formulario de contacto: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje. Por favor, intenta de nuevo más tarde.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
