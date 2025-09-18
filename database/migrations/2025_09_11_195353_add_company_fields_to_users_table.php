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
        Schema::table('users', function (Blueprint $table) {
            // Agregar campos de empresa
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null')
                  ->comment('ID de la empresa a la que pertenece el usuario');
            
            // Agregar campos personales del usuario
            $table->string('telefono_celular', 20)->nullable()->comment('Teléfono celular personal del usuario');
            $table->text('comentarios_adicionales')->nullable()->comment('Comentarios adicionales sobre el usuario');
            
            // Agregar índices para optimizar consultas
            $table->index('company_id');
            $table->index('telefono_celular');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar índices primero
            $table->dropIndex(['company_id']);
            $table->dropIndex(['telefono_celular']);
            
            // Eliminar foreign key
            $table->dropForeign(['company_id']);
            
            // Eliminar campos
            $table->dropColumn([
                'company_id',
                'telefono_celular',
                'comentarios_adicionales'
            ]);
        });
    }
};
