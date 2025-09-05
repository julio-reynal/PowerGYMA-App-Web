<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Allow NULL in risk_level while keeping the enum type
        DB::statement("ALTER TABLE `monthly_risk_data` MODIFY `risk_level` ENUM('Muy Bajo','Bajo','Moderado','Alto','Crítico','No procede') NULL");
    }

    public function down(): void
    {
        // Replace NULLs to a safe value then make NOT NULL again
        DB::statement("UPDATE `monthly_risk_data` SET `risk_level` = 'No procede' WHERE `risk_level` IS NULL");
        DB::statement("ALTER TABLE `monthly_risk_data` MODIFY `risk_level` ENUM('Muy Bajo','Bajo','Moderado','Alto','Crítico','No procede') NOT NULL");
    }
};
