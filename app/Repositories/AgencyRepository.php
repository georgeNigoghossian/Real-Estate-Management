<?php

namespace App\Repositories;

use App\Models\Agency\Agency;
use App\Models\File;
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
    public function model(): string
    {
        return Agency::class;
    }

    public function show(Agency $agency): Agency
    {
        $agency->getMedia();
        return $agency;
    }

    public function promote($data, $user): Agency
    {
        $agency = Agency::create([
            'latitude'=>$data['latitude'],
            'longitude'=>$data['longitude'],
            'created_by'=>$user->id,
            'region_id'=>$data['region_id'],
        ]);
        $images = $data['files'];
        foreach ($images as $image) {
            $agency->addMedia($image)->toMediaCollection('images');
        }
        return $agency;
    }

    public function verifyAgency($id)
    {
        return Agency::where('id',$id)->update(['is_verified'=>1]);
    }


}
