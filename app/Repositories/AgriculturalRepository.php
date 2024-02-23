<?php

namespace App\Repositories;

use App\Models\Property\Agricultural;

class AgriculturalRepository
{
    /**
     * @return string
     *  Return the Property model
     */
    public function model(): string
    {
        return Agricultural::class;
    }

    public function store($data, $property)
    {
        if ($data['specialAttributes']) {
            $data['specialAttributes'] = json_decode($data['specialAttributes']);
        }
        $agricultural = Agricultural::create($data);
        $agricultural->property()->associate($property);
        $agricultural->save();

        return $agricultural;
    }

    public function show(Agricultural $agricultural): Agricultural
    {
        $agricultural->property->getMedia();
        return $agricultural;
    }

    public function update($data, Agricultural $agricultural): Agricultural
    {
        $agricultural->update($data);
        return $agricultural;
    }

    public function destroy(Agricultural $agricultural): void
    {
        $agricultural->property()->delete();
    }
}
