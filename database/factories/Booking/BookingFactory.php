<?php

namespace Database\Factories\Booking;

use App\Enums\Booking\BookingStatusEnums;
use App\Models\Tour\TourPackage;
use App\Models\Utilities\Price;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_reference' => $this->faker->unique()->bothify('BK-####-????'),
            'booking_date' => $this->faker->date(),
            'status' => BookingStatusEnums::PENDING,
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->safeEmail(),
            'customer_phone' => $this->faker->phoneNumber(),
            'customer_country' => $this->faker->country(),
            'is_active' => true,
            'is_valid' => true,
            'bookable_type' => TourPackage::class,
            'bookable_id' => TourPackage::factory(),
            'price_id' => Price::factory(),
        ];
    }
}
