<?php

namespace Database\Factories;

use App\Models\Sermon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sermon>
 */
class SermonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(5);
        $publishedAt = fake()->dateTimeBetween('-2 years', 'now');

        return [
            'title' => $title,
            'slug' => str($title)->slug(),
            'description' => fake()->paragraph(3),
            'youtube_id' => null,
            'duration_seconds' => fake()->numberBetween(1200, 3600),
            'is_published' => true,
            'published_at' => $publishedAt,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(['is_published' => false, 'published_at' => null]);
    }
}
