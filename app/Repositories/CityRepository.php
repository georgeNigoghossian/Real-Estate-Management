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

}
