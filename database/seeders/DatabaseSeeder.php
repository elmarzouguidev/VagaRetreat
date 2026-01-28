<?php

namespace Database\Seeders;

use App\Models\CMS\Post;
use App\Models\Utilities\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    //use WithoutModelEvents; if it enabled all boot event in models not work (UuidGenerator ....)

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $this->call(CountrySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(PageSeeder::class);

        $this->call(CategorySeeder::class);
        $this->call(AmenitySeeder::class);
        $this->call(TourPackageSeeder::class);
        
        // Seed CMS Posts and associate categories
        $categories = Category::all();
        Post::factory(10)->create()->each(function ($post) use ($categories) {
            $post->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );

            // Add sample images to post
            $post->addMediaFromUrl('https://images.unsplash.com/photo-1432821596592-e2c18b78144f?auto=format&fit=crop&q=80&w=800')
                ->preservingOriginal()
                ->toMediaCollection('cms_post_images');
        });
    }
}
