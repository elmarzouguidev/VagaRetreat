<?php

use App\Enums\Booking\BookingStatusEnums;
use App\Enums\Roles\RolesEnums;
use App\Models\Booking\Booking;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => RolesEnums::SUPERADMIN->value]);
    $this->admin = User::factory()->create();
    $this->admin->assignRole(RolesEnums::SUPERADMIN);
});

test('admin can view bookings list', function () {
    Booking::factory()->count(3)->create();

    $response = $this->actingAs($this->admin)->get(route('admin.bookings.index'));

    $response->assertStatus(200);
});

test('admin can filter bookings by status', function () {
    Booking::factory()->create(['status' => BookingStatusEnums::PENDING]);
    Booking::factory()->create(['status' => BookingStatusEnums::CONFIRMED]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.bookings.index', ['status' => BookingStatusEnums::PENDING->value]));

    $response->assertStatus(200);
});

test('admin can view booking details', function () {
    $booking = Booking::factory()->create();

    $response = $this->actingAs($this->admin)->get(route('admin.bookings.show', $booking));

    $response->assertStatus(200);
});

test('admin can update booking status', function () {
    $booking = Booking::factory()->create(['status' => BookingStatusEnums::PENDING]);

    $response = $this->actingAs($this->admin)
        ->patch(route('admin.bookings.updateStatus', $booking), [
            'status' => BookingStatusEnums::CONFIRMED->value,
        ]);

    $response->assertRedirect(route('admin.bookings.show', $booking));
    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => BookingStatusEnums::CONFIRMED->value,
    ]);
});
