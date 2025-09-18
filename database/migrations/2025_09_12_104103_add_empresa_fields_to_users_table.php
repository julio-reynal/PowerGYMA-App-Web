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
            // Información de la Empresa (solo campos nuevos no existentes)
            if (!Schema::hasColumn('users', 'ruc_empresa')) {
                $table->string('ruc_empresa', 11)->nullable();
            }
            if (!Schema::hasColumn('users', 'giro_empresa')) {
                $table->string('giro_empresa', 100)->nullable();
            }
            if (!Schema::hasColumn('users', 'razon_social')) {
                $table->string('razon_social', 255)->nullable();
            }
            
            // Información del Cargo
            if (!Schema::hasColumn('users', 'puesto_trabajo')) {
                $table->string('puesto_trabajo', 100)->nullable();
            }
            
            // Información de Contacto (evitar duplicados)
            if (!Schema::hasColumn('users', 'telefono_celular')) {
                $table->string('telefono_celular', 15)->nullable();
            }
            if (!Schema::hasColumn('users', 'telefono_fijo')) {
                $table->string('telefono_fijo', 15)->nullable();
            }
            
            // Dirección de la Empresa (evitar duplicados con campos existentes)
            if (!Schema::hasColumn('users', 'direccion_empresa')) {
                $table->string('direccion_empresa', 255)->nullable();
            }
            
            // Información Adicional
            if (!Schema::hasColumn('users', 'comentarios_adicionales')) {
                $table->text('comentarios_adicionales')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar índices primero
            $table->dropIndex(['users_ruc_empresa_index']);
            $table->dropIndex(['users_giro_empresa_index']);
            $table->dropIndex(['users_departamento_provincia_index']);
            
            // Eliminar columnas
            $table->dropColumn([
                'ruc_empresa',
                'giro_empresa', 
                'razon_social',
                'puesto_trabajo',
                'telefono_celular',
                'telefono_fijo',
                'departamento',
                'provincia',
                'direccion_empresa',
                'comentarios_adicionales'
            ]);
        });
    }
};
