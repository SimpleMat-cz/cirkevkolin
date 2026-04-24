<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Topic>
 */
class TopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $topics = ['Víra', 'Modlitba', 'Rodina', 'Naděje', 'Láska', 'Odpuštění', 'Identita', 'Smysl života', 'Vztahy', 'Uzdravení'];
        $name = fake()->unique()->randomElement($topics);

        return [
            'name' => $name,
            'slug' => str($name)->slug(),
        ];
    }
}
