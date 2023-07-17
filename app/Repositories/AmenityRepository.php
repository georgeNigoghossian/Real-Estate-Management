<?php

namespace App\Repositories;

use App\Models\Property\Amenity;
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

    public function show(Amenity $amenity): Amenity
    {
        return $amenity;
    }

    public function update($data, Amenity $amenity): Amenity
    {
        $amenity->update($data);
        return $amenity;
    }

    public function destroy(Amenity $amenity)
    {
        $amenity->delete();
    }

    public function get_all($custom_cond = []){


        if(count($custom_cond)>0){
            $custom_cond= implode(' AND ', $custom_cond);

            $tags = Amenity::whereRaw($custom_cond)->get();
        }else{
            $tags = Amenity::all();
        }

        return $tags;
    }

}
