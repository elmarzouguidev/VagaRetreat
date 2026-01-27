<?php

namespace Database\Seeders;

use App\Models\Utilities\Amenity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            [
                'name' => 'Wifi',
                'slug' => 'wifi',
                'icon' => 'wifi',
                'description' => 'High-speed wireless internet access.',
            ],
            [
                'name' => 'Parking',
                'slug' => 'parking',
                'icon' => 'parking',
                'description' => 'Secure on-site parking available.',
            ],
            [
                'name' => 'Swimming Pool',
                'slug' => 'swimming-pool',
                'icon' => 'swimming-pool',
                'description' => 'Outdoor or indoor swimming pool.',
            ],
            [
                'name' => 'Air Conditioning',
                'slug' => 'air-conditioning',
                'icon' => 'air-conditioning',
                'description' => 'Climate control in all rooms.',
            ],
            [
                'name' => 'Restaurant',
                'slug' => 'restaurant',
                'icon' => 'restaurant',
                'description' => 'On-site dining options.',
            ],
            [
                'name' => 'Gym',
                'slug' => 'gym',
                'icon' => 'gym',
                'description' => 'Fitness center with modern equipment.',
            ],
            [
                'name' => 'Spa',
                'slug' => 'spa',
                'icon' => 'spa',
                'description' => 'Wellness and massage treatments.',
            ],
            [
                'name' => 'Bar',
                'slug' => 'bar',
                'icon' => 'bar',
                'description' => 'Lounge and bar area.',
            ],
            [
                'name' => '24/7 Front Desk',
                'slug' => '24-7-front-desk',
                'icon' => 'front-desk',
                'description' => 'Reception service available at all times.',
            ],
            [
                'name' => 'Room Service',
                'slug' => 'room-service',
                'icon' => 'room-service',
                'description' => 'Food and drink delivered to your room.',
            ],
            [
                'name' => 'Terrace',
                'slug' => 'terrace',
                'icon' => 'terrace',
                'description' => 'Outdoor terrace with view.',
            ],
            [
                'name' => 'Wheelchair Accessible',
                'slug' => 'wheelchair-accessible',
                'icon' => 'wheelchair',
                'description' => 'Facilities accessible for guests with reduced mobility.',
            ]
        ];

        foreach ($amenities as $amenity) {
            Amenity::firstOrCreate(
                ['slug' => $amenity['slug']],
                array_merge($amenity, ['is_active' => true])
            );
        }
    }
}
