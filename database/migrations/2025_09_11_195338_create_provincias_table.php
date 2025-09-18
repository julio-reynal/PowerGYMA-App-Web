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
        Schema::create('provincias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('cascade')
                  ->comment('ID del departamento al que pertenece');
            $table->string('nombre', 100)->comment('Nombre de la provincia');
            $table->string('codigo', 10)->unique()->comment('Código UBIGEO de la provincia');
            $table->boolean('activo')->default(true)->comment('Estado de la provincia');
            $table->timestamps();
            
            // Índices
            $table->index('departamento_id');
            $table->index('codigo');
            $table->index('activo');
            $table->index(['departamento_id', 'activo']); // Índice compuesto para consultas frecuentes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provincias');
    }
};
