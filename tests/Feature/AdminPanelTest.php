<?php

namespace Tests\Feature;

use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\Faqs\FaqResource;
use App\Filament\Resources\NewsletterSubscribers\NewsletterSubscriberResource;
use App\Filament\Resources\Pages\PageResource;
use App\Filament\Resources\Series\SeriesResource;
use App\Filament\Resources\Sermons\SermonResource;
use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Filament\Resources\Speakers\SpeakerResource;
use App\Filament\Resources\Topics\TopicResource;
use App\Filament\Resources\VisitRequests\VisitRequestResource;
use App\Models\Event;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Series;
use App\Models\Sermon;
use App\Models\Speaker;
use App\Models\Topic;
use App\Models\User;
use App\Models\VisitRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $this->get('/admin')->assertRedirect();
    }

    public function test_user_without_role_cannot_access_admin(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_admin_dashboard_loads(): void
    {
        $this->actingAs($this->admin)->get('/admin')->assertOk();
    }

    public function test_all_resource_list_pages_load(): void
    {
        $pages = [
            EventResource::getUrl('index'),
            FaqResource::getUrl('index'),
            NewsletterSubscriberResource::getUrl('index'),
            PageResource::getUrl('index'),
            SeriesResource::getUrl('index'),
            SermonResource::getUrl('index'),
            SiteSettingResource::getUrl('index'),
            SpeakerResource::getUrl('index'),
            TopicResource::getUrl('index'),
            VisitRequestResource::getUrl('index'),
        ];

        foreach ($pages as $url) {
            $this->actingAs($this->admin)->get($url)->assertOk();
        }
    }

    public function test_create_pages_load(): void
    {
        $pages = [
            EventResource::getUrl('create'),
            FaqResource::getUrl('create'),
            SeriesResource::getUrl('create'),
            SermonResource::getUrl('create'),
            SpeakerResource::getUrl('create'),
            TopicResource::getUrl('create'),
        ];

        foreach ($pages as $url) {
            $this->actingAs($this->admin)->get($url)->assertOk();
        }
    }

    public function test_edit_pages_load_with_records(): void
    {
        $pages = [
            EventResource::getUrl('edit', ['record' => Event::factory()->create()]),
            FaqResource::getUrl('edit', ['record' => Faq::factory()->create()]),
            PageResource::getUrl('edit', ['record' => Page::factory()->create()]),
            SeriesResource::getUrl('edit', ['record' => Series::factory()->create()]),
            SermonResource::getUrl('edit', ['record' => Sermon::factory()->create()]),
            SpeakerResource::getUrl('edit', ['record' => Speaker::factory()->create()]),
            TopicResource::getUrl('edit', ['record' => Topic::factory()->create()]),
            VisitRequestResource::getUrl('edit', ['record' => VisitRequest::factory()->create()]),
        ];

        foreach ($pages as $url) {
            $this->actingAs($this->admin)->get($url)->assertOk();
        }
    }
}
