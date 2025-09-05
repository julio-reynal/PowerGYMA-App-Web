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
        Schema::table('excel_uploads', function (Blueprint $table) {
            $table->bigInteger('file_size')->default(0)->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('excel_uploads', function (Blueprint $table) {
            $table->dropColumn('file_size');
        });
    }
};
