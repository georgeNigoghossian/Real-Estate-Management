<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Models\Amenity;

use App\Models\Property\AmenityType;
use App\Repositories\AmenityRepository;
use Illuminate\Http\Request;
use JsValidator;
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

        $model = new AmenityType();

        $validation_rules = [];
        if(isset($model->validation_rules) && count($model->validation_rules)>0){
            $validation_rules = $model->validation_rules;
        }

        $jsValidator = JsValidator::make($validation_rules);
        return view('admin.amenity_type.create',compact('amenity_types','jsValidator'));
    }


    public function store(Request $request){

        $model = new AmenityType();
        if (isset($model->validation_rules) && is_array($model->validation_rules)) {
            $validation_rules = $model->validation_rules;

            $request->validate($validation_rules);
        }

        $data = [
            'name_en'=>$request->name_en,
            'name_ar'=>$request->name_ar,
        ];
        $amenity = $this->amenityRepository->storeAmityType($data);


        return redirect()->route('admin.amenity_types');
    }



    public function edit(Request $request){

        $amenity_types = $this->amenityRepository->get_all_amenity_types();
        $amenity_type = AmenityType::find($request->id);

        $model = new AmenityType();

        $validation_rules = [];
        if(isset($model->validation_rules) && count($model->validation_rules)>0){
            $validation_rules = $model->validation_rules;
        }

        $jsValidator = JsValidator::make($validation_rules);

        return view('admin.amenity_type.create',compact('amenity_types','amenity_type','jsValidator'));
    }

    public function update($id,Request $request){

        $model = new AmenityType();
        if (isset($model->validation_rules) && is_array($model->validation_rules)) {
            $validation_rules = $model->validation_rules;

            $request->validate($validation_rules);
        }

        $data = [
            'name_en'=>$request->name_en,
            'name_ar'=>$request->name_ar,
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
