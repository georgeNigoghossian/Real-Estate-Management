<?php

namespace App\Http\Controllers\App\Property;

use App\Http\Controllers\App\AppController;
use App\Http\Requests\Property\nearbyPlacesRequest;
use App\Http\Requests\Property\PropertyChangeStatusRequest;
use App\Http\Requests\Property\PropertyDestroyRequest;
use App\Http\Requests\Property\PropertyDisableEnableRequest;
use App\Http\Requests\Property\PropertyStoreRequest;
use App\Http\Requests\Property\PropertyUpdateRequest;
use App\Http\Requests\Property\RatePropertyRequest;
use App\Models\Property\Property;
use App\Models\Property\SavedProperty;
use App\Models\RateProperty;
use App\Repositories\PropertyRepository;
use App\Sorts\AreaSort;
use App\Sorts\CreatedAtSort;
use App\Sorts\PriceSort;
use App\Sorts\PrioritySort;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class PropertyController extends AppController
{

    private PropertyRepository $property_repository;

    public function __construct(PropertyRepository $property_repository)
    {
        $this->property_repository = $property_repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $priority_sort = AllowedSort::custom('owner-priority', new PrioritySort, 'properties')->defaultDirection(SortDirection::DESCENDING);
        $result = QueryBuilder::for(Property::class)
            ->with('ratings', 'tags', 'amenities', 'residential', 'commercial', 'agricultural', 'media', 'city', 'country')
            ->with('user', function ($q) {
                $q->withWhereHas('agency')->orWhereDoesntHave('agency');
            })
            ->allowedFilters([
                AllowedFilter::scope('term', 'Search'),
                AllowedFilter::scope('price-lower-than', 'PriceLowerThan'),
                AllowedFilter::scope('price-higher-than', 'PriceHigherThan'),
                AllowedFilter::scope('area-smaller-than', 'AreaSmallerThan'),
                AllowedFilter::scope('area-bigger-than', 'AreaBiggerThan'),
                AllowedFilter::scope('property-type', 'PropertyType'),
                AllowedFilter::scope('property-service', 'PropertyService'),
                AllowedFilter::scope('city', 'City'),
                AllowedFilter::scope('country', 'Country'),
                AllowedFilter::scope('my-properties', 'MyProperties'),
                AllowedFilter::scope('my-favorites', 'MyFavorites'),
                AllowedFilter::scope('tags', 'WithTags'),
                AllowedFilter::scope('amenities', 'WithAmenities'),
            ])
            ->allowedSorts([
                AllowedSort::custom('created-at', new CreatedAtSort, 'properties'),
                AllowedSort::custom('price', new PriceSort, 'properties'),
                AllowedSort::custom('area', new AreaSort, 'properties'),
                $priority_sort
            ])
            ->defaultSort($priority_sort)
            ->paginate($request->per_page);
        return $this->response(true, $result, "All Properties");
    }


    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PropertyStoreRequest $request
     * @return JsonResponse
     */
    public function store(PropertyStoreRequest $request): JsonResponse
    {
        $property = $this->property_repository->store($request->validated());
        return $this->response(true, $property, "Property has been created successfully", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Property $property
     * @return JsonResponse
     */
    public function show(Property $property): JsonResponse
    {
        $property = $this->property_repository->show($property);
        return $this->response(true, $property);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Property $property
     *
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PropertyUpdateRequest $request
     * @param Property $property
     * @return JsonResponse
     */
    public function update(PropertyUpdateRequest $request, Property $property): JsonResponse
    {
        $property = $this->property_repository->update($request->validated(), $property);
        return $this->response(true, $property, 'property updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PropertyDestroyRequest $request
     * @param Property $property
     * @return JsonResponse
     */
    public function destroy(PropertyDestroyRequest $request, Property $property): JsonResponse
    {
        $this->property_repository->destroy($property);
        return $this->response(true, null, 'property deleted successfully');
    }

    /**
     * changes the status of a property
     *
     * @param PropertyChangeStatusRequest $request
     * @param Property $property
     * @return JsonResponse
     */
    public function changeStatus(PropertyChangeStatusRequest $request, Property $property): JsonResponse
    {
        $property = $this->property_repository->changeStatus($property, $request->validated());
        return $this->response(true, $property, 'property status changed successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function display_property(Request $request)
    {
        $id = $request->property_id;
        $res = $this->property_repository->displayProperty($id);

        if ($res != null)
            return $this->response(true, $res, __("api.messages.success_retrieve_property"), 200);
        else
            return $this->response(false, null, __("api.messages.property_not_found"), 404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete_property(Request $request)
    {
        $id = $request->property_id;
        $user = $request->user();
        $res = $this->property_repository->deleteProperty($id, $user);

        if ($res[0] == 200)
            return $this->response(true, $res[1], $res[2], 200);
        else
            return $this->response(false, null, $res[1], $res[0]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveFavorite(Request $request): JsonResponse
    {
        $id = $request->property_id;
        $user = $request->user();

        $res = $this->property_repository->saveProperty($id, $user);

        return $this->response(true, $res[0], $res[1]);
    }

    public function disableProperty(PropertyDisableEnableRequest $request): JsonResponse
    {
        $property = $this->property_repository->disableProperty($request->validated()['id']);
        return $this->response(true, $property, __("api.messages.disable_property_successfully"));
    }

    public function enableProperty(PropertyDisableEnableRequest $request): JsonResponse
    {
        $property = $this->property_repository->enableProperty($request->validated()['id']);
        return $this->response(true, $property, __("api.messages.enable_property_successfully"));
    }

    public function nearbyPlaces(nearbyPlacesRequest $request): JsonResponse
    {
        $properties = $this->property_repository->nearByPlaces($request->validated());
        return $this->response(true, $properties, count($properties), "All Properties nearby");
    }

    public function myProperties(Request $request): JsonResponse
    {
        $properties = QueryBuilder::for(Property::class)
            ->whereHas('user', function ($query) {
                return $query->where('id', '=', auth()->user()->id);
            })
            ->with('tags')
            ->with('amenities')
            ->with('region')
            ->with('region.city')
            ->with('region.city.country')
            ->paginate($request->per_page);
        return $this->response(true, $properties, "My Properties");
    }

    public function myFavorites(Request $request): JsonResponse
    {
        $properties = QueryBuilder::for(SavedProperty::class)
            ->where('user_id', '=', auth()->user()->id)
            ->where('property_id', '=', auth()->user()->id)
            ->with('property')
            ->with('property.tags')
            ->with('property.amenities')
            ->with('property.region')
            ->with('property.region.city')
            ->with('property.region.city.country')
            ->paginate($request->per_page);
        return $this->response(true, $properties, "My favorites");
    }

    public function isFavorite(Property $property): JsonResponse
    {
        $saved = SavedProperty::where('property_id', $property->id)->where('user_id', auth()->user()->id)->first();
        if ($saved) return $this->response(true, true, "saved");
        return $this->response(true, false, "not saved");
    }

    public function rateProperty(RatePropertyRequest $request, Property $property): JsonResponse
    {
        $rating = $this->property_repository->rateProperty($property, $request->validated());
        return $this->response(true, $rating, "Property has been rated successfully", 201);
    }

    public function myRatings(Request $request): JsonResponse
    {
        $user = auth()->user()->id;
        $ratings = QueryBuilder::for(RateProperty::class)
            ->where('user_id', '=', $user)
            ->paginate($request->per_page);
        return $this->response(true, $ratings);

    }

    public function myPropertyRating(Property $property): JsonResponse
    {
        $user = auth()->user()->id;
        $rating = RateProperty::where('property_id', '=', $property->id)->where('user_id', '=', $user)->get();
        if ($rating->isEmpty()) {
            return $this->response(false, null, 'you don\'t have rating for this property');
        }
        return $this->response(true, $rating);
    }

    public function propertyRatings(Request $request, Property $property): JsonResponse
    {
        $ratings = QueryBuilder::for(RateProperty::class)
            ->where('property_id', '=', $property->id)
            ->with('user')
            ->paginate($request->per_page);
        return $this->response(true, $ratings);

    }
}
