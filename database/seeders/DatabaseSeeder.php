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

        $series1 = Series::factory()->create(['title' => 'Jako doma', 'slug' => 'jako-doma']);
        $otherSeries = Series::factory(3)->create();

        $sermons = Sermon::factory(15)->create([
            'speaker_id' => $martin->id,
            'series_id' => $series1->id,
        ]);

        $sermons->each(function (Sermon $sermon) use ($topics) {
            $sermon->topics()->sync($topics->random(rand(1, 3))->pluck('id'));
        });

        Sermon::factory(5)->create([
            'speaker_id' => $speakers->random()->id,
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
}
