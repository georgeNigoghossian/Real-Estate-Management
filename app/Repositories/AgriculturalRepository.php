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
        $agricultural = Agricultural::create($data);
        $agricultural->property()->associate($property);
        $agricultural->save();

        return $agricultural;
    }

    public function show(Agricultural $agricultural): Agricultural
    {
        return $agricultural;
    }

    public function update($data, Agricultural $agricultural): Agricultural
    {
        $agricultural->update($data);
        return $agricultural;
    }

    public function destroy(Agricultural $agricultural): void
    {
        $agricultural->delete();
    }
}
