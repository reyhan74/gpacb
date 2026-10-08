<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_log_in_with_the_seeded_credentials(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@gpa.local',
            'password' => Hash::make('GpaAdmin2026!'),
            'role' => 'admin',
        ]);

        $this->post('/login', [
            'email' => 'admin@gpa.local',
            'password' => 'GpaAdmin2026!',
        ])
            ->assertRedirect(route('manage.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_role_account_can_log_in_using_its_role_as_username_and_password(): void
    {
        foreach (['superadmin', 'admin', 'editor'] as $role) {
            $user = User::factory()->create([
                'email' => $role.'@gpa.local',
                'password' => Hash::make($role),
                'role' => $role,
            ]);

            $this->post('/login', [
                'email' => $role,
                'password' => $role,
            ])->assertRedirect(route('manage.dashboard'));

            $this->assertAuthenticatedAs($user);
            $this->post('/logout');
        }
    }
}
