<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nia')->nullable()->unique()->after('email');
            $table->boolean('must_change_password')->default(false)->after('password');
        });

        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nia')->unique();
            $table->string('nama');
            $table->string('nama_lapangan')->nullable(); // Nama Rimba / Panggilan
            $table->string('nis', 30)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('ttl_raw')->nullable(); // Text aslinya jika parsing parsial
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->default('Laki-Laki');
            $table->string('agama', 30)->default('Islam');
            $table->string('angkatan', 30)->nullable(); // e.g., XXIII, XXIV, XXV
            $table->year('tahun_angkatan')->nullable(); // e.g., 2023, 2024
            $table->enum('tipe_anggota', ['anggota', 'pembina', 'pelatih', 'alumni'])->default('anggota');
            $table->string('status_keanggotaan', 30)->default('Aktif');
            $table->string('no_hp', 30)->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->string('pembina_nama')->nullable()->default('RICKY HIDAYAT, S.Pd');
            $table->string('pembina_jabatan')->nullable()->default('Pembina GPA SMK CB');
            $table->date('tanggal_pengesahan')->nullable();
            $table->timestamps();

            $table->index('angkatan');
            $table->index('nama');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nia', 'must_change_password']);
        });
    }
};
