<?php

namespace App\Services;

use App\Enums\Utilities\ConversionCurrencyType;

use App\Models\Utilities\ExchangeRate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyConversionService
{
    protected string $apiKey;
   // protected string $apiUrl = 'https://api.exchangerate-api.com/v4/latest/'; // or Frankfurter (Free, Unlimited) :"https://api.frankfurter.app/latest",
   // protected string $apiUrl = 'https://api.frankfurter.app/latest';
    public function __construct()
    {
        //$this->apiKey = config('services.exchange_rate.api_key');
    }

    /**
     * Convert amount from one currency to another
     */
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

    /**
     * Get exchange rate between two currencies
     */
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

            // Fetch from API
            return $this->fetchRateFromApi($from, $to);
        });
    }

    /**
     * Fetch exchange rate from external API
     */
    protected function fetchRateFromApi(ConversionCurrencyType $from, ConversionCurrencyType $to): float
    {
        try {
            $response = Http::timeout(10)->get($this->apiUrl . $from->value);

            if ($response->successful()) {
                $data = $response->json();
                $rate = $data['rates'][$to->value] ?? null;

                if ($rate) {
                    // Store in database for future use
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

                    return $rate;
                }
            }
        } catch (\Exception $e) {
            Log::error('Currency conversion API error: ' . $e->getMessage());
        }

        // Fallback to stored rates if API fails
        $storedRate = ExchangeRate::where('from_currency', $from->value)
            ->where('to_currency', $to->value)
            ->latest()
            ->first();

        if ($storedRate) {
            return $storedRate->rate;
        }

        throw new \Exception("Unable to fetch exchange rate for {$from->value} to {$to->value}");
    }

    /**
     * Get all rates for a base currency
     */
    public function getAllRates(ConversionCurrencyType $baseCurrency): array
    {
        $rates = [];
        foreach (ConversionCurrencyType::cases() as $currency) {
            if ($currency !== $baseCurrency) {
                $rates[$currency->value] = $this->getExchangeRate($baseCurrency, $currency);
            }
        }
        return $rates;
    }

    /**
     * Refresh all exchange rates
     */
    public function refreshRates(): void
    {
        foreach (ConversionCurrencyType::cases() as $from) {
            foreach (ConversionCurrencyType::cases() as $to) {
                if ($from !== $to) {
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
