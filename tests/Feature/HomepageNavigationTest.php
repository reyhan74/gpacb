<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageNavigationTest extends TestCase
{
    public function test_homepage_links_to_the_management_login(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Masuk Pengelola')
            ->assertSee('href="http://localhost:8000/login"', false);
    }
}
