<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_site_settings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/manage/settings')
            ->assertOk()
            ->assertSee('Pengaturan Website')
            ->assertSee('Instagram');
    }

    public function test_admin_can_update_site_settings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->put('/manage/settings', [
                'site_name' => 'GPA Baru',
                'instagram_url' => 'https://instagram.com/gpa_baru',
                'whatsapp_number' => '6281234567890',
                'email' => 'gpa@example.com',
            ])
            ->assertSessionHas('status');

        $this->assertDatabaseHas('site_settings', [
            'site_name' => 'GPA Baru',
            'whatsapp_number' => '6281234567890',
        ]);
    }

    public function test_editor_cannot_open_site_settings(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);

        $this->actingAs($editor)
            ->get('/manage/settings')
            ->assertForbidden();
    }
}
