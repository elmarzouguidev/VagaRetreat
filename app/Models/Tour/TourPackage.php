<?php

namespace App\Models\Tour;

use App\Models\User;
use App\Models\Utilities\Amenity;
use App\Models\Utilities\Category;
use App\Models\Utilities\City;
use App\Traits\canBeBooked;
use App\Traits\GetModelByKeyName;
use App\Traits\hasPrices;
use App\Traits\HasSlug;
use App\Traits\UuidGenerator;
use App\Traits\hasReviews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TourPackage extends Model  implements HasMedia
{
    /** @use HasFactory<\Database\Factories\Tour\TourPackageFactory> */
    use HasFactory;

    use UuidGenerator;
    use GetModelByKeyName;
    use hasPrices;
    use HasSlug;
    use canBeBooked;
    use hasReviews;
    use InteractsWithMedia;

    public $slugName = 'title';
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_at' => 'date',
            'end_at' => 'date',
            'is_active' => 'boolean',
            'is_valid' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tourPlans(): HasMany
    {
        return $this->hasMany(TourPackagePlan::class);
    }

    public function accommodations(): HasMany
    {
        return $this->hasMany(Accommodation::class);
    }

    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'tour_package_city');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_tour_package');
    }

 

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('tour_package_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg', 'image/svg', 'image/gif', 'image/bmp', 'image/tiff', 'image/avif']);
    }
}
