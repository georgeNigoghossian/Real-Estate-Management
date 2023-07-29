<?php

namespace App\Http\Controllers\App\Property;

use App\Http\Controllers\App\AppController;
use App\Http\Requests\Property\AgriculturalStoreRequest;
use App\Http\Requests\Property\AgriculturalUpdateRequest;
use App\Models\Property\Agricultural;
use App\Repositories\AgriculturalRepository;
use App\Repositories\PropertyRepository;
use App\Sorts\AreaSort;
use App\Sorts\PriceSort;
use App\Sorts\PrioritySort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\SortDirection;
use Spatie\QueryBuilder\QueryBuilder;

class AgriculturalController extends AppController
{

    private PropertyRepository $property_repository;
    private AgriculturalRepository $agricultural_repository;

    public function __construct(PropertyRepository $property_repository, AgriculturalRepository $agricultural_repository)
    {
        $this->property_repository = $property_repository;
        $this->agricultural_repository = $agricultural_repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        $columns = Schema::getColumnListing('properties');
        $priority_sort = AllowedSort::custom('owner-priority', new PrioritySort, 'agriculturals')->defaultDirection(SortDirection::DESCENDING);
        $properties = QueryBuilder::for(Agricultural::class)
            ->with('property', 'property.user')
            ->allowedFilters([
                ...$columns,
                AllowedFilter::scope('search'),
                AllowedFilter::scope('price-lower-than','PriceLowerThan'),
                AllowedFilter::scope('price-higher-than','PriceHigherThan'),
                AllowedFilter::scope('area-smaller-than','AreaSmallerThan'),
                AllowedFilter::scope('area-bigger-than','AreaBiggerThan'),
            ])
            ->allowedSorts([
                AllowedSort::custom('price', new PriceSort, 'agriculturals'),
                AllowedSort::custom('area', new AreaSort, 'agriculturals'),
                $priority_sort
            ])
            ->defaultSort($priority_sort)
            ->paginate($request->per_page);
        return $this->response(true, $properties, "All Agricultural Properties");
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
     * @param AgriculturalStoreRequest $request
     * @return array
     */
    public function store(AgriculturalStoreRequest $request): array
    {
        $property = $this->property_repository->store($request->validated());
        $agricultural_property = $this->agricultural_repository->store($request->validated(), $property);
        return $this->response(true, $agricultural_property, "agricultural property has been created successfully", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Agricultural $agricultural
     * @return array
     */
    public function show(Agricultural $agricultural): array
    {
        $property = $this->property_repository->show($agricultural->property);
        $agricultural = $this->agricultural_repository->show($agricultural);
        return $this->response(true, $agricultural);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Agricultural $agricultural
     *
     */
    public function edit(Agricultural $agricultural)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AgriculturalUpdateRequest $request
     * @param Agricultural $agricultural
     * @return array
     */
    public function update(AgriculturalUpdateRequest $request, Agricultural $agricultural): array
    {
        $property = $this->property_repository->update($request->validated(), $agricultural->property);
        $agricultural = $this->agricultural_repository->update($request->validated(), $agricultural);
        return $this->response(true, $agricultural, 'property updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Agricultural $agricultural
     * @return array
     */
    public function destroy(Agricultural $agricultural): array
    {
        $this->agricultural_repository->destroy($agricultural);
        return $this->response(true, null, 'agricultural property deleted successfully');
    }
}
