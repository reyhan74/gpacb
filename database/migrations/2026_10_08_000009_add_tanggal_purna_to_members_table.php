<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('members', 'tanggal_purna')) {
            Schema::table('members', function (Blueprint $table) {
                $table->date('tanggal_purna')->nullable()->after('status_keanggotaan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('members', 'tanggal_purna')) {
            Schema::table('members', fn (Blueprint $table) => $table->dropColumn('tanggal_purna'));
        }
    }
};
