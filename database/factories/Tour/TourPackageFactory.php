<?php

namespace Database\Factories\Tour;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour\TourPackage>
 */
class TourPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(6, true),
            'start_at' => fake()->date(),
            'end_at' => fake()->date(),
            'location' => fake()->address(),
            'duration' => fake()->randomDigit(),
            'excerpt' => fake()->paragraph(6),
            'description' => fake()->paragraph(20),
        ];
    }
}
