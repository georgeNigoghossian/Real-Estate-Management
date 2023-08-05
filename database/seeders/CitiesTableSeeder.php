<?php

namespace Database\Seeders;

use App\Models\Location\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $json = file_get_contents(__DIR__.'\\Geo\\cities.json');

        $cities = json_decode($json,true);

        foreach($cities as $city){
            City::create([
                'id'=> $city['id'],
                'name' => $city['name'],
                'country_id' => $city['country_id'],
            ]);
        }
    }
}
