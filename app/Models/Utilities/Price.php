<?php

namespace App\Models\Utilities;

use App\Casts\MoneyCast;
use App\Enums\Utilities\CurrencyType;
use App\Traits\GetModelByKeyName;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Price extends Model
{
    //

    use UuidGenerator;
    use GetModelByKeyName;

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
            'expired_at' => 'datetime',
            'options' => AsArrayObject::class,
            'currency' => CurrencyType::class,
            'amount' => MoneyCast::class,
        ];
    }

    public function priceable(): MorphTo
    {
        return $this->morphTo();
    }

    
    public function getFormattedPriceAttribute(): string
    {
        return $this->currency->format($this->amount / 100);
    }
}
