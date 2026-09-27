<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_health_endpoint_returns_a_successful_response(): void
    {
        $response = $this->get('/up');

        $response->assertStatus(200);
    }

    public function test_a_fresh_application_displays_the_installation_wizard(): void
    {
        $response = $this->get('/install');

        $response->assertOk();
        $response->assertSee('Server requirements');
    }

    public function test_a_fresh_application_redirects_admin_requests_to_the_installer(): void
    {
        $response = $this->get('/sysadmin/login');

        $response->assertRedirect(route('install'));
    }
}
