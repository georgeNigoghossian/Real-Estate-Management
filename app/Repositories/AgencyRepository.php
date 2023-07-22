<?php

namespace App\Repositories;

use App\Models\Agency\Agency;
use App\Models\User;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\Validator;

//use Your Model

/**
 * Class UserRepository.
 */
class AgencyRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Agency::class;
    }

    public function show(Agency $agency): Agency
    {
        return $agency;
    }
}
