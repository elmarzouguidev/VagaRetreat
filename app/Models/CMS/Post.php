<?php

namespace App\Models\CMS;

use App\Models\User;
use App\Models\Utilities\Category;
use App\Traits\GetModelByKeyName;
use App\Traits\HasSlug;
use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\CMS\PostFactory> */
    use HasFactory;

    use UuidGenerator;
    use GetModelByKeyName;
    use HasSlug;
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
            'is_active' => 'boolean',
            'is_valid' => 'boolean',
            'published_at' => 'date'
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'post_category');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cms_post_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg', 'image/svg', 'image/gif', 'image/bmp', 'image/tiff', 'image/avif']);
    }
}
