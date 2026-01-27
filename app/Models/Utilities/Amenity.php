<?php

namespace App\Models\Utilities;

use App\Models\Tour\Accommodation;
use App\Models\Tour\TourPackage;
use App\Traits\GetModelByKeyName;
use App\Traits\HasSlug;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Amenity extends Model
{
    /** @use HasFactory<\Database\Factories\Utilities\AmenityFactory> */
    use HasFactory;

    use UuidGenerator;
    use GetModelByKeyName;
    use HasSlug;

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
        ];
    }

    /**
     * Get all of the accommodations that are assigned this amenity.
     */
    public function accommodations(): MorphToMany
    {
        return $this->morphedByMany(Accommodation::class, 'amenitable');
    }

    /**
     * Get all of the tourPackages that are assigned this amenity.
     */
    public function tourPackages(): MorphToMany
    {
        return $this->morphedByMany(TourPackage::class, 'amenitable');
    }
}
