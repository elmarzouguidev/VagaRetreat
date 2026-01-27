<?php

namespace Database\Factories\Tour;

use App\Models\Tour\TourPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour\Accommodation>
 */
class AccommodationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tour_package_id' => TourPackage::factory(),
            'name' => $this->faker->words(3, true),
            'capacity' => $this->faker->numberBetween(1, 4),
            'quantity' => $this->faker->numberBetween(5, 20),
            'description' => $this->faker->sentence(),
            'sort_order' => $this->faker->numberBetween(0, 10),
            'is_active' => true,
            'is_featured' => $this->faker->boolean(),
        ];
    }
}
