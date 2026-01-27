<?php

use App\Models\Tour\TourPackage;
use App\Models\Utilities\Country;
use App\Models\Utilities\City;
use App\Models\Utilities\Category;

test('can search tours by country', function () {
    $country = Country::factory()->create(['name' => 'Morocco']);
    $city = City::factory()->create(['country_id' => $country->id]);
    
    $tourInMorocco = TourPackage::factory()->create();
    $tourInMorocco->cities()->attach($city->id);

    // Create a tour in another country
    $span = Country::factory()->create(['name' => 'Spain']);
    $spanishCity = City::factory()->create(['country_id' => $span->id]);
    $tourInSpain = TourPackage::factory()->create();
    $tourInSpain->cities()->attach($spanishCity->id);
    
    // Check if we can search by country ID
    $response = $this->getJson(route('api.search.index', ['country_id' => $country->id]));
    
    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $tourInMorocco->id);
});

test('can search tours by category', function () {
    $category = Category::factory()->create(['name' => 'Hiking']);
    $hikingTour = TourPackage::factory()->create();
    $hikingTour->categories()->attach($category->id);

    $otherTour = TourPackage::factory()->create(); // No category

    $response = $this->getJson(route('api.search.index', ['category_id' => $category->id]));

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $hikingTour->id);
});
