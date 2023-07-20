<?php

namespace App\Http\Controllers\App\Property;

use App\Http\Controllers\App\AppController;
use App\Http\Requests\Property\ResidentialStoreRequest;
use App\Http\Requests\Property\ResidentialUpdateRequest;
use App\Models\Property\Residential;
use App\Repositories\PropertyRepository;
use App\Repositories\ResidentialRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
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
     * @return array
     */
    public function index(Request $request): array
    {
        $columns = Schema::getColumnListing('properties');
        $properties = QueryBuilder::for(Residential::class)
            ->allowedFilters([
                ...$columns
            ])
            ->allowedSorts([
                ...$columns
            ])
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
     * @return array
     */
    public function store(ResidentialStoreRequest $request): array
    {
        $property = $this->property_repository->store($request->validated());
        $residential_property = $this->residential_repository->store($request->validated(), $property);
        return $this->response(true, $residential_property, "Residential property has been created successfully", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Residential $residential
     * @return array
     */
    public function show(Residential $residential): array
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
     * @return array
     */
    public function update(ResidentialUpdateRequest $request, Residential $residential): array
    {
        $property = $this->property_repository->update($request->validated(), $residential->property);
        $residential = $this->residential_repository->update($request->validated(), $residential);
        return $this->response(true, $residential, 'Residential property updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Residential $residential
     * @return array
     */
    public function destroy(Residential $residential): array
    {
        $this->residential_repository->destroy($residential);
        return $this->response(true, null, 'Residential property deleted successfully');
    }
}
