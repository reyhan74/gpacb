<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('site_settings', 'diklat_ruang_schedule')) {
                $table->date('diklat_ruang_schedule')->nullable()->after('whatsapp_group_link');
            }
            if (! Schema::hasColumn('site_settings', 'diklat_sar_schedule')) {
                $table->date('diklat_sar_schedule')->nullable()->after('diklat_ruang_schedule');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'diklat_sar_schedule')) {
                $table->dropColumn('diklat_sar_schedule');
            }
            if (Schema::hasColumn('site_settings', 'diklat_ruang_schedule')) {
                $table->dropColumn('diklat_ruang_schedule');
            }
        });
    }
};
