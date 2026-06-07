<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class PrekladRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_viewer_page_is_public(): void
    {
        $this->get(route('preklad'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->component('Preklad/Viewer'));
    }

    public function test_admin_page_renders(): void
    {
        $this->get(route('preklad.admin'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->component('Preklad/Admin'));
    }
}
