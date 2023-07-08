<?php

namespace App\Http\Controllers\App\Property;

use App\Http\Controllers\App\AppController;
use App\Http\Requests\PropertyChangeStatusRequest;
use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Models\Property\Property;
use App\Repositories\PropertyRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;
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
     * @return array
     */
    public function index(Request $request): array
    {
        $columns = Schema::getColumnListing('properties');
        $properties = QueryBuilder::for(Property::class)
            ->allowedFilters([
                ...$columns
            ])
            ->allowedSorts([
                ...$columns
            ])
            ->paginate($request->per_page);


        return $this->response(true, $properties, "All Properties", 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PropertyStoreRequest $request
     * @return array
     */
    public function store(PropertyStoreRequest $request): array
    {
        $property = $this->property_repository->store($request->validated());
        return $this->response(true, $property, "Property has been created successfully", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Property $property
     * @return array
     */
    public function show(Property $property): array
    {
        $property = $this->property_repository->show($property);
        return $this->response(true, $property);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Property $property
     * @return Response
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
     * @return array
     */
    public function update(PropertyUpdateRequest $request, Property $property): array
    {
        $property = $this->property_repository->update($request->validated(), $property);
        return $this->response(true, $property, 'property updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Property $property
     * @return array
     */
    public function destroy(Property $property): array
    {
        $this->property_repository->destroy($property);
        return $this->response(true, null, 'property deleted successfully');
    }

    /**
     * changes the status of a property
     *
     * @param PropertyChangeStatusRequest $request
     * @param Property $property
     * @return array
     */
    public function changeStatus(PropertyChangeStatusRequest $request, Property $property): array
    {
        $property = $this->property_repository->changeStatus($property, $request->validated());
        return $this->response(true, $property, 'property status changed successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return array
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
     * @return array
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
     * @return array
     */
    public function saveFavorite(Request $request)
    {
        $id = $request->property_id;
        $user = $request->user();

        $res = $this->property_repository->saveProperty($id, $user);

        if ($res[0] == 200)
            return $this->response(true, $res[1], $res[2], 200);
        else
            return $this->response(false, null, $res[1], $res[0]);
    }
}
