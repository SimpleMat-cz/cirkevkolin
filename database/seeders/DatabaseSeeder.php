<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Series;
use App\Models\Sermon;
use App\Models\Speaker;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'editor', 'preacher'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $admin = User::factory()->create([
            'name' => 'Michal Calta',
            'email' => 'michal@simplemat.cz',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $topics = Topic::factory(8)->create();

        $martin = Speaker::factory()->create([
            'name' => 'Martin Fridrich',
            'slug' => 'martin-fridrich',
            'bio' => 'Pastor sboru Apoštolské církve v Kolíně. Manžel, táta, a člověk, který věří, že víra se žije v každodennosti.',
        ]);

        $speakers = Speaker::factory(3)->create();

        $fallbackSeries = Series::factory()->create(['title' => 'Jako doma', 'slug' => 'jako-doma']);
        $otherSeries = Series::factory(3)->create();

        // Reálná kázání — YouTube IDs z církev kolín kanálu.
        // Název + řečníka parsujeme z YouTube titulku ve formátu "DD.MM.YYYY - Série - TÉMA - Jméno Řečníka".
        $realSermons = [
            ['youtube_id' => 'zcUPOHfJNcM', 'published_at' => now()->startOfWeek()->subDays(1)->setTime(10, 0)],
            ['youtube_id' => '1JyYweUHF6k', 'published_at' => now()->startOfWeek()->subDays(8)->setTime(10, 0)],
            ['youtube_id' => 'RBu8XwgyFSg', 'published_at' => now()->startOfWeek()->subDays(15)->setTime(10, 0)],
            ['youtube_id' => 'Hg9kXbCC-ZU', 'published_at' => now()->startOfWeek()->subDays(22)->setTime(10, 0)],
        ];

        foreach ($realSermons as $data) {
            $youtubeId = $data['youtube_id'];
            $parsed = $this->parseYoutubeTitle($youtubeId);

            $seriesName = $parsed['series'] ?? $fallbackSeries->title;
            $series = Series::firstOrCreate(
                ['slug' => Str::slug($seriesName)],
                ['title' => $seriesName],
            );

            $speakerName = $parsed['speaker'] ?? 'Host';
            $speaker = Speaker::firstOrCreate(
                ['slug' => Str::slug($speakerName)],
                ['name' => $speakerName],
            );

            $title = $parsed['topic'] ?? 'Nedělní kázání';

            Sermon::factory()->create([
                'speaker_id' => $speaker->id,
                'series_id' => $series->id,
                'title' => $title,
                'slug' => Str::slug($seriesName.' '.$title).'-'.$youtubeId,
                'description' => $parsed['full_title'] ?? '',
                'youtube_id' => $youtubeId,
                'thumbnail_url' => "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg",
                'duration_seconds' => 2700,
                'is_published' => true,
                'published_at' => $data['published_at'],
            ]);
        }

        // Starší kázání — dummy data pro archiv
        $sermons = Sermon::factory(15)->create([
            'speaker_id' => $martin->id,
            'series_id' => $fallbackSeries->id,
            'published_at' => fake()->dateTimeBetween('-2 years', '-1 month'),
        ]);

        $sermons->each(function (Sermon $sermon) use ($topics) {
            $sermon->topics()->sync($topics->random(rand(1, 3))->pluck('id'));
        });

        Sermon::factory(5)->create([
            'speaker_id' => $speakers->random()->id,
            'published_at' => fake()->dateTimeBetween('-2 years', '-2 months'),
        ]);

        Event::factory()->create([
            'title' => 'Nedělní setkání',
            'slug' => 'nedelni-setkani',
            'starts_at' => now()->next('Sunday')->setTime(10, 0),
            'ends_at' => now()->next('Sunday')->setTime(11, 30),
            'category' => 'neděle',
            'location' => 'V Zídkách 402, Kolín',
            'rrule' => 'FREQ=WEEKLY;BYDAY=SU',
            'is_published' => true,
        ]);

        Event::factory()->create([
            'title' => 'WyldLife',
            'slug' => 'wyldlife',
            'starts_at' => now()->next('Wednesday')->setTime(16, 30),
            'ends_at' => now()->next('Wednesday')->setTime(18, 0),
            'category' => 'wyldlife',
            'location' => 'V Zídkách 402, Kolín',
            'rrule' => 'FREQ=WEEKLY;BYDAY=WE',
            'is_published' => true,
        ]);

        Event::factory()->create([
            'title' => 'Kidztown',
            'slug' => 'kidztown',
            'starts_at' => now()->next('Thursday')->setTime(9, 0),
            'ends_at' => now()->next('Thursday')->setTime(11, 0),
            'category' => 'kidztown',
            'location' => 'V Zídkách 402, Kolín',
            'rrule' => 'FREQ=WEEKLY;BYDAY=TH',
            'is_published' => true,
        ]);

        Event::factory(5)->create();
    }

    /**
     * Načte oEmbed metadata z YouTube a rozparsuje název do série, tématu a řečníka.
     * Očekávaný formát titulku: "DD.MM.YYYY - Série - TÉMA - Jméno Řečníka".
     *
     * @return array{full_title?:string,series?:string,topic?:string,speaker?:string}
     */
    private function parseYoutubeTitle(string $youtubeId): array
    {
        try {
            $response = Http::timeout(5)->get('https://www.youtube.com/oembed', [
                'url' => "https://www.youtube.com/watch?v={$youtubeId}",
                'format' => 'json',
            ]);

            if (! $response->ok()) {
                return [];
            }

            $title = $response->json('title');
            if (! is_string($title) || $title === '') {
                return [];
            }

            $parts = array_values(array_filter(
                array_map('trim', preg_split('/\s*[-–—]\s*/u', $title) ?: []),
                fn ($p) => $p !== '',
            ));

            // Očekáváme 4 části [datum, série, téma, řečník] — pokud je jich méně, bereme co je.
            $series = $parts[1] ?? null;
            $topic = $parts[2] ?? null;
            $speaker = $parts[3] ?? null;

            // Téma v titulku je UPPERCASE — pro hezčí zobrazení převést na Title-case (první velké).
            if (is_string($topic) && mb_strtoupper($topic) === $topic) {
                $topic = mb_convert_case(mb_strtolower($topic), MB_CASE_TITLE, 'UTF-8');
            }

            return [
                'full_title' => $title,
                'series' => $series,
                'topic' => $topic,
                'speaker' => $speaker,
            ];
        } catch (\Throwable) {
            return [];
        }
    }
}
