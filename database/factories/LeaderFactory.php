<?php

namespace Database\Factories;

use App\Models\Leader;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Leader>
 */
class LeaderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'role' => $this->faker->randomElement(['Vedoucí', 'Tým', null]),
            'phone' => $this->faker->optional()->numerify('+420 ### ### ###'),
            'email' => $this->faker->optional()->safeEmail(),
            'photo_path' => null,
            'page_slug' => $this->faker->randomElement(array_keys(Leader::PAGES)),
            'sort' => $this->faker->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
