<?php

namespace App\Models\Utilities;

use App\Casts\MoneyCast;
use App\Enums\Utilities\ConversionCurrencyType;
use App\Models\Booking\Booking;
use App\Traits\GetModelByKeyName;
use App\Traits\HasSlug;
use App\Traits\PricesWithConversion;
use App\Traits\UuidGenerator;
use Database\Factories\Utilities\PriceFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Price extends Model
{
    use GetModelByKeyName;

    /** @use HasFactory<PriceFactory> */
    use HasFactory;
    use HasSlug;
    use PricesWithConversion;
    use UuidGenerator;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_valid' => 'boolean',
            'is_default' => 'boolean',
            'expired_at' => 'datetime',
            'options' => AsArrayObject::class,
            // 'currency' => CurrencyType::class,
            'currency' => ConversionCurrencyType::class, // used with conversion Rate
            'amount' => MoneyCast::class,
        ];
    }

    public function priceable(): MorphTo
    {
        return $this->morphTo();
    }

    public function bookings(): HasMany
    {

        return $this->hasMany(Booking::class);
    }

    /*public function getFormattedPriceAttribute(): string
    {
        return $this->currency->format($this->amount / 100);
    }*/
}
