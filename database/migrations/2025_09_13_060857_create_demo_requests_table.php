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
        Schema::create('demo_requests', function (Blueprint $table) {
            $table->id();
            
            // Información personal
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('telefono')->nullable();
            $table->string('telefono_celular')->nullable();
            
            // Información del documento
            $table->enum('tipo_documento', ['DNI', 'CE', 'Pasaporte', 'RUC'])->default('DNI');
            $table->string('numero_documento')->nullable();
            
            // Información de la empresa
            $table->string('empresa');
            $table->string('ruc_empresa')->nullable();
            $table->string('giro_empresa')->nullable();
            $table->string('cargo_puesto')->nullable();
            
            // Información de contacto adicional
            $table->text('direccion')->nullable();
            $table->string('ciudad')->nullable();
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->unsignedBigInteger('provincia_id')->nullable();
            
            // Información específica de la demo
            $table->enum('tipo_demo', ['evaluacion', 'prueba_gratis', 'consultoria', 'otro'])->default('evaluacion');
            $table->text('comentarios')->nullable();
            $table->text('necesidades_especificas')->nullable();
            
            // Estado de la solicitud
            $table->enum('estado', ['pendiente', 'contactado', 'programado', 'completado', 'rechazado'])->default('pendiente');
            $table->timestamp('fecha_contacto')->nullable();
            $table->timestamp('fecha_demo_programada')->nullable();
            $table->text('notas_internas')->nullable();
            
            // Información adicional
            $table->boolean('acepta_terminos')->default(false);
            $table->boolean('acepta_marketing')->default(false);
            $table->string('origen_solicitud')->default('web'); // web, telefono, email, etc.
            
            $table->timestamps();
            
            // Índices
            $table->index(['estado', 'created_at']);
            $table->index('email');
            $table->index('ruc_empresa');
            $table->index(['departamento_id', 'provincia_id']);
            
            // Foreign keys
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('set null');
            $table->foreign('provincia_id')->references('id')->on('provincias')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_requests');
    }
};
