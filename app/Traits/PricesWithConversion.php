<?php

namespace App\Traits;

use App\Enums\Utilities\ConversionCurrencyType;
use App\Services\CurrencyConversionService;

trait PricesWithConversion
{

    /**
     * Get formatted price with currency symbol
     */
    public function getFormattedPriceAttribute(): string
    {
        return $this->currency?->format($this->amount);
    }

    /**
     * Get formatted price with currency code
     */
    public function getFormattedPriceWithCodeAttribute(): string
    {
        return $this->currency?->format($this->amount, true);
    }

    /**
     * Get localized formatted price
     */
    public function getLocalizedPriceAttribute(): string
    {
        return $this->currency?->formatLocalized($this->amount);
    }

    /**
     * Get actual decimal amount (e.g., convert cents to dollars)
     */
    public function getDecimalAmountAttribute(): float
    {
        return $this->amount / $this->currency?->getDivisor();
    }

    /**
     * Convert price to another currency
     */
    public function convertTo(ConversionCurrencyType $targetCurrency): array
    {
        $service = app(CurrencyConversionService::class);
        $convertedAmount = $service->convert(
            $this->amount,
            $this->currency,
            $targetCurrency
        );

        return [
            'amount' => $convertedAmount,
            'currency' => $targetCurrency,
            'formatted' => $targetCurrency->format($convertedAmount * $targetCurrency->getDivisor()),
            'exchange_rate' => $service->getExchangeRate($this->currency, $targetCurrency),
        ];
    }

    /**
     * Get price in multiple currencies
     */
    public function inCurrencies(array $currencies): array
    {
        $results = [];
        foreach ($currencies as $currency) {
            if (is_string($currency)) {
                $currency = ConversionCurrencyType::from($currency);
            }
            $results[$currency->value] = $this->convertTo($currency);
        }
        return $results;
    }

    /**
     * Check if price is expired
     */
    public function isExpired(): bool
    {
        return $this->expired_at && $this->expired_at->isPast();
    }

    /**
     * Scope for active prices
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')
                    ->orWhere('expired_at', '>', now());
            });
    }

    /**
     * Scope for specific currency
     */
    public function scopeCurrency($query, ConversionCurrencyType|string $currency)
    {
        $currencyValue = $currency instanceof ConversionCurrencyType
            ? $currency->value
            : $currency;

        return $query->where('currency', $currencyValue);
    }

    /**
     * Static method to create price from decimal amount
     */
    public static function fromDecimal(
        float $amount,
        ConversionCurrencyType $currency,
        array $attributes = []
    ): self {
        return new self(array_merge($attributes, [
            'amount' => (int) round($amount * $currency->getDivisor()),
            'currency' => $currency,
        ]));
    }
}
