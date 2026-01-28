<?php

namespace Database\Factories\CMS;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CMS\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_id' => User::factory(),
            'title' => $this->faker->sentence(),
            'excerpt' => $this->faker->paragraph(),
            'body' => $this->faker->paragraphs(5, true),
            'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'is_active' => true,
            'is_valid' => true,
        ];
    }
}
