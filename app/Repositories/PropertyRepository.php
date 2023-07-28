<?php

namespace App\Repositories;

use App\Models\Property\Property;
use App\Models\Property\SavedProperty;
use Illuminate\Support\Facades\Auth;
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
        $property = Property::create($data);
        $property->user()->associate(Auth::user());
        $property->save();
        if (array_key_exists('tags', $data))
            $property->tags()->sync($data['tags']);
        if (array_key_exists('amenities', $data))
            $property->amenities()->sync($data['amenities']);
        return $property;
    }

    public function show(Property $property): Property
    {
        return $property;
    }

    public function update($data, Property $property): Property
    {
        $property->update($data);
        if (array_key_exists('tags', $data))
            $property->tags()->sync($data['tags']);
        if (array_key_exists('amenities', $data))
            $property->amenities()->sync($data['amenities']);
        return $property;
    }

    public function destroy(Property $property)
    {
        $property->delete();
    }

    public function changeStatus($property, $status)
    {
        $property->update($status);
        return $property;
    }

    public function displayProperty($id)
    {
        $property = Property::find($id);

        if ($property) {
            return $property;
        } else {
            return null;
        }
    }

    public function deleteProperty($id, $user)
    {
        $property = Property::find($id);

        if (!$property) return [404, __("api.messages.property_not_found")];
        if ($property->user_id != $user->id) return [403, __("api.messages.delete_property_forbidden")];

    }

    public function saveProperty($id, $user)
    {
        $property = Property::find($id);

        if ($property->is_disabled) return [403, __("api.messages.property_disabled")];

        SavedProperty::firstOrCreate([
            'property_id' => $property->id,
            'user_id' => $user->id
        ]);
    }

    public function disableProperty($id){
        $property = Property::find($id);
        $property->is_disabled = true;
        $property->save();
        return $property;
    }

    public function enableProperty($id){
        $property = Property::find($id);
        $property->is_disabled = false;
        $property->save();
        return $property;
    }
}
