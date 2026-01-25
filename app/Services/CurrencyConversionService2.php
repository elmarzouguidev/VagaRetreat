<?php

namespace App\Services;

use App\Enums\Utilities\ConversionCurrencyType;
use App\Models\Utilities\ExchangeRate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyConversionService2
{
    protected string $apiUrl = 'https://api.frankfurter.app/latest';

    // List of currencies supported by Frankfurter
    protected array $supportedCurrencies = [
        'USD', 'EUR', 'GBP', 'JPY', 'CHF', 'CAD', 'AUD', 'NZD',
        'SEK', 'NOK', 'DKK', 'CZK', 'PLN', 'HUF', 'RON', 'BGN',
        'TRY', 'ILS', 'ZAR', 'BRL', 'MXN', 'SGD', 'HKD', 'KRW',
        'CNY', 'INR', 'IDR', 'MYR', 'PHP', 'THB',
    ];

    public function convert(
        int|float $amount,
        ConversionCurrencyType $from,
        ConversionCurrencyType $to
    ): float {
        if ($from === $to) {
            return $amount;
        }

        $rate = $this->getExchangeRate($from, $to);
        return round($amount * $rate, $to->getDecimals());
    }

    public function getExchangeRate(ConversionCurrencyType $from, ConversionCurrencyType $to): float
    {
        $cacheKey = "exchange_rate_{$from->value}_{$to->value}";

        return Cache::remember($cacheKey, now()->addHours(1), function () use ($from, $to) {
            // Try to get from database first
            $rate = ExchangeRate::where('from_currency', $from->value)
                ->where('to_currency', $to->value)
                ->where('expires_at', '>', now())
                ->first();

            if ($rate) {
                return $rate->rate;
            }

            // Check if both currencies are supported
            if (!$this->isCurrencySupported($from->value) || !$this->isCurrencySupported($to->value)) {
                throw new \Exception("Currency pair {$from->value}/{$to->value} is not supported by the exchange rate provider");
            }

            // Fetch from API
            return $this->fetchRateFromApi($from, $to);
        });
    }

    protected function isCurrencySupported(string $currency): bool
    {
        return in_array($currency, $this->supportedCurrencies);
    }

    protected function fetchRateFromApi(ConversionCurrencyType $from, ConversionCurrencyType $to): float
    {
        try {
            $response = Http::timeout(10)->get($this->apiUrl, [
                'from' => $from->value,
                'to' => $to->value,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $rate = $data['rates'][$to->value] ?? null;

                if ($rate) {
                    $this->storeRate($from, $to, $rate);
                    return $rate;
                }
            }
        } catch (\Exception $e) {
            Log::error('Currency API error: ' . $e->getMessage());
        }

        return $this->getFallbackRate($from, $to);
    }

    protected function storeRate(ConversionCurrencyType $from, ConversionCurrencyType $to, float $rate): void
    {
        ExchangeRate::updateOrCreate(
            [
                'from_currency' => $from->value,
                'to_currency' => $to->value,
            ],
            [
                'rate' => $rate,
                'expires_at' => now()->addDay(),
            ]
        );
    }

    protected function getFallbackRate(ConversionCurrencyType $from, ConversionCurrencyType $to): float
    {
        $storedRate = ExchangeRate::where('from_currency', $from->value)
            ->where('to_currency', $to->value)
            ->latest()
            ->first();

        if ($storedRate) {
            Log::info("Using fallback rate for {$from->value} to {$to->value}");
            return $storedRate->rate;
        }

        throw new \Exception("Unable to fetch exchange rate for {$from->value} to {$to->value}");
    }

    public function getAllRates(ConversionCurrencyType $baseCurrency): array
    {
        $rates = [];
        foreach (ConversionCurrencyType::cases() as $currency) {
            if ($currency !== $baseCurrency) {
                try {
                    // Only fetch if both currencies are supported
                    if ($this->isCurrencySupported($baseCurrency->value) && 
                        $this->isCurrencySupported($currency->value)) {
                        $rates[$currency->value] = $this->getExchangeRate($baseCurrency, $currency);
                    } else {
                        Log::info("Skipping unsupported currency pair: {$baseCurrency->value}/{$currency->value}");
                    }
                } catch (\Exception $e) {
                    Log::warning("Failed to get rate for {$baseCurrency->value} to {$currency->value}: " . $e->getMessage());
                    continue;
                }
            }
        }
        return $rates;
    }

    public function refreshRates(): void
    {
        foreach (ConversionCurrencyType::cases() as $from) {
            foreach (ConversionCurrencyType::cases() as $to) {
                if ($from !== $to) {
                    // Only refresh supported currency pairs
                    if ($this->isCurrencySupported($from->value) && 
                        $this->isCurrencySupported($to->value)) {
                        Cache::forget("exchange_rate_{$from->value}_{$to->value}");
                        try {
                            $this->getExchangeRate($from, $to);
                        } catch (\Exception $e) {
                            Log::warning("Failed to refresh rate {$from->value} to {$to->value}");
                        }
                    }
                }
            }
        }
    }
}