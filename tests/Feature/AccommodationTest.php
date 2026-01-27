<?php

use App\Models\Tour\Accommodation;
use App\Models\Tour\TourPackage;
use App\Models\Utilities\Price;

test('accommodation belongs to a tour package', function () {
    $tour = TourPackage::factory()->create();
    $accommodation = Accommodation::factory()->create(['tour_package_id' => $tour->id]);

    expect($accommodation->tourPackage)->toBeInstanceOf(TourPackage::class)
        ->and($accommodation->tourPackage->id)->toBe($tour->id);
});

test('accommodation can have prices', function () {
    $accommodation = Accommodation::factory()->create();
    
    $price = Price::factory()->create([
        'priceable_id' => $accommodation->id,
        'priceable_type' => Accommodation::class,
        'amount' => 10000, // $100.00
    ]);

    expect($accommodation->prices)->not->toBeEmpty()
        ->and($accommodation->prices->first()->amount)->toEqual(10000); // MoneyCast object comparison might need value check
});
