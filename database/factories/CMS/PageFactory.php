<?php

namespace Database\Factories\CMS;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CMS\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'excerpt' => $this->faker->sentence(10),
            'body' => $this->faker->paragraphs(8, true),
            'published_at' => now(),
            'is_active' => true,
            'is_valid' => true,
        ];
    }
}
