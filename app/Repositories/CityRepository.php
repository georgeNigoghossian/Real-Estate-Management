<?php

namespace App\Repositories;

use App\Models\Agency\Agency;
use App\Models\Location\City;
use App\Models\User;
use Igaster\LaravelCities\Geo;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\Validator;

//use Your Model

/**
 * Class UserRepository.
 */
class CityRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Geo::class;
    }

    public function getNotCountries(){
        return Geo::where('level', '!=', 'PCLI')->get();
    }

    public function getTree(){
        $res = [];
        $locations = $this->getNotCountries();
        $countries = Geo::getCountries();
        foreach ($countries as $country) {
            $res[$country->country] = ['name'=> $country->name, 'cities'=>[]];
        }
        foreach ($locations as $location){
            array_push($res[$location->country]['cities'], $location);
        }
        return $res;
    }

}
