<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagementAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_opening_management_dashboard(): void
    {
        $this->get('/manage')->assertRedirect('/login');
    }

    public function test_editor_can_open_management_dashboard_after_login(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);

        $this->actingAs($editor)
            ->get('/manage')
            ->assertOk()
            ->assertSee('Manajemen Konten')
            ->assertSee('class="sidebar"', false)
            ->assertSeeInOrder(['Dashboard', 'Konten']);
    }

    public function test_editor_cannot_open_user_management(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);

        $this->actingAs($editor)
            ->get('/manage/users')
            ->assertForbidden();
    }

    public function test_admin_can_open_user_management(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/manage/users')
            ->assertOk();
    }
}
