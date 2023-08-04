<?php

namespace App\Repositories;

use App\Models\Property\Residential;

class ResidentialRepository
{
    /**
     * @return string
     *  Return the Property model
     */
    public function model(): string
    {
        return Residential::class;
    }

    public function store($data, $property)
    {
        if ($data['specialAttributes']) {
            $data['specialAttributes'] = json_decode($data['specialAttributes']);
        }
        $residential = Residential::create($data);
        $residential->property()->associate($property);
        $residential->save();

        return $residential;
    }

    public function show(Residential $residential): Residential
    {
        $residential->property->getMedia();
        return $residential;
    }

    public function update($data, Residential $residential): Residential
    {
        $residential->update($data);
        return $residential;
    }

    public function destroy(Residential $residential): void
    {
        $residential->delete();
    }
}
