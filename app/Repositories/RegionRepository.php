<?php

namespace App\Repositories;

use App\Models\Agency\Agency;
use App\Models\Location\City;
use App\Models\Location\Country;
use App\Models\Location\Region;
use Igaster\LaravelCities\Geo;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

//use Your Model

/**
 * Class UserRepository.
 */
class RegionRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Region::class;
    }

    public function store($data)
    {
        return Region::create([
            'name'=>$data['name'],
            'city_id'=>$data['city_id'],
        ]);
    }
    public function getTree(){
        $locations = Country::with('cities.regions')->select('countries.name', 'countries.id')->get();
        return $locations;
    }

}
