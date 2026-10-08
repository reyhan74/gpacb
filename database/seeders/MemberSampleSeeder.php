<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\MemberService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSampleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan Super Admin ada
        User::updateOrCreate(
            ['email' => 'superadmin@gpa.local'],
            [
                'name' => 'Super Administrator GPA',
                'password' => Hash::make('superadmin'),
                'role' => 'superadmin',
                'must_change_password' => false,
            ]
        );

        // 2. Data sample dari foto KTA & Excel yang dikirimkan user
        $samples = [
            [
                'nia' => 'GPA.XXIV.021',
                'nama' => 'MOCH. THIERRI KEVIN REVALLINO',
                'nama_lapangan' => 'bangkep',
                'nis' => '31282',
                'ttl' => 'Kediri, 27 Januari 2009',
                'jenis_kelamin' => 'Laki-Laki',
                'no_hp' => '0856-5564-8009',
                'agama' => 'Islam',
                'alamat' => 'Ds. Jambu, Kec. Kayen Kidul, Kab. Kediri',
            ],
            [
                'nia' => 'GPA.PMB.XXIII.01',
                'nama' => 'RICKY HIDAYAT, S.Pd',
                'nama_lapangan' => 'Pembina',
                'nis' => '19850101',
                'ttl' => 'Kediri, 12 Agustus 1985',
                'jenis_kelamin' => 'Laki-Laki',
                'no_hp' => '0812-3456-7890',
                'agama' => 'Islam',
                'alamat' => 'Pare, Kediri',
            ],
            [
                'nia' => 'GPA.XXIII.001',
                'nama' => 'JASEN EKA PUTRA MAHARDIKA',
                'nama_lapangan' => 'Cacing',
                'nis' => '30112',
                'ttl' => 'Kediri, 15 Maret 2008',
                'jenis_kelamin' => 'Laki-Laki',
                'no_hp' => '0857-1122-3344',
                'agama' => 'Islam',
                'alamat' => 'Tulungrejo, Pare, Kediri',
            ],
            [
                'nia' => 'GPA.XXIV.019',
                'nama' => 'FERLINA VIRA ARIEANTY',
                'nama_lapangan' => 'Mawar',
                'nis' => '31201',
                'ttl' => 'Kediri, 04 Mei 2009',
                'jenis_kelamin' => 'Perempuan',
                'no_hp' => '0858-9988-7766',
                'agama' => 'Islam',
                'alamat' => 'Kec. Badas, Kab. Kediri',
            ],
            [
                'nia' => 'GPA.XXV.033',
                'nama' => 'A. RIJALUSYAKSYAN',
                'nama_lapangan' => 'Elang',
                'nis' => '32104',
                'ttl' => 'Kediri, 19 Juli 2010',
                'jenis_kelamin' => 'Laki-Laki',
                'no_hp' => '0821-4455-6677',
                'agama' => 'Islam',
                'alamat' => 'Tertek, Pare, Kediri',
            ],
        ];

        foreach ($samples as $sample) {
            MemberService::importMemberRow($sample);
        }
    }
}
