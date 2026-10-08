<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSiteSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_saved_site_contact_information(): void
    {
        SiteSetting::query()->create([
            'site_name' => 'GPA Test',
            'instagram_url' => 'https://instagram.com/gpa_test',
            'whatsapp_number' => '6281234567890',
            'email' => 'test@gpa.local',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('GPA Test')
            ->assertSee('https://wa.me/6281234567890')
            ->assertSee('test@gpa.local');
    }
}
