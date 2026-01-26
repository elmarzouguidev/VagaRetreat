<?php

use App\Enums\Utilities\ConversionCurrencyType;
use App\Models\Tour\TourPackage;
use App\Models\Utilities\ExchangeRate;
use App\Models\Utilities\Price;
use App\Services\CurrencyConversionService;
use Illuminate\Support\Facades\Http;

uses()->group('currency', 'mad');

describe('MAD Currency Conversions', function () {

    test('converts USD to MAD using cached rate', function () {
        ExchangeRate::create([
            'from_currency' => 'USD',
            'to_currency' => 'MAD',
            'rate' => 9.87,
            'expires_at' => now()->addDay(),
        ]);

        $service = app(CurrencyConversionService::class);
        $result = $service->convert(10000, ConversionCurrencyType::USD, ConversionCurrencyType::MAD);

        // 10000 cents = $100 USD
        // $100 * 9.87 = 987.00 MAD
        expect($result)->toBe(98700.0);
    });

    test('converts EUR to MAD using cached rate', function () {
        ExchangeRate::create([
            'from_currency' => 'EUR',
            'to_currency' => 'MAD',
            'rate' => 10.63,
            'expires_at' => now()->addDay(),
        ]);

        $service = app(CurrencyConversionService::class);
        $result = $service->convert(10000, ConversionCurrencyType::EUR, ConversionCurrencyType::MAD);

        // 10000 cents = €100 EUR
        // €100 * 10.63 = 1063.00 MAD
        expect($result)->toBe(106300.0);
    });

    test('fetches USD to MAD rate from ExchangeRate-API when not cached', function () {
        Http::fake([
            'v6.exchangerate-api.com/*' => Http::response([
                'result' => 'success',
                'base_code' => 'USD',
                'target_code' => 'MAD',
                'conversion_rate' => 9.87, // Changed from conversion_rates array
            ], 200),
        ]);

        $service = app(CurrencyConversionService::class);
        $result = $service->convert(10000, ConversionCurrencyType::USD, ConversionCurrencyType::MAD);

        expect($result)->toEqual(98700.0)
            ->and(
                ExchangeRate::where('from_currency', 'USD')
                    ->where('to_currency', 'MAD')
                    ->where('rate', 9.87)
                    ->exists()
            )->toBeTrue();
    });

    test('fetches EUR to MAD rate from ExchangeRate-API when not cached', function () {
        Http::fake([
            'v6.exchangerate-api.com/*' => Http::response([
                'result' => 'success',
                'conversion_rate' => 10.63, // Ensure this is singular!
            ], 200),
        ]);

        $service = app(CurrencyConversionService::class);
        $result = $service->convert(10000, ConversionCurrencyType::EUR, ConversionCurrencyType::MAD);

        expect($result)->toEqual(106300.0);
    });


    test('uses fallback database rate when all APIs fail for MAD', function () {
        // Create an old rate in database
        ExchangeRate::create([
            'from_currency' => 'USD',
            'to_currency' => 'MAD',
            'rate' => 9.50,
            'expires_at' => now()->subDay(), // Expired
        ]);

        // Mock all APIs to fail
        Http::fake([
            '*' => Http::response([], 500),
        ]);

        $service = app(CurrencyConversionService::class);
        $result = $service->convert(10000, ConversionCurrencyType::USD, ConversionCurrencyType::MAD);

        // Should use the fallback rate of 9.50
        expect($result)->toBe(95000.0);
    });

    test('formats MAD price correctly', function () {
        $price = Price::factory()->create([
            'amount' => 98700, // 987.00 MAD
            'currency' => ConversionCurrencyType::MAD,
        ]);

        $formatted = $price->formatted_price;

        expect($formatted)->toContain('987.00')
            ->and($formatted)->toContain('DH');
    });

    test('converts USD price to MAD', function () {
        ExchangeRate::create([
            'from_currency' => 'USD',
            'to_currency' => 'MAD',
            'rate' => 9.87,
            'expires_at' => now()->addDay(),
        ]);

        $price = Price::factory()->create([
            'amount' => 10000, // $100 USD
            'currency' => ConversionCurrencyType::USD,
        ]);

        $converted = $price->convertTo(ConversionCurrencyType::MAD);

        expect($converted)
            ->toBeArray()
            ->toHaveKey('amount')
            ->toHaveKey('currency')
            ->toHaveKey('formatted')
            ->toHaveKey('exchange_rate')
            ->and($converted['amount'])->toBe(98700.0)
            ->and($converted['currency'])->toBe(ConversionCurrencyType::MAD)
            ->and($converted['exchange_rate'])->toBe(9.87);
    });

    test('converts EUR price to MAD', function () {
        ExchangeRate::create([
            'from_currency' => 'EUR',
            'to_currency' => 'MAD',
            'rate' => 10.63,
            'expires_at' => now()->addDay(),
        ]);

        $price = Price::factory()->create([
            'amount' => 10000, // €100 EUR
            'currency' => ConversionCurrencyType::EUR,
        ]);

        $converted = $price->convertTo(ConversionCurrencyType::MAD);

        expect($converted)
            ->toBeArray()
            ->and($converted['amount'])->toBe(106300.0)
            ->and($converted['currency'])->toBe(ConversionCurrencyType::MAD)
            ->and($converted['exchange_rate'])->toBe(10.63);
    });

    test('gets multiple currency conversions including MAD', function () {
        ExchangeRate::create([
            'from_currency' => 'USD',
            'to_currency' => 'EUR',
            'rate' => 0.85,
            'expires_at' => now()->addDay(),
        ]);

        ExchangeRate::create([
            'from_currency' => 'USD',
            'to_currency' => 'MAD',
            'rate' => 9.87,
            'expires_at' => now()->addDay(),
        ]);

        ExchangeRate::create([
            'from_currency' => 'USD',
            'to_currency' => 'GBP',
            'rate' => 0.73,
            'expires_at' => now()->addDay(),
        ]);

        $price = Price::factory()->create([
            'amount' => 10000, // $100 USD
            'currency' => ConversionCurrencyType::USD,
        ]);

        $converted = $price->inCurrencies([
            ConversionCurrencyType::EUR,
            ConversionCurrencyType::MAD,
            ConversionCurrencyType::GBP,
        ]);

        expect($converted)
            ->toBeArray()
            ->toHaveKey('EUR')
            ->toHaveKey('MAD')
            ->toHaveKey('GBP')
            ->and($converted['EUR']['amount'])->toBe(8500.0)
            ->and($converted['MAD']['amount'])->toBe(98700.0)
            ->and($converted['GBP']['amount'])->toBe(7300.0);
    });

    test('money object converts USD to MAD', function () {
        ExchangeRate::create([
            'from_currency' => 'USD',
            'to_currency' => 'MAD',
            'rate' => 9.87,
            'expires_at' => now()->addDay(),
        ]);

        $usdMoney = money(10000, ConversionCurrencyType::USD);
        $madMoney = $usdMoney->convertTo(ConversionCurrencyType::MAD);

        expect($madMoney->currency)->toBe(ConversionCurrencyType::MAD)
            ->and($madMoney->amount)->toBe(98700.0)
            ->and((string) $madMoney)->toContain('987.00');
    });

    test('money object converts EUR to MAD', function () {
        ExchangeRate::create([
            'from_currency' => 'EUR',
            'to_currency' => 'MAD',
            'rate' => 10.63,
            'expires_at' => now()->addDay(),
        ]);

        $eurMoney = money(10000, ConversionCurrencyType::EUR);
        $madMoney = $eurMoney->convertTo(ConversionCurrencyType::MAD);

        expect($madMoney->currency)->toBe(ConversionCurrencyType::MAD)
            ->and($madMoney->amount)->toBe(106300.0);
    });

    test('calculates MAD amounts in money operations', function () {
        $mad1 = money(50000, ConversionCurrencyType::MAD); // 500 DH
        $mad2 = money(30000, ConversionCurrencyType::MAD); // 300 DH

        $total = $mad1->add($mad2);
        $difference = $mad1->subtract($mad2);
        $doubled = $mad1->multiply(2);
        $half = $mad1->divide(2);

        expect($total->amount)->toBe(80000) // 800 DH
            ->and($difference->amount)->toBe(20000) // 200 DH
            ->and($doubled->amount)->toBe(100000) // 1000 DH
            ->and($half->amount)->toBe(25000); // 250 DH
    });

    test('compares MAD prices correctly', function () {
        $price1 = money(100000, ConversionCurrencyType::MAD); // 1000 DH
        $price2 = money(50000, ConversionCurrencyType::MAD);  // 500 DH

        expect($price1->isGreaterThan($price2))->toBeTrue()
            ->and($price2->isLessThan($price1))->toBeTrue()
            ->and($price1->equals($price2))->toBeFalse();
    });

    test('throws exception when MAD rate cannot be fetched and no fallback exists', function () {
        // 1. Clear DB to ensure no fallbacks
        ExchangeRate::truncate();

        // 2. Mock all APIs to fail
        Http::fake(['*' => Http::response([], 500)]);

        $service = app(CurrencyConversionService::class);

        // Use a closure so Pest can catch the thrown Exception
        expect(fn() => $service->convert(10000, ConversionCurrencyType::USD, ConversionCurrencyType::MAD))
            ->toThrow(Exception::class);
    });

    test('caches MAD exchange rates properly', function () {
        ExchangeRate::create([
            'from_currency' => 'USD',
            'to_currency' => 'MAD',
            'rate' => 9.87,
            'expires_at' => now()->addDay(),
        ]);

        $service = app(CurrencyConversionService::class);

        // First call - should cache
        $result1 = $service->convert(10000, ConversionCurrencyType::USD, ConversionCurrencyType::MAD);

        // Change the database rate
        ExchangeRate::where('from_currency', 'USD')
            ->where('to_currency', 'MAD')
            ->update(['rate' => 10.00]);

        // Second call - should use cached rate (9.87), not new rate (10.00)
        $result2 = $service->convert(10000, ConversionCurrencyType::USD, ConversionCurrencyType::MAD);

        expect($result1)->toBe(98700.0)
            ->and($result2)->toBe(98700.0); // Still using cached rate
    });

    test('real world example: TourPackage price in USD converted to MAD', function () {
        $tourPackage = TourPackage::factory()->create();

        $priceInUSD = Price::factory()->create([
            'priceable_id' => $tourPackage->id,
            'priceable_type' => TourPackage::class,
            'amount' => 9999, // $99.99
            'currency' => ConversionCurrencyType::USD,
        ]);

        ExchangeRate::create([
            'from_currency' => 'USD',
            'to_currency' => 'MAD',
            'rate' => 9.87,
            'expires_at' => now()->addDay(),
        ]);

        $madConversion = $priceInUSD->convertTo(ConversionCurrencyType::MAD);

        // 9999 * 9.87 = 98690.13 (cents)
        expect($madConversion['amount'])->toEqualWithDelta(98690.13, 0.01)
            ->and($madConversion['formatted'])->toContain('986.90')
            ->and($madConversion['formatted'])->toContain('DH');
    });

    test('real world example: TourPackage price in EUR converted to MAD', function () {
        $tourPackage = TourPackage::factory()->create();

        $priceInEUR = Price::factory()->create([
            'priceable_id' => $tourPackage->id,
            'priceable_type' => TourPackage::class,
            'amount' => 4999, // €49.99
            'currency' => ConversionCurrencyType::EUR,
        ]);

        ExchangeRate::create([
            'from_currency' => 'EUR',
            'to_currency' => 'MAD',
            'rate' => 10.63,
            'expires_at' => now()->addDay(),
        ]);

        $madConversion = $priceInEUR->convertTo(ConversionCurrencyType::MAD);

        // 4999 * 10.63 = 53139.37 (cents)
        expect($madConversion['amount'])->toEqualWithDelta(53139.37, 0.01)
            ->and($madConversion['formatted'])->toContain('531.39')
            ->and($madConversion['formatted'])->toContain('DH');
    });
});

// ============================================
// Additional Helper Test
// ============================================

test('helper function converts to MAD', function () {
    ExchangeRate::create([
        'from_currency' => 'USD',
        'to_currency' => 'MAD',
        'rate' => 9.87,
        'expires_at' => now()->addDay(),
    ]);

    $converted = convert_currency(10000, ConversionCurrencyType::USD, ConversionCurrencyType::MAD);

    expect($converted)->toBe(98700.0);
})->group('currency', 'mad', 'helper');

test('format_price works with MAD', function () {
    $formatted = format_price(98700, ConversionCurrencyType::MAD);

    expect($formatted)->toContain('987.00')
        ->and($formatted)->toContain('DH');
})->group('currency', 'mad', 'helper');
