<?php

namespace App\Repositories;

use App\Models\ReportedClient;
use App\Models\User;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function reportClient($reporting_user_id,$reported_user_id,$report_category_id,$description){

        $reportedClient = ReportedClient::create([
            'description'=>$description,
            'reporting_user_id'=>$reporting_user_id,
            'reported_user_id'=>$reported_user_id,
            'report_category_id'=>$report_category_id,
        ]);

        return $reportedClient;
    }

    public function deleteAccount($id){
        $user = User::find($id);
        if($user){
            $user->delete();
            return true;
        }else{
            return false;
        }


    }
}
