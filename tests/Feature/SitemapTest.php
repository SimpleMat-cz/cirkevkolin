<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Sermon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_returns_xml(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee('<?xml', false);
        $response->assertSee('<urlset', false);
    }

    public function test_sitemap_includes_static_pages(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertSee('/jsem-tu-poprve', false);
        $response->assertSee('/kazani', false);
        $response->assertSee('/akce', false);
        $response->assertSee('/kontakt', false);
    }

    public function test_sitemap_includes_published_sermons(): void
    {
        $sermon = Sermon::factory()->create(['is_published' => true, 'slug' => 'test-kazani']);

        $response = $this->get('/sitemap.xml');

        $response->assertSee('/kazani/test-kazani', false);
    }

    public function test_sitemap_excludes_unpublished_sermons(): void
    {
        Sermon::factory()->create(['is_published' => false, 'slug' => 'tajne-kazani']);

        $response = $this->get('/sitemap.xml');

        $response->assertDontSee('/kazani/tajne-kazani', false);
    }

    public function test_sitemap_includes_recent_published_events(): void
    {
        $event = Event::factory()->create([
            'is_published' => true,
            'slug' => 'test-akce',
            'starts_at' => now()->addDays(7),
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertSee('/akce/test-akce', false);
    }

    public function test_robots_txt_file_exists_and_disallows_admin(): void
    {
        $robotsPath = public_path('robots.txt');
        $this->assertFileExists($robotsPath);
        $this->assertStringContainsString('Disallow: /admin', file_get_contents($robotsPath));
    }
}
