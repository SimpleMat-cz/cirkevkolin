<?php

namespace Tests\Feature;

use App\Models\Leader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CoDelameTest extends TestCase
{
    use RefreshDatabase;

    public function test_co_delame_index_loads(): void
    {
        $this->get('/co-delame')->assertStatus(200);
    }

    public function test_nedelni_setkani_page_loads(): void
    {
        $this->get('/co-delame/nedelni-setkani')->assertStatus(200);
    }

    public function test_wyldlife_page_loads(): void
    {
        $this->get('/co-delame/wyldlife')->assertStatus(200);
    }

    public function test_kidztown_page_loads(): void
    {
        $this->get('/co-delame/kidztown')->assertStatus(200);
    }

    public function test_skupinky_page_loads(): void
    {
        $this->get('/co-delame/skupinky')->assertStatus(200);
    }

    public function test_activity_page_passes_leaders_from_database(): void
    {
        Leader::factory()->create([
            'name' => 'Žužu — Zuzana Dibalová',
            'role' => 'Vedoucí WyldLife',
            'phone' => '+420 777 123 456',
            'page_slug' => 'wyldlife',
            'sort' => 1,
        ]);
        Leader::factory()->create([
            'name' => 'Nový Vedoucí',
            'page_slug' => 'wyldlife',
            'sort' => 2,
        ]);
        Leader::factory()->create([
            'name' => 'Skrytý',
            'page_slug' => 'wyldlife',
            'is_active' => false,
        ]);
        Leader::factory()->create([
            'name' => 'Jiná Stránka',
            'page_slug' => 'kidztown',
        ]);

        $this->get('/co-delame/wyldlife')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('CoDelame/Wyldlife')
                ->has('leaders', 2)
                ->where('leaders.0.name', 'Žužu — Zuzana Dibalová')
                ->where('leaders.0.phone', '+420 777 123 456')
                ->where('leaders.1.name', 'Nový Vedoucí'));
    }

    public function test_activity_page_sends_empty_leaders_without_data(): void
    {
        $this->get('/co-delame/wyldlife')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->has('leaders', 0));
    }
}
