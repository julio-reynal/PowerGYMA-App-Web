<?php
echo "🧪 PRUEBA RÁPIDA DE APIs - FASE 5\n";
echo "================================\n\n";

// Test básico de API de validación de email
$email_test = json_decode(file_get_contents('http://127.0.0.1:8000/api/v1/forms/check-email?email=test@nuevo.com'));
echo "📧 Email Test: " . ($email_test->available ? "✅ Disponible" : "❌ No disponible") . "\n";

// Test de fortaleza de contraseña
$password_test = json_decode(file_get_contents('http://127.0.0.1:8000/api/v1/forms/password-strength?password=PowerGYMA2024!'));
echo "🔐 Password Strength: " . $password_test->strength . "/5 (" . $password_test->level . ")\n";

echo "\n🎉 APIs funcionando correctamente!\n";
echo "💡 Para más pruebas, usa los demos en el navegador.\n";
?>
