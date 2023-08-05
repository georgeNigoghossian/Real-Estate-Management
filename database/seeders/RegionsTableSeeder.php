<?php

namespace Database\Seeders;

use App\Models\Location\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $json = file_get_contents(__DIR__.'\\Geo\\regions.json');

        $regions = json_decode($json,true);

        foreach($regions as $region){
            Region::create([
                'id'=> $region['id'],
                'name' => $region['name'],
                'city_id' => $region['city_id'],
            ]);
        }
    }
}
