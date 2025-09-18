<?php
require_once 'vendor/autoload.php';

// Cargar el entorno de Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Http\Controllers\AdvancedFormController;
use Illuminate\Http\Request;

echo "=== PRUEBAS DE API FASE 5 ===\n\n";

// Test 1: Verificar estructura de base de datos
echo "1. Verificando estructura de la tabla users:\n";
try {
    $columns = \DB::select("SHOW COLUMNS FROM users");
    foreach ($columns as $column) {
        echo "   - {$column->Field} ({$column->Type})\n";
    }
    echo "✅ Tabla users verificada\n\n";
} catch (Exception $e) {
    echo "❌ Error en tabla users: " . $e->getMessage() . "\n\n";
}

// Test 2: Verificar que el modelo User puede acceder a los nuevos campos
echo "2. Verificando modelo User:\n";
try {
    $user = new User();
    $fillable = $user->getFillable();
    echo "   Campos fillable: " . implode(', ', $fillable) . "\n";
    
    // Verificar si los nuevos campos están incluidos
    $newFields = ['tipo_documento', 'numero_documento', 'telefono', 'direccion'];
    foreach ($newFields as $field) {
        if (in_array($field, $fillable)) {
            echo "   ✅ Campo '$field' está en fillable\n";
        } else {
            echo "   ❌ Campo '$field' NO está en fillable\n";
        }
    }
    echo "\n";
} catch (Exception $e) {
    echo "❌ Error en modelo User: " . $e->getMessage() . "\n\n";
}

// Test 3: Verificar método de validación de documento
echo "3. Probando validación de documento:\n";
try {
    $controller = new AdvancedFormController();
    
    // Crear una request simulada para check-document
    $request = new \Illuminate\Http\Request();
    $request->merge([
        'tipo_documento' => 'dni',
        'numero_documento' => '12345678'
    ]);
    
    // Simular el método de validación
    $response = $controller->checkDocumentAvailability($request);
    $data = $response->getData(true);
    
    echo "   Respuesta para DNI 12345678: \n";
    echo "   " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
    echo "✅ API de validación de documento funciona\n\n";
} catch (Exception $e) {
    echo "❌ Error en validación de documento: " . $e->getMessage() . "\n\n";
}

// Test 4: Verificar creación de usuario con nuevos campos
echo "4. Probando creación de usuario con nuevos campos:\n";
try {
    $userData = [
        'name' => 'Usuario Test FASE 5',
        'email' => 'test.fase5@example.com',
        'password' => bcrypt('password123'),
        'tipo_documento' => 'dni',
        'numero_documento' => '87654321',
        'telefono' => '987654321',
        'direccion' => 'Av. Test 123',
        'fecha_nacimiento' => '1990-01-01',
        'genero' => 'masculino'
    ];
    
    // Intentar crear el usuario
    $user = User::create($userData);
    echo "   ✅ Usuario creado con ID: {$user->id}\n";
    echo "   Tipo documento: {$user->tipo_documento}\n";
    echo "   Número documento: {$user->numero_documento}\n";
    echo "   Teléfono: {$user->telefono}\n";
    
    // Limpiar: eliminar el usuario de prueba
    $user->delete();
    echo "   ✅ Usuario de prueba eliminado\n\n";
} catch (Exception $e) {
    echo "❌ Error creando usuario: " . $e->getMessage() . "\n\n";
}

echo "=== FIN DE PRUEBAS ===\n";
