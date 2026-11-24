<?php

namespace App\Models\Tour;

use App\Traits\CanBeBooked;
use App\Traits\GetModelByKeyName;
use App\Traits\HasAmenities;
use App\Traits\HasPrices;
use App\Traits\HasSlug;
use App\Traits\UuidGenerator;
use Database\Factories\Tour\AccommodationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Accommodation extends Model implements HasMedia
{
    use CanBeBooked;

    use GetModelByKeyName;
    use HasAmenities;
    /** @use HasFactory<AccommodationFactory> */
    use HasFactory;
    use HasPrices;
    use HasSlug;
    use InteractsWithMedia;
    use UuidGenerator;

    protected $fillable = [
        'tour_package_id',
        'name',
        'slug',
        'capacity',
        'quantity',
        'description',
        'sort_order',
        'is_active',
        'is_featured',
    ];

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
            'is_featured' => 'boolean',
            'capacity' => 'integer',
            'quantity' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function tourPackage(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('accommodation_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg', 'image/gif']);
    }
}
