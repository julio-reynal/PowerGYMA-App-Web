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
        Schema::create('risk_evaluations', function (Blueprint $table) {
            $table->id();
            $table->date('evaluation_date');
            $table->enum('risk_level', ['Muy Bajo', 'Bajo', 'Moderado', 'Alto', 'Crítico', 'No procede']);
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('notes')->nullable();
            $table->json('hourly_data')->nullable(); // Para datos por hora del día
            $table->timestamps();
            
            $table->unique('evaluation_date'); // Solo una evaluación por día
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_evaluations');
    }
};
