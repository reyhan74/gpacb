<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('site_settings') && ! Schema::hasColumn('site_settings', 'slideshow_duration')) {
            Schema::table('site_settings', function (Blueprint $table): void {
                $table->unsignedSmallInteger('slideshow_duration')->default(9)->after('logo_path');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('site_settings') && Schema::hasColumn('site_settings', 'slideshow_duration')) {
            Schema::table('site_settings', function (Blueprint $table): void {
                $table->dropColumn('slideshow_duration');
            });
        }
    }
};
