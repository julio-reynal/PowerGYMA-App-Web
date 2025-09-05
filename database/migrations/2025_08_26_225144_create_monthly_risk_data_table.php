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
        Schema::create('monthly_risk_data', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('month');
            $table->integer('day');
            $table->enum('risk_level', ['Muy Bajo', 'Bajo', 'Moderado', 'Alto', 'Crítico', 'No procede']);
            $table->enum('status', ['evaluado', 'no_procede', 'pendiente'])->default('pendiente');
            $table->timestamps();
            
            $table->unique(['year', 'month', 'day']); // Solo un registro por día
            $table->index(['year', 'month']); // Índice para consultas mensuales
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_risk_data');
    }
};
