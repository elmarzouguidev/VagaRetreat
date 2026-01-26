<?php

namespace App\Models\Utilities;

use App\Traits\GetModelByKeyName;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\Utilities\CategoryFactory> */
    use HasFactory;

    use UuidGenerator;
    use GetModelByKeyName;

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
}
