<?php

namespace App\Repositories;

use App\Models\Location\City;
use App\Models\Location\Country;
use App\Models\Property\Property;
use App\Models\Property\SavedProperty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


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
        if (array_key_exists("images", $data)) {
            $images = $data['images'];
            foreach ($images as $image) {
                $property->addMedia($image)->toMediaCollection('images');
            }
        }
        if (array_key_exists('tags', $data))
            $property->tags()->sync($data['tags']);
        if (array_key_exists('amenities', $data))
            $property->amenities()->sync($data['amenities']);
        if (array_key_exists('city', $data)) {
            $city = City::where('id', $data['city'])->first();
            $property->city()->associate($city);
        }
        if (array_key_exists('country', $data)) {
            $country = Country::where('id', $data['country'])->first();
            $property->country()->associate($country);
        }
        return $property;
    }

    public function get_all($custom_cond = [], $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Property::query()->with('user');

        if (count($custom_cond) > 0) {
            $custom_cond = implode(' AND ', $custom_cond);
            $query = $query->whereRaw($custom_cond);
        }

        return $query->paginate($perPage);
    }

    public function show(Property $property): Property
    {
        $property->getMedia();
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

    public function saveProperty($id, $user): array
    {
        $property = Property::find($id);

        if ($property->is_disabled) return [403, __("api.messages.property_disabled")];
        $saved = SavedProperty::where('property_id', $property->id)->where('user_id', $user->id)->first();
        if ($saved) {
            $user->savedProperties()->detach($property->id);
            $res = [false, 'Unsaved'];
        } else {
            $user->savedProperties()->attach($property->id);
            $res = [true, 'saved'];
        }
        return $res;
    }

    public function disableProperty($id)
    {
        $property = Property::find($id);
        $property->is_disabled = true;
        $property->save();
        return $property;
    }

    public function enableProperty($id)
    {
        $property = Property::find($id);
        $property->is_disabled = false;
        $property->save();
        return $property;
    }

    public function nearByPlaces($data)
    {
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $radius = $data['radius'];
        $properties = QueryBuilder::for(Property::class)
            ->whereRaw(DB::raw("ACOS(SIN(RADIANS(latitude))*SIN(RADIANS($latitude))+COS(RADIANS(latitude))*COS(RADIANS($latitude))*COS(RADIANS(longitude)-RADIANS($longitude)))*6380 < ?"), [$radius])
            ->allowedFilters([
                AllowedFilter::scope('property-type', 'PropertyType'),
                AllowedFilter::scope('property-service', 'PropertyService'),
            ])
            ->with('tags', 'amenities', 'user', 'residential', 'commercial', 'agricultural', 'media', 'city', 'country')
            ->get();

        return $properties;
    }
}
