<?php

namespace App\Http\Controllers\App\Location;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Location\RegionStoreRequest;
use App\Models\Location\Region;
use App\Repositories\RegionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionController extends AppController
{
    private RegionRepository $region_repository;
    public function __construct(RegionRepository $region_repository)
    {
        $this->region_repository = $region_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegionStoreRequest $request)
    {
        $region = $this->region_repository->store($request->validated());
        return $this->response(true, $region, __("api.messages.add_region_successfully"), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(Region $region)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function getAll()
    {
        $tree = $this->region_repository->getTree();
        return $this->response(true, $tree,  __("api.messages.return_cities_tree_successfully"));
    }
}
