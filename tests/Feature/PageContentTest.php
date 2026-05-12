<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_site_setting_value_returns_correct_value_or_default(): void
    {
        SiteSetting::create([
            'key' => 'contact.email',
            'group' => 'contact',
            'label' => 'E-mail',
            'value' => 'test@example.com',
            'type' => 'email',
        ]);

        $this->assertSame('test@example.com', SiteSetting::value('contact.email'));
        $this->assertSame('fallback', SiteSetting::value('does.not.exist', 'fallback'));
    }

    public function test_page_find_by_slug_returns_published_page(): void
    {
        Page::create([
            'title' => 'Kontakt',
            'slug' => 'kontakt',
            'hero_title' => 'Napiš.',
            'is_published' => true,
        ]);

        $page = Page::findBySlug('kontakt');

        $this->assertNotNull($page);
        $this->assertSame('Napiš.', $page->hero_title);
    }

    public function test_faq_scopes_filter_correctly(): void
    {
        Faq::create([
            'page_slug' => 'jsem-tu-poprve',
            'question' => 'Co mě čeká?',
            'answer' => 'Pohoda.',
            'sort' => 1,
            'is_published' => true,
        ]);
        Faq::create([
            'page_slug' => 'kontakt',
            'question' => 'Kde jste?',
            'answer' => 'V Kolíně.',
            'sort' => 1,
            'is_published' => false,
        ]);

        $publishedForPage = Faq::query()->published()->forPage('jsem-tu-poprve')->get();

        $this->assertCount(1, $publishedForPage);
        $this->assertSame('Co mě čeká?', $publishedForPage->first()->question);
    }
}
