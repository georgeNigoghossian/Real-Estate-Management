<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Models\Amenity;

use App\Models\Property\AmenityType;
use App\Repositories\AmenityRepository;
use Illuminate\Http\Request;

class AmenityTypeController extends AppController
{
    private $amenityRepository;

    public function __construct(AmenityRepository $amenityRepository)
    {
        $this->amenityRepository = $amenityRepository;
    }

    public function index(Request $request){

        $custom_cond = [];
        if($request->name != ""){
            $custom_cond[] = "name LIKE '%$request->name%'";
        }
        $amenity_types = $this->amenityRepository->get_all_amenity_types($custom_cond);
        $amenity_types =$amenity_types->appends($request->query());

        return view('admin.amenity_type.list',compact('amenity_types'));
    }


    public function create(){

        $amenity_types = $this->amenityRepository->get_all_amenity_types();
        return view('admin.amenity_type.create',compact('amenity_types'));
    }


    public function store(Request $request){

        $data = [
            'name'=>$request->name,
        ];
        $amenity = $this->amenityRepository->storeAmityType($data);


        return redirect()->route('admin.amenity_types');
    }



    public function edit(Request $request){

        $amenity_types = $this->amenityRepository->get_all_amenity_types();
        $amenity_type = AmenityType::find($request->id);
        return view('admin.amenity_type.create',compact('amenity_types','amenity_type'));
    }

    public function update($id,Request $request){


        $data = [
            'name'=>$request->name,
        ];

        $amenity_type = AmenityType::find($id);
        $amenity = $this->amenityRepository->updateAmenityType($data,$amenity_type);


        return redirect()->route('admin.amenity_types');
    }

    public function delete($id) {
        $amenity_type = AmenityType::find($id);

        $this->amenityRepository->destroyAmenityType($amenity_type);

        return redirect()->back();
    }



}
