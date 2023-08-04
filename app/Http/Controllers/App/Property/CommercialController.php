<?php

namespace App\Http\Controllers\App\Property;

use App\Http\Controllers\App\AppController;
use App\Http\Requests\Property\CommercialStoreRequest;
use App\Http\Requests\Property\CommercialUpdateRequest;
use App\Models\Property\Commercial;
use App\Repositories\CommercialRepository;
use App\Repositories\PropertyRepository;
use App\Sorts\AreaSort;
use App\Sorts\PriceSort;
use App\Sorts\PrioritySort;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class CommercialController extends AppController
{

    private PropertyRepository $property_repository;
    private CommercialRepository $commercial_repository;

    public function __construct(PropertyRepository $property_repository, CommercialRepository $commercial_repository)
    {
        $this->property_repository = $property_repository;
        $this->commercial_repository = $commercial_repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $columns = Schema::getColumnListing('properties');
        $priority_sort = AllowedSort::custom('owner-priority', new PrioritySort, 'commercials')->defaultDirection(SortDirection::DESCENDING);
        $properties = QueryBuilder::for(Commercial::class)
            ->with('property')
            ->with('property.tags')
            ->with('property.amenities')
            ->with('property.user')
            ->allowedFilters([
                ...$columns,
                AllowedFilter::scope('term','Search'),
                AllowedFilter::scope('price-lower-than','PriceLowerThan'),
                AllowedFilter::scope('price-higher-than','PriceHigherThan'),
                AllowedFilter::scope('area-smaller-than','AreaSmallerThan'),
                AllowedFilter::scope('area-bigger-than','AreaBiggerThan'),
            ])
            ->allowedSorts([
                AllowedSort::custom('price', new PriceSort, 'commercials'),
                AllowedSort::custom('area', new AreaSort, 'commercials'),
                $priority_sort
            ])
            ->defaultSort($priority_sort)
            ->paginate($request->per_page);
        return $this->response(true, $properties, "All Commercial Properties");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommercialStoreRequest $request
     * @return JsonResponse
     */
    public function store(CommercialStoreRequest $request): JsonResponse
    {
        $property = $this->property_repository->store($request->validated());
        $commercial_property = $this->commercial_repository->store($request->validated(), $property);
        return $this->response(true, $commercial_property, "Commercial property has been created successfully", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Commercial $commercial
     * @return JsonResponse
     */
    public function show(Commercial $commercial): JsonResponse
    {
        $property = $this->property_repository->show($commercial->property);
        $commercial = $this->commercial_repository->show($commercial);
        return $this->response(true, $commercial);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CommercialUpdateRequest $request
     * @param Commercial $commercial
     * @return JsonResponse
     */
    public function update(CommercialUpdateRequest $request, Commercial $commercial): JsonResponse
    {
        $property = $this->property_repository->update($request->validated(), $commercial->property);
        $commercial = $this->commercial_repository->update($request->validated(), $commercial);
        return $this->response(true, $commercial, 'property updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Commercial $commercial
     * @return JsonResponse
     */
    public function destroy(Commercial $commercial): JsonResponse
    {
        $this->commercial_repository->destroy($commercial);
        return $this->response(true, null, 'Commercial property deleted successfully');
    }
}
