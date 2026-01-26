<?php

use App\Enums\Utilities\ConversionCurrencyType;
use App\Models\Utilities\ExchangeRate;
use App\Services\CurrencyConversionService;
use Illuminate\Support\Facades\Http;

uses()->group('currency');

beforeEach(function () {
    $this->service = app(CurrencyConversionService::class);
    // Clear cache/DB between tests if needed, though Laravel handles transactions
});

test('converts same currency returns same amount', function () {
    // 10000 = $100.00
    $result = $this->service->convert(10000, ConversionCurrencyType::USD, ConversionCurrencyType::USD);

    expect($result)->toBe(10000.0);
});

test('converts between currencies using cached rate', function () {
    ExchangeRate::create([
        'from_currency' => 'USD',
        'to_currency' => 'EUR',
        'rate' => 0.85,
        'expires_at' => now()->addDay(),
    ]);

    // $100.00 (10000) * 0.85 = 8500.0 (85.00 EUR)
    $result = $this->service->convert(10000, ConversionCurrencyType::USD, ConversionCurrencyType::EUR);

    expect($result)->toBe(8500.0);
});

test('fetches rate from api when not cached', function () {
    // 1. Clear the cache and DB to ensure it MUST hit the API
    \Illuminate\Support\Facades\Cache::flush();
    \App\Models\Utilities\ExchangeRate::truncate();

    // 2. Mock the specific Primary API URL structure
    Http::fake([
        'v6.exchangerate-api.com/*' => Http::response([
            'result' => 'success',
            'conversion_rate' => 0.85, // We want exactly 0.85
        ], 200),
    ]);

    // 3. Act: $100.00 (10000) * 0.85
    $result = $this->service->convert(10000, ConversionCurrencyType::USD, ConversionCurrencyType::EUR);

    // 4. Assert: 10000 * 0.85 = 8500.0
    expect($result)->toEqual(8500.0)
        ->and(
            ExchangeRate::where('from_currency', 'USD')
                ->where('to_currency', 'EUR')
                ->where('rate', 0.85)
                ->exists()
        )->toBeTrue();
});

test('gets all rates for base currency', function () {
    ExchangeRate::create([
        'from_currency' => 'USD',
        'to_currency' => 'EUR',
        'rate' => 0.85,
        'expires_at' => now()->addDay(),
    ]);

    ExchangeRate::create([
        'from_currency' => 'USD',
        'to_currency' => 'GBP',
        'rate' => 0.73,
        'expires_at' => now()->addDay(),
    ]);

    $rates = $this->service->getAllRates(ConversionCurrencyType::USD);

    expect($rates)
        ->toBeArray()
        ->toHaveKey('EUR')
        ->toHaveKey('GBP')
        ->and((float)$rates['EUR'])->toBe(0.85)
        ->and((float)$rates['GBP'])->toBe(0.73);
});

test('uses fallback rate when api fails', function () {
    // Create an expired rate
    ExchangeRate::create([
        'from_currency' => 'USD',
        'to_currency' => 'EUR',
        'rate' => 0.80,
        'expires_at' => now()->subDay(),
    ]);

    // Force all API attempts to fail
    Http::fake(['*' => Http::response([], 500)]);

    $result = $this->service->convert(10000, ConversionCurrencyType::USD, ConversionCurrencyType::EUR);

    // Should successfully fall back to 0.80 rate
    expect($result)->toBe(8000.0);
});
