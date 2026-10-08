<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MemberFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_search_registered_nia_on_public_page(): void
    {
        Member::create([
            'nia' => 'GPA.XXIV.021',
            'nama' => 'MOCH. THIERRI KEVIN REVALLINO',
            'nama_lapangan' => 'bangkep',
            'nis' => '31282',
            'jenis_kelamin' => 'Laki-Laki',
            'agama' => 'Islam',
            'angkatan' => 'XXIV',
        ]);

        $response = $this->get('/cek-nia?q=GPA.XXIV.021');

        $response->assertStatus(200);
        $response->assertSee('MOCH. THIERRI KEVIN REVALLINO');
        $response->assertSee('GPA.XXIV.021');
        $response->assertSee('DATA ANGGOTA RESMI TERDAFTAR');
    }

    public function test_member_can_login_with_nia_and_nis_default_password(): void
    {
        $user = User::create([
            'name' => 'MOCH. THIERRI KEVIN REVALLINO',
            'email' => 'gpaxxiv021@gpa.sch.id',
            'nia' => 'GPA.XXIV.021',
            'password' => Hash::make('31282'),
            'role' => 'anggota',
            'must_change_password' => true,
        ]);

        Member::create([
            'user_id' => $user->id,
            'nia' => 'GPA.XXIV.021',
            'nama' => 'MOCH. THIERRI KEVIN REVALLINO',
            'nis' => '31282',
            'jenis_kelamin' => 'Laki-Laki',
            'agama' => 'Islam',
            'angkatan' => 'XXIV',
        ]);

        $response = $this->post('/login', [
            'email' => 'GPA.XXIV.021',
            'password' => '31282',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('member.password.change'));
    }

    public function test_superadmin_can_view_members_management_index(): void
    {
        $admin = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@gpa.local',
            'password' => Hash::make('secret'),
            'role' => 'superadmin',
        ]);

        $response = $this->actingAs($admin)->get('/manage/members');

        $response->assertStatus(200);
        $response->assertSee('Data Anggota');
    }

    public function test_superadmin_can_download_member_import_template(): void
    {
        $admin = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@gpa.local',
            'password' => Hash::make('secret'),
            'role' => 'superadmin',
        ]);

        $response = $this->actingAs($admin)->get(route('manage.members.import-template'));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $response->assertHeader('content-disposition', 'attachment; filename="template-import-anggota-gpa.csv"');
        $response->assertSee('nia,nama,nama_lapangan,nis,ttl,alamat,no_hp,jenis_kelamin,agama');
        $response->assertSee('GPA.XXVI.001');
    }
}
