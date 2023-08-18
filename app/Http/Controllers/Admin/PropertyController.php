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
                'title'=>"Properties",

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
     * Display the specified resource.
     *
     * @param Property $property
     * @return JsonResponse
     */
    public function show(Property $property)
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

    public function details($id){
        $property = $this->property_repository->displayProperty($id);

        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",
                'url'=>route('admin.home'),
            ],
            '1'=>[
                'title'=>"Properties",
                'url'=>route('admin.property.index')
            ],
            '2'=>[
                'title'=>"Details",
            ]
        ];

        $property->getMedia();
        $media = $property["media"]->toArray();

        if(count($media) == 0 ){
            $media=asset('assets/img/home-decor-1.jpg');
        }

        $type="";
        $additional_data=[];
        if($property->agricultural){
            $type="Agricultural";
            $additional_data["Water Sources"]=$property->agricultural->water_sources != null ? $property->agricultural->water_sources : "";
        }elseif($property->residential){
            $type="Residential";
            $additional_data["Number Of Bedrooms"]=$property->residential->num_of_bedrooms != null ? $property->residential->num_of_bedrooms : "";
            $additional_data["Number Of Bathrooms"]=$property->residential->num_of_bathrooms != null ? $property->residential->num_of_bathrooms : "";
            $additional_data["Number Of Balconies"]=$property->residential->num_of_balconies != null ? $property->residential->num_of_balconies : "";
            $additional_data["Number Of Living Rooms"]=$property->residential->num_of_living_rooms != null ? $property->residential->num_of_living_rooms : "";
            $additional_data["Floor"]=$property->residential->floor != null ? $property->residential->floor : "";
        }elseif($property->commercial){
            $type="Commercial";
            $additional_data["Number Of Bathrooms"]=$property->commercial->num_of_bathrooms != null ? $property->commercial->num_of_bathrooms : "";
            $additional_data["Number Of Balconies"]=$property->commercial->num_of_balconies != null ? $property->commercial->num_of_balconies : "";
            $additional_data["Floor"]=$property->commercial->floor != null ? $property->commercial->floor : "";

        }

        return view('admin.property.details',compact('property','breadcrumb','media','type','additional_data'));
    }
}
