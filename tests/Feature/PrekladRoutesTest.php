<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PrekladRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        Role::findOrCreate('broadcaster');
    }

    private function broadcaster(): User
    {
        return User::factory()->create()->assignRole('broadcaster');
    }

    public function test_viewer_page_is_public(): void
    {
        $this->get(route('preklad'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->component('Preklad/Viewer'));
    }

    public function test_admin_page_requires_login(): void
    {
        $this->get(route('preklad.admin'))->assertRedirect(route('login'));
    }

    public function test_admin_page_forbidden_without_role(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('preklad.admin'))
            ->assertForbidden();
    }

    public function test_admin_page_renders_for_broadcaster(): void
    {
        $this->actingAs($this->broadcaster())
            ->get(route('preklad.admin'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->component('Preklad/Admin'));
    }

    public function test_soniox_key_forbidden_without_role(): void
    {
        $this->actingAs(User::factory()->create())
            ->postJson(route('preklad.soniox-key'))
            ->assertForbidden();
    }

    public function test_soniox_key_reports_misconfiguration_without_api_key(): void
    {
        config()->set('services.soniox.api_key', null);

        $this->actingAs($this->broadcaster())
            ->postJson(route('preklad.soniox-key'))
            ->assertStatus(500)
            ->assertJson(['error' => 'server_misconfigured']);
    }

    public function test_realtime_token_is_minted_for_broadcaster(): void
    {
        config()->set('services.supabase.jwt_secret', 'test-secret');

        $response = $this->actingAs($this->broadcaster())
            ->postJson(route('preklad.realtime-token'))
            ->assertOk()
            ->assertJsonStructure(['token', 'expires_at']);

        $this->assertCount(3, explode('.', $response->json('token')));
    }
}
