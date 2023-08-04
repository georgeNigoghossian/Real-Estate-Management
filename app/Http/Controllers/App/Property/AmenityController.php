<?php

namespace App\Http\Controllers\App\Property;

use App\Http\Controllers\App\AppController;
use App\Http\Requests\Property\AmenityStoreRequest;
use App\Http\Requests\Property\AmenityUpdateRequest;
use App\Models\Property\Amenity;
use App\Repositories\AmenityRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class AmenityController extends AppController
{
    private AmenityRepository $amenity_repository;

    /**
     * Display a listing of the resource.
     *
     * @param AmenityRepository $amenity_repository
     */

    public function __construct(AmenityRepository $amenity_repository)
    {
        $this->amenity_repository = $amenity_repository;
    }

    public function index(Request $request): JsonResponse
    {
        $amenities = QueryBuilder::for(Amenity::class)
            ->allowedFilters([
                AllowedFilter::scope('term','Search'),
                AllowedFilter::scope('active','Active'),
            ])
            ->paginate($request->per_page);
        return $this->response(true, $amenities, "All Amenities");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AmenityStoreRequest $request
     * @return JsonResponse
     */
    public function store(AmenityStoreRequest $request): JsonResponse
    {
        $amenity = $this->amenity_repository->store($request->validated());
        return $this->response(true, $amenity, "Amenity has been created successfully", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Amenity $amenity
     * @return JsonResponse
     */
    public function show(Amenity $amenity): JsonResponse
    {
        $amenity = $this->amenity_repository->show($amenity);
        return $this->response(true, $amenity);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Amenity $amenity
     * @return \Illuminate\Http\Response
     */
    public function edit(Amenity $amenity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AmenityUpdateRequest $request
     * @param Amenity $amenity
     * @return JsonResponse
     */
    public function update(AmenityUpdateRequest $request, Amenity $amenity): JsonResponse
    {
        $amenity = $this->amenity_repository->update($request->validated(), $amenity);
        return $this->response(true, $amenity, 'Amenity updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Amenity $amenity
     * @return JsonResponse
     */
    public function destroy(Amenity $amenity): JsonResponse
    {
        $this->amenity_repository->destroy($amenity);
        return $this->response(true, null, 'Amenity deleted successfully');
    }
}
