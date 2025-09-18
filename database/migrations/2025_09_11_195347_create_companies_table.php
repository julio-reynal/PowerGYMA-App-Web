<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('ruc', 11)->unique()->comment('RUC de la empresa (11 dígitos)');
            $table->string('razon_social', 255)->comment('Razón social de la empresa');
            $table->string('telefono_fijo', 20)->nullable()->comment('Teléfono fijo de la empresa');
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos')->onDelete('set null')
                  ->comment('ID del departamento donde está ubicada la empresa');
            $table->foreignId('provincia_id')->nullable()->constrained('provincias')->onDelete('set null')
                  ->comment('ID de la provincia donde está ubicada la empresa');
            $table->text('direccion_calle')->nullable()->comment('Dirección de la calle de la empresa');
            $table->boolean('activo')->default(true)->comment('Estado de la empresa');
            $table->timestamps();
            
            // Índices
            $table->index('ruc'); // Índice principal para búsquedas por RUC
            $table->index('razon_social'); // Para búsquedas por nombre
            $table->index('departamento_id');
            $table->index('provincia_id');
            $table->index('activo');
            $table->index(['departamento_id', 'provincia_id']); // Índice compuesto para filtros geográficos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
