<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);
        $startsAt = fake()->dateTimeBetween('now', '+3 months');

        return [
            'title' => $title,
            'slug' => str($title)->slug(),
            'description' => fake()->paragraph(2),
            'starts_at' => $startsAt,
            'ends_at' => (clone $startsAt)->modify('+90 minutes'),
            'category' => fake()->randomElement(['neděle', 'wyldlife', 'kidztown', 'skupinky', 'akce']),
            'location' => 'V Zídkách 402, Kolín',
            'has_registration' => false,
            'is_published' => true,
        ];
    }
}
