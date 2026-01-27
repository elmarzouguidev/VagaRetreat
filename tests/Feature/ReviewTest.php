<?php

use App\Models\User;
use App\Models\Tour\TourPackage;
use App\Models\Utilities\Review;

test('user can review a tour package', function () {
    $user = User::factory()->create();
    $tour = TourPackage::factory()->create();

    $review = Review::factory()->create([
        'user_id' => $user->id,
        'reviewable_type' => TourPackage::class,
        'reviewable_id' => $tour->id,
        'rating' => 5,
        'comment' => 'Great tour!',
    ]);

    expect($review->reviewable)->toBeInstanceOf(TourPackage::class)
        ->and($review->reviewable->id)->toBe($tour->id)
        ->and($review->user->id)->toBe($user->id);
});

test('user can review an instructor', function () {
    $user = User::factory()->create();
    $instructor = User::factory()->create(); // Acting as instructor

    $review = Review::factory()->create([
        'user_id' => $user->id,
        'reviewable_type' => User::class,
        'reviewable_id' => $instructor->id,
        'rating' => 4,
        'comment' => 'Good instructor.',
    ]);

    expect($review->reviewable)->toBeInstanceOf(User::class)
        ->and($review->reviewable->id)->toBe($instructor->id);
});
