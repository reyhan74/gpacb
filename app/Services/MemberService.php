<?php

namespace App\Services;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberService
{
    /**
     * Parse baris CSV / Array dari Excel dan simpan/update ke database
     */
    public static function importMemberRow(array $row): Member
    {
        return DB::transaction(function () use ($row) {
            $nia = strtoupper(trim((string) ($row['nia'] ?? '')));
            $nama = strtoupper(trim((string) ($row['nama'] ?? '')));
            $namaLapangan = isset($row['nama_lapangan']) ? trim((string) $row['nama_lapangan']) : null;
            $nis = isset($row['nis']) ? trim((string) $row['nis']) : null;
            $ttlRaw = isset($row['ttl']) ? trim((string) $row['ttl']) : ($row['ttl_raw'] ?? null);
            $alamat = isset($row['alamat']) ? trim((string) $row['alamat']) : null;
            $noHp = isset($row['no_hp']) ? trim((string) $row['no_hp']) : null;
            $jenisKelamin = isset($row['jenis_kelamin']) ? trim((string) $row['jenis_kelamin']) : 'Laki-Laki';
            $agama = isset($row['agama']) ? trim((string) $row['agama']) : 'Islam';

            // Ekstrak angkatan dari format NIA (misal GPA.XXIV.021 -> angkatan XXIV)
            $angkatan = $row['angkatan'] ?? null;
            $tipe = $row['tipe_anggota'] ?? 'anggota';
            $parts = explode('.', $nia);
            if (count($parts) >= 3 && ! isset($row['tipe_anggota'])) {
                if (in_array($parts[1], ['PMB', 'PLT'], true)) {
                    $tipe = $parts[1] === 'PMB' ? 'pembina' : 'pelatih';
                    $angkatan = $parts[2] ?? null;
                } else {
                    $angkatan = $parts[1];
                }
            }

            // Parse Tempat & Tanggal Lahir jika ada koma (Kediri, 27 Januari 2009)
            $tempatLahir = null;
            $tanggalLahir = null;
            if ($ttlRaw && str_contains($ttlRaw, ',')) {
                [$tempat, $tgl] = explode(',', $ttlRaw, 2);
                $tempatLahir = trim($tempat);
                $parsedDate = self::parseIndonesianDate(trim($tgl));
                if ($parsedDate) {
                    $tanggalLahir = $parsedDate;
                }
            } else {
                $tempatLahir = $ttlRaw;
            }

            // Tentukan password default: menggunakan NIS jika ada, atau default tanggal DDMMYYYY, atau 'gpa12345'
            $defaultPassword = $nis ?: ($tanggalLahir ? $tanggalLahir->format('dmY') : 'gpa12345');

            // Cari atau buat User akun untuk anggota
            $email = strtolower(Str::slug($nia, '') . '@gpa.sch.id');
            $user = User::firstOrNew(['nia' => $nia]);
            $user->name = $nama;
            $user->email = $user->email ?: $email;
            if (! $user->exists) {
                $user->password = Hash::make($defaultPassword);
                $user->must_change_password = true;
                $user->role = in_array($tipe, ['pembina', 'pelatih'], true) ? 'admin' : 'anggota';
            }
            $user->save();

            // Simpan Data Anggota
            $member = Member::updateOrCreate(
                ['nia' => $nia],
                [
                    'user_id' => $user->id,
                    'nama' => $nama,
                    'nama_lapangan' => $namaLapangan,
                    'nis' => $nis,
                    'tempat_lahir' => $tempatLahir,
                    'tanggal_lahir' => $tanggalLahir,
                    'ttl_raw' => $ttlRaw,
                    'jenis_kelamin' => $jenisKelamin,
                    'agama' => $agama,
                    'angkatan' => $angkatan,
                    'tipe_anggota' => $tipe,
                    'status_keanggotaan' => ($row['status_keanggotaan'] ?? null) ?: ($tipe === 'alumni' ? 'Alumni' : 'Aktif'),
                    'tanggal_purna' => $row['tanggal_purna'] ?? null,
                    'no_hp' => $noHp,
                    'alamat' => $alamat,
                    'pembina_nama' => 'RICKY HIDAYAT, S.Pd',
                    'pembina_jabatan' => 'Pembina GPA SMK CB',
                    'tanggal_pengesahan' => now(),
                ]
            );

            return $member;
        });
    }

    private static function parseIndonesianDate(string $dateStr): ?\Carbon\Carbon
    {
        $bulanMap = [
            'januari' => '01', 'februari' => '02', 'maret' => '03', 'april' => '04',
            'mei' => '05', 'juni' => '06', 'juli' => '07', 'agustus' => '08',
            'september' => '09', 'oktober' => '10', 'november' => '11', 'desember' => '12',
        ];

        $clean = strtolower(trim($dateStr));
        foreach ($bulanMap as $id => $num) {
            if (str_contains($clean, $id)) {
                $replaced = str_replace($id, $num, $clean);
                try {
                    return \Carbon\Carbon::createFromFormat('d m Y', preg_replace('/\s+/', ' ', $replaced));
                } catch (\Throwable) {
                    try {
                        return \Carbon\Carbon::parse($replaced);
                    } catch (\Throwable) {
                        return null;
                    }
                }
            }
        }

        try {
            return \Carbon\Carbon::parse($dateStr);
        } catch (\Throwable) {
            return null;
        }
    }
}
