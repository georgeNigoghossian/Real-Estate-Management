<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property\Property;
use App\Repositories\AgencyRepository;
use App\Repositories\PropertyRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PropertyController extends Controller
{
    private PropertyRepository $property_repository;

    public function __construct(PropertyRepository $property_repository)
    {
        $this->property_repository = $property_repository;
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {

        $custom_cond = [];
        if ($request->is_disabled != "") {
            $custom_cond[] = "is_disabled = '$request->is_disabled'";
        }
        if ($request->name != "") {
            $custom_cond[] = "name LIKE '%$request->name%'";
        }
        $properties = $this->property_repository->get_all($custom_cond);

        $properties = $properties->appends($request->query());

        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",
                'url'=>route('admin.home'),
            ],
            '1'=>[
                'title'=>"Property",

            ]
        ];


        return view('admin.property.list', compact('properties','breadcrumb'));
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
     * @param Request $request
     * @param Property $property
     * @return Response
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Property $property
     * @return Response
     */
    public function destroy(Property $property)
    {
        //
    }

}
