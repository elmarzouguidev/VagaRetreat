<?php

use App\Enums\Booking\BookingStatusEnums;
use App\Models\Booking\Booking;
use App\Models\Tour\TourPackage;
use App\Models\User;
use App\Models\Utilities\Price;

test('booking can be created', function () {
    $booking = Booking::factory()->create();

    expect($booking)->toBeInstanceOf(Booking::class)
        ->and($booking->booking_reference)->not->toBeNull()
        ->and($booking->status)->toBe(BookingStatusEnums::PENDING);
});

test('booking belongs to a bookable entity', function () {
    $tour = TourPackage::factory()->create();
    $booking = Booking::factory()->create([
        'bookable_type' => TourPackage::class,
        'bookable_id' => $tour->id,
    ]);

    expect($booking->bookable)->toBeInstanceOf(TourPackage::class)
        ->and($booking->bookable->id)->toBe($tour->id);
});

test('booking has a price', function () {
    $price = Price::factory()->create();
    $booking = Booking::factory()->create(['price_id' => $price->id]);

    expect($booking->price)->toBeInstanceOf(Price::class)
        ->and($booking->price->id)->toBe($price->id);
});

test('can create booking via API', function () {
    $tour = TourPackage::factory()->create();
    $price = Price::factory()->create();

    $response = $this->postJson(route('bookings.store'), [
        'bookable_type' => TourPackage::class,
        'bookable_id' => $tour->id,
        'price_id' => $price->id,
        'booking_date' => now()->addDay()->toDateString(),
        'customer_name' => 'John Doe',
        'customer_email' => 'john@example.com',
        'customer_phone' => '1234567890',
        'customer_country' => 'US',
    ]);

    $response->assertStatus(201)
        ->assertJsonPath('booking.customer_email', 'john@example.com')
        ->assertJsonPath('booking.status', BookingStatusEnums::PENDING->value);

    $this->assertDatabaseHas('bookings', [
        'customer_email' => 'john@example.com',
        'booking_reference' => $response->json('booking.booking_reference'),
    ]);
});

test('cannot create booking with disallowed bookable_type', function () {
    $price = Price::factory()->create();

    $response = $this->postJson(route('bookings.store'), [
        'bookable_type' => User::class,
        'bookable_id' => 1,
        'price_id' => $price->id,
        'booking_date' => now()->addDay()->toDateString(),
        'customer_name' => 'Attacker',
        'customer_email' => 'attacker@example.com',
        'customer_phone' => '1234567890',
        'customer_country' => 'US',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['bookable_type']);
});

test('can update booking via API', function () {
    $booking = Booking::factory()->create();

    $response = $this->putJson(route('bookings.update', $booking), [
        'customer_name' => 'Jane Doe',
        'status' => BookingStatusEnums::CONFIRMED->value,
    ]);

    $response->assertStatus(200)
        ->assertJsonPath('booking.customer_name', 'Jane Doe')
        ->assertJsonPath('booking.status', BookingStatusEnums::CONFIRMED->value);

    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'customer_name' => 'Jane Doe',
        'status' => BookingStatusEnums::CONFIRMED->value,
    ]);
});
