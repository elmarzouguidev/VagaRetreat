<?php

namespace App\Models\Booking;

use App\Enums\Booking\BookingStatusEnums;
use App\Models\User;
use App\Models\Utilities\Price;
use App\Traits\GetModelByKeyName;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\Booking\BookingFactory> */
    use HasFactory;

    use UuidGenerator;
    use GetModelByKeyName;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = 'BK-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4));
            }
        });
    }

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
            'status' => BookingStatusEnums::class,
        ];
    }

    public function bookable() :MorphTo
    {
        return $this->morphTo();
    }

    public function price():BelongsTo
    {
        return $this->belongsTo(Price::class);
    }   

    public function customer():BelongsTo
    {
        return $this->belongsTo(User::class,'customer_id');
    }   
}
