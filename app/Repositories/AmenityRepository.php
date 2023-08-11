<?php

namespace App\Repositories;

use App\Models\Property\Amenity;
use App\Models\Property\AmenityType;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


class AmenityRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the Amenity model
     */
    public function model(): string
    {
        return Amenity::class;
    }

    public function store($data)
    {
        return Amenity::create($data);
    }

    public function storeAmityType($data)
    {
        return AmenityType::create($data);
    }
    public function show(Amenity $amenity): Amenity
    {
        return $amenity;
    }

    public function update($data, Amenity $amenity): Amenity
    {
        $amenity->update($data);
        return $amenity;
    }


    public function updateAmenityType($data, AmenityType $amenity_type): AmenityType
    {
        $amenity_type->update($data);
        return $amenity_type;
    }

    public function destroy(Amenity $amenity)
    {
        $amenity->delete();
    }


    public function destroyAmenityType(AmenityType $amenity_type)
    {
        $amenity_type->delete();
    }

    public function get_all($custom_cond = [], $perPage = 10) {
        $query = Amenity::query();

        if (count($custom_cond) > 0) {
            $custom_cond = implode(' AND ', $custom_cond);
            $query = $query->whereRaw($custom_cond);
        }

        return $query->paginate($perPage);
    }


    public function get_all_amenity_types($custom_cond = [], $perPage = 10) {
        $query = AmenityType::query();

        if (count($custom_cond) > 0) {
            $custom_cond = implode(' AND ', $custom_cond);
            $query = $query->whereRaw($custom_cond);
        }

        return $query->paginate($perPage);
    }



    public function changeActiveStatus($amenity_id,$status){
        $amenity = Amenity::where('id',$amenity_id)->update([
            'active'=>$status,
        ]);
        return $amenity;
    }

}
