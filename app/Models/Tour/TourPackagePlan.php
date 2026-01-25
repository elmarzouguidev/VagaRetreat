<?php

namespace App\Models\Tour;

use App\Traits\GetModelByKeyName;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourPackagePlan extends Model
{
    //

    use UuidGenerator;
    use GetModelByKeyName;

    public $slugName = 'title';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'plan_date' => 'date',
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'is_active' => 'boolean',
            'is_valid' => 'boolean',
        ];
    }

    public function tourPackage(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class, 'tour_package_id');
    }
}
