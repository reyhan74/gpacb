<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardSettingsLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_links_to_settings_and_settings_links_back_to_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/manage')
            ->assertOk()
            ->assertSee('Pengaturan Website')
            ->assertSee(route('manage.settings.edit'), false);

        $this->actingAs($admin)
            ->get('/manage/settings')
            ->assertOk()
            ->assertSee('Kembali ke Dashboard')
            ->assertSee(route('manage.dashboard'), false);
    }

    public function test_editor_dashboard_does_not_show_settings_shortcut(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);

        $this->actingAs($editor)
            ->get('/manage')
            ->assertOk()
            ->assertDontSee(route('manage.settings.edit'), false);
    }
}
