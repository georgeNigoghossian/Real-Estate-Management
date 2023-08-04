<?php

namespace App\Http\Controllers\App\Property;

use App\Http\Controllers\App\AppController;
use App\Http\Requests\Property\ResidentialStoreRequest;
use App\Http\Requests\Property\ResidentialUpdateRequest;
use App\Models\Property\Residential;
use App\Repositories\PropertyRepository;
use App\Repositories\ResidentialRepository;
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

class ResidentialController extends AppController
{

    private PropertyRepository $property_repository;
    private ResidentialRepository $residential_repository;

    public function __construct(PropertyRepository $property_repository, ResidentialRepository $residential_repository)
    {
        $this->property_repository = $property_repository;
        $this->residential_repository = $residential_repository;
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
        $priority_sort = AllowedSort::custom('owner-priority', new PrioritySort, 'residentials')->defaultDirection(SortDirection::DESCENDING);
        $properties = QueryBuilder::for(Residential::class)
            ->with('property')
            ->with('property.tags')
            ->with('property.amenities')
            ->with('property.user')
            ->allowedFilters([
                ...$columns,
                AllowedFilter::scope('term','Search'),
                AllowedFilter::scope('price-lower-than', 'PriceLowerThan'),
                AllowedFilter::scope('price-higher-than', 'PriceHigherThan'),
                AllowedFilter::scope('area-smaller-than','AreaSmallerThan'),
                AllowedFilter::scope('area-bigger-than','AreaBiggerThan'),
            ])
            ->allowedSorts([
                AllowedSort::custom('price', new PriceSort, 'residentials'),
                AllowedSort::custom('area', new AreaSort, 'residentials'),
                $priority_sort,
            ])
            ->defaultSort($priority_sort)
            ->paginate($request->per_page);
        return $this->response(true, $properties, "All Residential Properties");
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
     * @param ResidentialStoreRequest $request
     * @return JsonResponse
     */
    public function store(ResidentialStoreRequest $request): JsonResponse
    {
        $property = $this->property_repository->store($request->validated());
        $residential_property = $this->residential_repository->store($request->validated(), $property);
        return $this->response(true, $residential_property, "Residential property has been created successfully", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Residential $residential
     * @return JsonResponse
     */
    public function show(Residential $residential): JsonResponse
    {
        $property = $this->property_repository->show($residential->property);
        $residential = $this->residential_repository->show($residential);
        return $this->response(true, $residential);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Residential $residential
     *
     */
    public function edit(Residential $residential)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResidentialUpdateRequest $request
     * @param Residential $residential
     * @return JsonResponse
     */
    public function update(ResidentialUpdateRequest $request, Residential $residential): JsonResponse
    {
        $property = $this->property_repository->update($request->validated(), $residential->property);
        $residential = $this->residential_repository->update($request->validated(), $residential);
        return $this->response(true, $residential, 'Residential property updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Residential $residential
     * @return JsonResponse
     */
    public function destroy(Residential $residential): JsonResponse
    {
        $this->residential_repository->destroy($residential);
        return $this->response(true, null, 'Residential property deleted successfully');
    }
}
