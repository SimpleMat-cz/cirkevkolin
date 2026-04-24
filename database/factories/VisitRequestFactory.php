<?php

namespace Database\Factories;

use App\Models\VisitRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VisitRequest>
 */
class VisitRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'people_count' => fake()->numberBetween(1, 5),
            'note' => fake()->optional()->sentence(),
            'planned_visit_date' => fake()->optional()->dateTimeBetween('now', '+2 months'),
            'was_contacted' => false,
        ];
    }
}
