<?php

namespace App\Http\Controllers\App\Property;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\Controller;
use App\Models\Property\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;
use Spatie\QueryBuilder\QueryBuilder;

class PropertyController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
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


        return $this->response(true,$properties,"All Properties",200);

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
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Property\Property $property
     * @return Response
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Property\Property $property
     * @return Response
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Property\Property $property
     * @return Response
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Property\Property $property
     * @return Response
     */
    public function destroy(Property $property)
    {
        //
    }
}
