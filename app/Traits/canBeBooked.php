<?php

namespace App\Traits;

use App\Models\Booking\Booking;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait canBeBooked
{
    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
