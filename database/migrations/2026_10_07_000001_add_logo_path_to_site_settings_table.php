<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('site_settings') && ! Schema::hasColumn('site_settings', 'logo_path')) {
            Schema::table('site_settings', function (Blueprint $table): void {
                $table->string('logo_path')->nullable()->after('site_name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('site_settings') && Schema::hasColumn('site_settings', 'logo_path')) {
            Schema::table('site_settings', function (Blueprint $table): void {
                $table->dropColumn('logo_path');
            });
        }
    }
};
