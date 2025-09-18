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
            $table->enum('tipo_documento', ['DNI', 'RUC', 'CE', 'PASAPORTE'])->nullable()->after('email');
            $table->string('numero_documento', 20)->nullable()->after('tipo_documento');
            $table->string('telefono', 15)->nullable()->after('numero_documento');
            $table->string('direccion')->nullable()->after('telefono');
            $table->unsignedBigInteger('departamento_id')->nullable()->after('direccion');
            $table->unsignedBigInteger('provincia_id')->nullable()->after('departamento_id');
            $table->string('distrito')->nullable()->after('provincia_id');
            $table->date('fecha_nacimiento')->nullable()->after('distrito');
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable()->after('fecha_nacimiento');
            
            // Índices para optimización
            $table->index(['tipo_documento', 'numero_documento'], 'idx_documento');
            $table->index('departamento_id');
            $table->index('provincia_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_documento');
            $table->dropIndex(['departamento_id']);
            $table->dropIndex(['provincia_id']);
            $table->dropColumn([
                'tipo_documento',
                'numero_documento', 
                'telefono',
                'direccion',
                'departamento_id',
                'provincia_id',
                'distrito',
                'fecha_nacimiento',
                'genero'
            ]);
        });
    }
};
