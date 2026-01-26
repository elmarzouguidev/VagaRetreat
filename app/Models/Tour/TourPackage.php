<?php

namespace App\Models\Tour;

use App\Models\User;
use App\Traits\GetModelByKeyName;
use App\Traits\hasPrices;
use App\Traits\HasSlug;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourPackage extends Model
{
    /** @use HasFactory<\Database\Factories\Tour\TourPackageFactory> */
    use HasFactory;

    use UuidGenerator;
    use GetModelByKeyName;
    use hasPrices;
    use HasSlug;


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
}
