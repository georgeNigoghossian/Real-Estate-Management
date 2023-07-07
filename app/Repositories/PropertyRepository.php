<?php

namespace App\Repositories;

use App\Models\Property\Property;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


class PropertyRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the Property model
     */
    public function model(): string
    {
        return Property::class;
    }

    public function store($data)
    {
        return Property::create($data);
    }

    public function show(Property $property): Property
    {
        return $property;
    }

    public function update($data,Property $property): Property
    {
         $property->update($data);
         return $property;
    }
    public function destroy(Property $property)
    {
        $property->delete();
    }
    public function changeStatus($property,$status)
    {
        $property->update($status);
        return $property;
    }
}
