<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('members')) {
            DB::table('members')->whereNotIn('angkatan', config('gpa.active_cohorts', ['XXIV', 'XXV', 'XXVI']))->whereNotIn('tipe_anggota', ['pembina', 'pelatih'])->update([
                'tipe_anggota' => 'alumni',
                'status_keanggotaan' => 'Alumni',
            ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('members')) {
            DB::table('members')->where('angkatan', 'XXIII')->update([
                'tipe_anggota' => 'anggota',
                'status_keanggotaan' => 'Aktif',
            ]);
        }
    }
};
