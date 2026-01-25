<?php

namespace App\Traits;

use App\Models\Utilities\Price;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait hasPrices
{
    public function prices(): MorphMany
    {
        return $this->morphMany(Price::class, 'priceable');
    }
}
