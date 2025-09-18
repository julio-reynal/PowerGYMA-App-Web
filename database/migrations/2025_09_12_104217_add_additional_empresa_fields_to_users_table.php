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
        // Esta migración se deja vacía ya que los campos fueron agregados en migraciones anteriores
        // Se mantiene para preservar el historial de migraciones
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
                'telefono_fijo',
                'departamento',
                'provincia',
                'direccion_empresa'
            ]);
        });
    }
};
