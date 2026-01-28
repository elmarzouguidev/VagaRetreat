<?php

namespace Database\Seeders;

use App\Models\CMS\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class PageSeeder extends Seeder
{
      public function run(): void
    {
        $pages = [
            [
                'title' => "Privacy Policy",
                'slug' => 'privacy-policy',
                'body' => file_get_contents(resource_path() . '/pages/PolitiquedeConfidentialite.html')
            ],
            [
                'title' => "Legal Notice",
                'slug' => 'legal-notice',
                'body' => file_get_contents(resource_path() . '/pages/MentionsLegales.html')

            ],
            [
                'title' => "Terms and Conditions of Use",
                'slug' => 'terms-and-conditions',
                'body' => file_get_contents(resource_path() . '/pages/CGU.html')

            ],
            [
                'title' => "Introduction",
                'slug' => 'introduction',
                'body' => file_get_contents(resource_path() . '/pages/Introduction.html')
            ],
            [
                'title' => "About Us",
                'slug' => 'about-us',
                'body' => file_get_contents(resource_path() . '/pages/about-us.html')
            ]
        ];


        foreach ($pages as $page) {
           $model =  Page::create($page);

              $model->addMediaFromUrl('https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&q=80&w=800')
                ->preservingOriginal()
                ->toMediaCollection('cms_page_images');
        }
    }
}
