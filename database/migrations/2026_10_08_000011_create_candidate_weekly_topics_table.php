<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('candidate_weekly_topics', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('week_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique('week_number');
        });
        Schema::table('candidate_weekly_logs', function (Blueprint $table) {
            $table->foreignId('topic_id')->nullable()->after('candidate_registration_id')->constrained('candidate_weekly_topics')->nullOnDelete();
        });
    }
    public function down(): void {
        Schema::table('candidate_weekly_logs', fn (Blueprint $table) => $table->dropForeign(['topic_id']));
        Schema::dropIfExists('candidate_weekly_topics');
    }
};
