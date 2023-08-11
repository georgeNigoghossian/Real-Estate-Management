<?php

namespace App\Repositories;

use App\Models\Agency\Agency;
use App\Models\AgencyRequest;
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
        $request = AgencyRequest::create([
            'reason'=> $data['reason'],
            'user_id'=> $user->id
        ]);
        $agency = Agency::create([
            'latitude'=>$data['latitude'],
            'longitude'=>$data['longitude'],
            'contact_info'=>null,
            'created_by'=>$user->id,
            'region_id'=>null,
        ]);
        $images = $data['files'];
        foreach ($images as $image) {
            $agency->addMedia($image)->toMediaCollection('images');
        }
        $agency->request = $request;
        return $agency;
    }

    public function verifyAgency($id)
    {
        return Agency::where('id',$id)->update(['is_verified'=>1]);
    }
    public function get_all($custom_cond = [], $perPage = 10) {
        $query = User::query()->has('agency')->with('agency');

        if (count($custom_cond) > 0) {
            $custom_cond = implode(' AND ', $custom_cond);
            $query = $query->whereRaw($custom_cond);
        }

        return $query->paginate($perPage);
    }

}
