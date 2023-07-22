<?php

namespace App\Http\Controllers\App\Location;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\Controller;
use App\Models\Location\City;
use App\Repositories\CityRepository;
use Igaster\LaravelCities\Geo;
use Illuminate\Http\Request;

class CityController extends AppController
{

    private CityRepository $city_repository;

    public function __construct(CityRepository $city_repository)
    {
        $this->city_repository = $city_repository;
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param City $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param City $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param City $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param City $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return array
     */
    public function getAll()
    {
        $tree = $this->city_repository->getTree();
        return $this->response(true, $tree,  __("api.messages.return_cities_tree_successfully"));
    }
}
