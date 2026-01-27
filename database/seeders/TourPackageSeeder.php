<?php

namespace Database\Seeders;

use App\Models\Tour\TourPackage;
use App\Models\User;
use App\Models\Utilities\Amenity;
use App\Models\Utilities\Category;
use App\Models\Utilities\City;
use App\Models\Utilities\Price;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TourPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have a user to own these tours
        $user = User::first() ?? User::factory()->create([
            'name' => 'Tour Admin',
            'email' => 'admin@vaga-retreat.com',
        ]);

        $tours = [
            [
                'title' => '8-Day High Atlas Mountains Trekking Adventure',
                'description' => 'Experience the breathtaking beauty of the High Atlas Mountains. Trek through traditional Berber villages, cross high passes, and enjoy stunning views of North Africa\'s highest peaks. This journey offers a perfect blend of physical challenge and cultural immersion.',
                'duration_days' => 8,
                'thumbnail' => 'https://images.unsplash.com/photo-1531804055935-76f44d7c3621?auto=format&fit=crop&q=80&w=800',
                'categories' => ['Hiking', 'Adventure'],
                'cities' => ['Marrakech', 'Asni', 'Midelt'],
                'price' => 850.00,
            ],
            [
                'title' => '7-Day Serene Yoga & Meditation Retreat in Chefchaouen',
                'description' => 'Find your inner peace in the Blue City of Chefchaouen. Our retreat offers daily yoga sessions, guided meditation, and healthy organic meals, all set against the backdrop of the stunning Rif Mountains. Perfect for those looking to disconnect and recharge.',
                'duration_days' => 7,
                'thumbnail' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&q=80&w=800',
                'categories' => ['Yoga', 'Wellness'],
                'cities' => ['Chefchaouen'],
                'price' => 1200.00,
            ],
            [
                'title' => 'Surf & Soul: 5-Day Yoga and Surfing in Taghazout',
                'description' => 'Combine the energy of surfing with the mindfulness of yoga in the world-famous surf village of Taghazout. Catch the Atlantic waves by morning and soothe your soul with sunset yoga sessions overlooking the ocean. Suitable for all levels.',
                'duration_days' => 5,
                'thumbnail' => 'https://images.unsplash.com/photo-1502680390469-be75c86b636f?auto=format&fit=crop&q=80&w=800',
                'categories' => ['Surf', 'Yoga', 'Adventure'],
                'cities' => ['Agadir'],
                'price' => 650.00,
            ],
            [
                'title' => 'Cultural Gems of Andalusia: Seville to Malaga',
                'description' => 'A week-long journey through the heart of Andalusia. Explore the majestic Alcázar of Seville, the historic center of Malaga, and the white villages of the Sierra Nevada. A deep dive into Spanish history, art, and gastronomy.',
                'duration_days' => 7,
                'thumbnail' => 'https://images.unsplash.com/photo-1533929736458-ca588d08c8be?auto=format&fit=crop&q=80&w=800',
                'categories' => ['Cultural'],
                'cities' => ['Seville', 'Malaga'],
                'price' => 1450.00,
            ],
            [
                'title' => 'Coastal Escape: Lisbon & Algarve Wellness Journey',
                'description' => 'Discover the best of Portugal with this wellness-focused escape. Start in the vibrant streets of Lisbon before heading south to the stunning cliffs and beaches of the Algarve for a few days of relaxation and spa treatments.',
                'duration_days' => 6,
                'thumbnail' => 'https://images.unsplash.com/photo-1555881400-74d7acaacd8b?auto=format&fit=crop&q=80&w=800',
                'categories' => ['Wellness', 'Cultural'],
                'cities' => ['Lisbon', 'Albufeira', 'Faro'],
                'price' => 1100.00,
            ],
        ];

        foreach ($tours as $tourData) {
            $categories = $tourData['categories'];
            $cities = $tourData['cities'];
            $priceAmount = $tourData['price'];

            unset($tourData['categories'], $tourData['cities'], $tourData['price']);

            $tourData['excerpt'] = Str::limit($tourData['description'], 150);
            $tourData['location'] = $cities[0];
            $tourData['user_id'] = $user->id;
            $tourData['is_active'] = true;
            $tourData['is_valid'] = true;
            $tourData['is_featured'] = rand(0, 1);
            $tourData['start_at'] = now()->addDays(rand(10, 60));
            $tourData['end_at'] = (clone $tourData['start_at'])->addDays($tourData['duration_days']);

            $tour = TourPackage::create($tourData);

            // Attach Categories
            $categoryIds = Category::whereIn('name', $categories)->pluck('id');
            $tour->categories()->attach($categoryIds);

            // Attach Cities
            $cityIds = City::whereIn('name', $cities)->pluck('id');
            $tour->cities()->attach($cityIds);

            // Create Price
            $tour->prices()->create([
                'amount' => (int) ($priceAmount * 100),
                'name' => "price per persone",
                'currency' => 'USD',
                'is_active' => true,
            ]);

            // Create Accommodations
            $accommodationTypes = [
                [
                    'name' => 'Standard Shared Room',
                    'capacity' => 2,
                    'quantity' => 5,
                    'description' => 'Comfortable shared accommodation with modern amenities.',
                    'sort_order' => 1,
                    'amenities' => ['wifi', 'terrace'],
                ],
                [
                    'name' => 'Private Single Room',
                    'capacity' => 1,
                    'quantity' => 2,
                    'description' => 'A quiet and private room for solo travelers.',
                    'sort_order' => 2,
                    'amenities' => ['wifi', 'parking', 'terrace', 'wheelchair-accessible']
                ],
                [
                    'name' => 'Eco-Friendly Cabin',
                    'capacity' => 2,
                    'quantity' => 3,
                    'description' => 'Sustainable lodging with a beautiful view.',
                    'sort_order' => 3,
                    'amenities' => ['wifi', 'parking', 'swimming-pool', 'spa', 'gym', 'restaurant', 'bar', 'room-service', '24-7-front-desk']
                ],
                [
                    'name' => 'Deluxe Suite',
                    'capacity' => 2,
                    'quantity' => 2,
                    'description' => 'Premium suite with extra space and luxury features.',
                    'sort_order' => 4,
                    'amenities' => ['wifi', 'parking', 'swimming-pool', 'spa', 'gym', 'restaurant', '24-7-front-desk']
                ],
            ];

            foreach ($accommodationTypes as $accData) {

                $amenitySlugs = $accData['amenities'];

                unset($accData['amenities']);

                $accommodation = $tour->accommodations()->create($accData);

                // Add sample images to accommodation
                $sampleImages = [
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&q=80&w=800'
                ];

                foreach($sampleImages as $imageUrl) {
                    $accommodation->addMediaFromUrl($imageUrl)
                        ->preservingOriginal()
                        ->toMediaCollection('accommodation_images');
                }

                // Add price for the accommodation
                $accommodation->prices()->create([
                    'amount' => (int) (($priceAmount / 2 + rand(50, 200)) * 100),
                    'currency' => 'USD',
                    'is_active' => true,
                    'is_default' => true,
                ]);

                // Attach amenities
                $amenities = Amenity::whereIn('slug', $amenitySlugs)->get();
                $accommodation->amenities()->syncWithoutDetaching($amenities->pluck('id'));
            }
        }
    }
}
