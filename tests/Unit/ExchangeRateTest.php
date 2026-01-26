<?php

use App\Models\Utilities\ExchangeRate;

uses()->group('exchange-rate');

test('checks if rate is expired', function () {
    $expiredRate = ExchangeRate::create([
        'from_currency' => 'USD',
        'to_currency' => 'EUR',
        'rate' => 0.85,
        'expires_at' => now()->subDay(),
    ]);

    $activeRate = ExchangeRate::create([
        'from_currency' => 'USD',
        'to_currency' => 'GBP',
        'rate' => 0.73,
        'expires_at' => now()->addDay(),
    ]);

    expect($expiredRate->isExpired())->toBeTrue()
        ->and($activeRate->isExpired())->toBeFalse();
});

test('scope returns only active rates', function () {
    ExchangeRate::create([
        'from_currency' => 'USD',
        'to_currency' => 'EUR',
        'rate' => 0.85,
        'expires_at' => now()->subDay(),
    ]);

    $activeRate = ExchangeRate::create([
        'from_currency' => 'USD',
        'to_currency' => 'GBP',
        'rate' => 0.73,
        'expires_at' => now()->addDay(),
    ]);

    $activeRates = ExchangeRate::active()->get();

    expect($activeRates)->toHaveCount(1)
        ->and($activeRates->first()->id)->toBe($activeRate->id);
});

test('calculates inverse rate', function () {
    $rate = ExchangeRate::create([
        'from_currency' => 'USD',
        'to_currency' => 'EUR',
        'rate' => 0.85,
        'expires_at' => now()->addDay(),
    ]);

    // 1 / 0.85 = 1.17647...
    // We expect 1.176 with a delta of 0.001 to allow for the precision
    expect($rate->inverse_rate)->toEqualWithDelta(1.176, 0.001);
});
