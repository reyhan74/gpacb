<?php

namespace Tests\Feature;

use App\Models\CandidateRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidateRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_candidate_registration_form(): void
    {
        $this->get('/pendaftaran-calon-anggota')
            ->assertOk()
            ->assertSee('Pendaftaran Calon Anggota');
    }

    public function test_guest_can_submit_candidate_registration(): void
    {
        $response = $this->post('/pendaftaran-calon-anggota', [
            'nama' => 'CALON GPA TEST',
            'nama_lapangan' => 'Rimba Test',
            'nis' => '991122',
            'tempat_lahir' => 'Kediri',
            'tanggal_lahir' => '2010-01-02',
            'jenis_kelamin' => 'Laki-Laki',
            'agama' => 'Islam',
            'no_hp' => '081234567890',
            'alamat' => 'Kediri',
            'motivasi' => 'Ingin belajar kegiatan alam.',
            'email' => 'calon@example.test',
            'angkatan' => 'XXVI',
            'consent' => '1',
            'notification_consent' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('candidate_registrations', [
            'nama' => 'CALON GPA TEST',
            'status' => 'registered',
            'materi_status' => 'not_started',
            'diklat_ruang_status' => 'not_started',
            'diklat_sar_status' => 'not_started',
        ]);
        $candidate = CandidateRegistration::where('nama', 'CALON GPA TEST')->firstOrFail();
        $this->assertNotNull($candidate->user_id);
        $this->assertDatabaseHas('users', ['id' => $candidate->user_id, 'role' => 'calon', 'must_change_password' => 1]);
    }
}
