<?php

use App\Enums\Roles\RolesEnums;
use App\Models\Tour\TourPackage;
use App\Models\User;
use App\Models\Utilities\Category;
use App\Models\Utilities\City;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => RolesEnums::SUPERADMIN->value]);
    $this->admin = User::factory()->create();
    $this->admin->assignRole(RolesEnums::SUPERADMIN);
});

test('admin can view tours list', function () {
    TourPackage::factory()->count(3)->create();

    $response = $this->actingAs($this->admin)->get(route('admin.tours.index'));

    $response->assertStatus(200);
});

test('admin can view create tour form', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.tours.create'));

    $response->assertStatus(200);
});

test('admin can store a new tour package', function () {
    $city = City::factory()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($this->admin)->post(route('admin.tours.store'), [
        'title' => 'Sahara Desert Adventure',
        'duration_days' => 5,
        'description' => 'A wonderful trek across the Moroccan dunes.',
        'adults_count' => 2,
        'children_count' => 0,
        'city_ids' => [$city->id],
        'category_ids' => [$category->id],
    ]);

    $response->assertRedirect(route('admin.tours.index'));
    $this->assertDatabaseHas('tour_packages', [
        'title' => 'Sahara Desert Adventure',
        'duration_days' => 5,
    ]);
});

test('admin can view edit tour form', function () {
    $tour = TourPackage::factory()->create();

    $response = $this->actingAs($this->admin)->get(route('admin.tours.edit', $tour));

    $response->assertStatus(200);
});

test('admin can update a tour package', function () {
    $tour = TourPackage::factory()->create(['title' => 'Old Title']);

    $response = $this->actingAs($this->admin)->put(route('admin.tours.update', $tour), [
        'title' => 'New Title Updated',
        'duration_days' => 7,
        'description' => 'Updated adventure description.',
        'adults_count' => 4,
        'children_count' => 2,
    ]);

    $response->assertRedirect(route('admin.tours.index'));
    $this->assertDatabaseHas('tour_packages', [
        'id' => $tour->id,
        'title' => 'New Title Updated',
        'duration_days' => 7,
    ]);
});

test('admin can delete a tour package', function () {
    $tour = TourPackage::factory()->create();

    $response = $this->actingAs($this->admin)->delete(route('admin.tours.destroy', $tour));

    $response->assertRedirect(route('admin.tours.index'));
    $this->assertDatabaseMissing('tour_packages', [
        'id' => $tour->id,
    ]);
});
