<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidate_weekly_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('candidate_registration_id')->constrained()->cascadeOnDelete();
            $table->date('week_date');
            $table->string('activity_type', 30);
            $table->text('material')->nullable();
            $table->text('activity')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('attended')->default(true);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->unique(['candidate_registration_id', 'week_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_weekly_logs');
    }
};
