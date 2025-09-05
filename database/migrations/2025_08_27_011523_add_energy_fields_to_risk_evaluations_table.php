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
        Schema::table('risk_evaluations', function (Blueprint $table) {
            $table->decimal('total_consumption', 10, 2)->nullable()->after('risk_level')->comment('Consumo total en kWh');
            $table->decimal('max_demand', 10, 2)->nullable()->after('total_consumption')->comment('Demanda máxima en kW');
            $table->decimal('power_factor', 5, 3)->nullable()->after('max_demand')->comment('Factor de potencia');
            $table->decimal('total_cost', 10, 2)->nullable()->after('power_factor')->comment('Costo total en $');
            $table->decimal('efficiency_percentage', 5, 2)->nullable()->after('total_cost')->comment('Eficiencia en %');
            $table->text('observations')->nullable()->after('efficiency_percentage')->comment('Observaciones adicionales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risk_evaluations', function (Blueprint $table) {
            $table->dropColumn([
                'total_consumption',
                'max_demand', 
                'power_factor',
                'total_cost',
                'efficiency_percentage',
                'observations'
            ]);
        });
    }
};
