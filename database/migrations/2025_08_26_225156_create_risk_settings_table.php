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
        Schema::create('risk_settings', function (Blueprint $table) {
            $table->id();
            $table->string('risk_level');
            $table->string('color_code'); // Código hexadecimal del color
            $table->integer('percentage_min'); // Porcentaje mínimo
            $table->integer('percentage_max'); // Porcentaje máximo
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique('risk_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_settings');
    }
};
