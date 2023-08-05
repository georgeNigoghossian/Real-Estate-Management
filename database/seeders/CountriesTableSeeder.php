<?php

namespace Database\Seeders;

use App\Models\Location\City;
use App\Models\Location\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $json = file_get_contents(__DIR__.'\\Geo\\countries.json');

        $countries = json_decode($json,true);

        foreach($countries as $country){
            Country::create([
                'id'=> $country['id'],
                'name' => $country['name'],
            ]);
        }
    }
}
