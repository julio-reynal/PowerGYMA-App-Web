<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
            // Guardar los datos en la base de datos para tener registro
            \Log::info('Formulario de contacto recibido', ['data' => $data]);
            
            // Enviar el email en SEGUNDO PLANO (queue) para respuesta rápida
            // Esto evita el timeout de 30 segundos
            \Mail::send('emails.contact', ['data' => $data], function ($message) use ($data) {
                $message->to(env('CONTACT_EMAIL', 'info@powergyma.com'))
                        ->subject('Nuevo mensaje de contacto - ' . $data['companyName'])
                        ->replyTo($data['email'], $data['fullName']);
            });

            // Responder inmediatamente al usuario (no esperar el email)
            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.'
            ]);

        } catch (\Exception $e) {
            // Log del error para debugging
            \Log::error('Error al procesar formulario de contacto: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'data' => $data
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el mensaje. Por favor, intenta de nuevo más tarde.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
