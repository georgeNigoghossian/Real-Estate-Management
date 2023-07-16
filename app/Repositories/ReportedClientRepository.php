<?php

namespace App\Repositories;

use App\Models\ReportedClient;
use App\Models\User;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\Validator;

//use Your Model

/**
 * Class UserRepository.
 */
class ReportedClientRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return ReportedClient::class;
    }

    public function get_all($custom_cond = []){
        if(count($custom_cond)>0){
            $custom_cond= implode(' AND ', $custom_cond);

            $users = ReportedClient::whereRaw($custom_cond)->get();
        }else{
            $users = ReportedClient::all();
        }

        return $users;
    }

}
