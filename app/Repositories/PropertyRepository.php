<?php

namespace App\Repositories;

use App\Models\Property\Property;
use App\Models\Property\SavedProperty;
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

        if ($property->delete()) {
            return [200, $property, __("api.messages.success_delete_property")];
        } else {
            return [500, __("api.messages.failed_delete_property")];
        }
    }

    public function saveProperty($id, $user)
    {
        $property = Property::find($id);

        if (!$property) return [404, __("api.messages.property_not_found")];
        if ($property->is_disabled) return [403, __("api.messages.property_disabled")];

        $saved_property = SavedProperty::firstOrCreate([
            'property_id' => $property->id,
            'user_id' => $user->id
        ]);

        if ($saved_property) {
            if ($saved_property->wasRecentlyCreated)
                return [200, $property, __("api.messages.success_save_property")];
            else
                return [200, $property, __("api.messages.property_already_saved")];
        } else {
            return [500, __("api.messages.failed_save_property")];
        }
    }
}
