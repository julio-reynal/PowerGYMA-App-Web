<?php

// ARCHIVO TEMPORAL PARA DEBUGGING - ELIMINAR DESPUÉS DEL TEST
// Acceder a: https://www.powergyma.com/test-email

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    try {
        // Test básico de configuración
        $config = [
            'MAIL_MAILER' => config('mail.default'),
            'MAIL_HOST' => config('mail.mailers.smtp.host'),
            'MAIL_PORT' => config('mail.mailers.smtp.port'),
            'MAIL_USERNAME' => config('mail.mailers.smtp.username'),
            'MAIL_ENCRYPTION' => config('mail.mailers.smtp.encryption'),
            'MAIL_FROM_ADDRESS' => config('mail.from.address'),
            'MAIL_FROM_NAME' => config('mail.from.name'),
        ];

        // Intentar enviar email de prueba
        Mail::raw('Email de prueba desde Railway - PowerGYMA', function ($message) {
            $message->to('info@powergyma.com')
                    ->subject('Test desde Railway - ' . now());
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Email enviado correctamente',
            'config' => $config,
            'timestamp' => now()
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'config' => [
                'MAIL_MAILER' => config('mail.default'),
                'MAIL_HOST' => config('mail.mailers.smtp.host'),
                'MAIL_PORT' => config('mail.mailers.smtp.port'),
                'MAIL_USERNAME' => config('mail.mailers.smtp.username'),
            ]
        ], 500);
    }
});
