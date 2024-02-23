<?php

namespace App\Repositories;

use App\Models\Property\Commercial;

class CommercialRepository
{
    /**
     * @return string
     *  Return the Property model
     */
    public function model(): string
    {
        return Commercial::class;
    }

    public function store($data, $property)
    {
        if ($data['specialAttributes']) {
            $data['specialAttributes'] = json_decode($data['specialAttributes']);
        }
        $commercial = Commercial::create($data);
        $commercial->property()->associate($property);
        $commercial->save();

        return $commercial;
    }

    public function show(Commercial $commercial): Commercial
    {
        $commercial->property->getMedia();
        return $commercial;
    }

    public function update($data, Commercial $commercial): Commercial
    {
        $commercial->update($data);
        return $commercial;
    }

    public function destroy(Commercial $commercial): void
    {
        $commercial->property()->delete();
    }
}
