<?php

namespace Database\Seeders;

use App\Models\Utilities\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // **Major Cities**
            ['name' => 'Casablanca', 'country_id' => 1],
            ['name' => 'Rabat', 'country_id' => 1],
            ['name' => 'Marrakech', 'country_id' => 1],
            ['name' => 'Fes', 'country_id' => 1],
            ['name' => 'Tangier', 'country_id' => 1],
            ['name' => 'Agadir', 'country_id' => 1],
            ['name' => 'Meknes', 'country_id' => 1],
            ['name' => 'Oujda', 'country_id' => 1],
            ['name' => 'Kenitra', 'country_id' => 1],
            ['name' => 'Tetouan', 'country_id' => 1],
            ['name' => 'Safi', 'country_id' => 1],
            ['name' => 'El Jadida', 'country_id' => 1],
            ['name' => 'Nador', 'country_id' => 1],
            ['name' => 'Laayoune', 'country_id' => 1],
            ['name' => 'Dakhla', 'country_id' => 1],
            ['name' => 'Errachidia', 'country_id' => 1],
            ['name' => 'Ouarzazate', 'country_id' => 1],
            ['name' => 'Zagora', 'country_id' => 1],
            ['name' => 'Taroudant', 'country_id' => 1],

            // **Additional Cities and Towns**
            ['name' => 'Beni Mellal', 'country_id' => 1],
            ['name' => 'Khouribga', 'country_id' => 1],
            ['name' => 'Settat', 'country_id' => 1],
            ['name' => 'Berkane', 'country_id' => 1],
            ['name' => 'Larache', 'country_id' => 1],
            ['name' => 'Ksar El Kebir', 'country_id' => 1],
            ['name' => 'Sidi Kacem', 'country_id' => 1],
            ['name' => 'Taza', 'country_id' => 1],
            ['name' => 'Inezgane', 'country_id' => 1],
            ['name' => 'Khemisset', 'country_id' => 1],
            ['name' => 'Berrechid', 'country_id' => 1],
            ['name' => 'Asilah', 'country_id' => 1],
            ['name' => 'Chefchaouen', 'country_id' => 1],
            ['name' => 'Oued Zem', 'country_id' => 1],
            ['name' => 'Sefrou', 'country_id' => 1],
            ['name' => 'Midelt', 'country_id' => 1],
            ['name' => 'Azrou', 'country_id' => 1],
            ['name' => 'Tiznit', 'country_id' => 1],
            ['name' => 'Youssoufia', 'country_id' => 1],
            ['name' => 'Guelmim', 'country_id' => 1],
            ['name' => 'Tiflet', 'country_id' => 1],
            ['name' => 'Sidi Slimane', 'country_id' => 1],
            ['name' => 'Fnideq', 'country_id' => 1],
            ['name' => 'Bouskoura', 'country_id' => 1],
            ['name' => 'Temara', 'country_id' => 1],
            ['name' => 'Sale', 'country_id' => 1],
            ['name' => 'Skhirate', 'country_id' => 1],
            ['name' => 'Imintanoute', 'country_id' => 1],
            ['name' => 'Kelaat Sraghna', 'country_id' => 1],
            ['name' => 'Oulad Teima', 'country_id' => 1],
            ['name' => 'Ben Guerir', 'country_id' => 1],
            ['name' => 'Tafraout', 'country_id' => 1],
            ['name' => 'Demnate', 'country_id' => 1],
            ['name' => 'Benslimane', 'country_id' => 1],
            ['name' => 'Taounate', 'country_id' => 1],
            ['name' => 'Azemmour', 'country_id' => 1],
            ['name' => 'Oulad Ayad', 'country_id' => 1],
            ['name' => 'Zaio', 'country_id' => 1],
            ['name' => 'Targuist', 'country_id' => 1],
            ['name' => 'Jorf Lasfar', 'country_id' => 1],
            ['name' => 'Ben Slimane', 'country_id' => 1],
            ['name' => 'Tiztoutine', 'country_id' => 1],

            // **Smaller Towns and Villages**
            ['name' => 'Asni', 'country_id' => 1],
            ['name' => 'Tafraoute', 'country_id' => 1],
            ['name' => 'Imilchil', 'country_id' => 1],
            ['name' => 'Aït Benhaddou', 'country_id' => 1],
            ['name' => 'Merzouga', 'country_id' => 1],
            ['name' => 'Ifrane', 'country_id' => 1],
            ['name' => 'Azilal', 'country_id' => 1],
            ['name' => 'Khénifra', 'country_id' => 1],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
