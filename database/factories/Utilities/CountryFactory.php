<?php

namespace Database\Factories\Utilities;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Utilities\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->country(),
            'slug' => $this->faker->slug(),
            'code' => $this->faker->countryCode(),
            'is_active' => true,
        ];
    }
}
