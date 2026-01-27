<?php

namespace App\Traits;

use App\Models\Utilities\Amenity;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait hasAmenities
{   
    
    /**
     * Get all of the amenities for the etablisement.
     */
    public function amenities(): MorphToMany
    {
        return $this->morphToMany(Amenity::class, 'amenitable');
    }

}
