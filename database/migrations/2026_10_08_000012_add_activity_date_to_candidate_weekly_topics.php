<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('candidate_weekly_topics', function (Blueprint $table) {
            $table->date('activity_date')->nullable()->after('week_number');
        });
    }
    public function down(): void {
        Schema::table('candidate_weekly_topics', fn (Blueprint $table) => $table->dropColumn('activity_date'));
    }
};
