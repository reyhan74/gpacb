<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('candidate_registrations', function (Blueprint $table): void {
            $table->timestamp('notification_consent_at')->nullable()->after('consent_ip');
        });
    }

    public function down(): void
    {
        Schema::table('candidate_registrations', function (Blueprint $table): void {
            $table->dropColumn('notification_consent_at');
        });
    }
};
