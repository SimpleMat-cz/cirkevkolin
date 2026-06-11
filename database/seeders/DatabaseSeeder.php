<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Series;
use App\Models\Speaker;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

/**
 * Naplní databázi reálným obsahem webu. Seeder je idempotentní — lze ho
 * spouštět opakovaně (i v produkci) bez vzniku duplicit.
 *
 * Kázání se neseedují: stahuje je `php artisan youtube:sync` ze záložky
 * „Živé přenosy" YouTube kanálu (v produkci běží denně přes Vercel Cron).
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SiteSettingSeeder::class,
            PageSeeder::class,
            FaqSeeder::class,
        ]);

        foreach (['admin', 'editor', 'preacher', 'broadcaster'] as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $admin = User::query()->firstOrCreate(
            ['email' => 'michal@simplemat.cz'],
            [
                'name' => 'Michal Calta',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
        $admin->assignRole('admin');

        foreach (['Víra', 'Uzdravení', 'Smysl života', 'Vztahy', 'Láska', 'Rodina', 'Identita', 'Modlitba'] as $topic) {
            Topic::query()->firstOrCreate(['slug' => Str::slug($topic)], ['name' => $topic]);
        }

        Speaker::query()->firstOrCreate(
            ['slug' => 'martin-fridrich'],
            [
                'name' => 'Martin Fridrich',
                'bio' => 'Pastor sboru Apoštolské církve v Kolíně. Manžel, táta, a člověk, který věří, že víra se žije v každodennosti.',
                'is_active' => true,
            ],
        );

        foreach (['Jako doma', 'Cenzurováno', 'Pro každého'] as $series) {
            Series::query()->firstOrCreate(
                ['slug' => Str::slug($series)],
                ['title' => $series, 'is_published' => true],
            );
        }

        $events = [
            [
                'title' => 'Nedělní setkání',
                'slug' => 'nedelni-setkani',
                'starts_at' => now()->next('Sunday')->setTime(10, 0),
                'ends_at' => now()->next('Sunday')->setTime(11, 30),
                'category' => 'neděle',
                'rrule' => 'FREQ=WEEKLY;BYDAY=SU',
            ],
            [
                'title' => 'WyldLife',
                'slug' => 'wyldlife',
                'starts_at' => now()->next('Wednesday')->setTime(16, 30),
                'ends_at' => now()->next('Wednesday')->setTime(18, 0),
                'category' => 'wyldlife',
                'rrule' => 'FREQ=WEEKLY;BYDAY=WE',
            ],
            [
                'title' => 'Kidztown',
                'slug' => 'kidztown',
                'starts_at' => now()->next('Thursday')->setTime(9, 0),
                'ends_at' => now()->next('Thursday')->setTime(11, 0),
                'category' => 'kidztown',
                'rrule' => 'FREQ=WEEKLY;BYDAY=TH',
            ],
        ];

        foreach ($events as $event) {
            Event::query()->firstOrCreate(
                ['slug' => $event['slug']],
                [...$event, 'location' => 'V Zídkách 402, Kolín', 'is_published' => true],
            );
        }
    }
}
