<?php

namespace App\Traits;

use App\Models\Utilities\Amenity;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasAmenities
{
    /**
     * Get all of the amenities for the establishment.
     */
    public function amenities(): MorphToMany
    {
        return $this->morphToMany(Amenity::class, 'amenitable');
    }
}
