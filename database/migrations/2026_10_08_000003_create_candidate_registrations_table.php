<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidate_registrations', function (Blueprint $table): void {
            $table->id();
            $table->string('registration_code', 32)->unique();
            $table->string('nama');
            $table->string('nama_lapangan')->nullable();
            $table->string('nis', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp', 30);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin', 20)->nullable();
            $table->string('agama', 30)->nullable();
            $table->text('alamat')->nullable();
            $table->string('angkatan', 30);
            $table->text('motivasi')->nullable();
            $table->string('kontak_darurat')->nullable();
            $table->string('foto')->nullable();
            $table->string('status', 30)->default('registered');
            $table->string('materi_status', 30)->default('not_started');
            $table->string('diklat_ruang_status', 30)->default('not_started');
            $table->string('diklat_sar_status', 30)->default('not_started');
            $table->date('materi_date')->nullable();
            $table->date('diklat_ruang_date')->nullable();
            $table->date('diklat_sar_date')->nullable();
            $table->text('review_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('nia_eligible_at')->nullable();
            $table->timestamp('nia_issued_at')->nullable();
            $table->foreignId('approved_member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('consent_at')->nullable();
            $table->string('consent_ip', 45)->nullable();
            $table->timestamps();
            $table->index(['status', 'angkatan']);
            $table->index('nama');
            $table->index('no_hp');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_registrations');
    }
};
