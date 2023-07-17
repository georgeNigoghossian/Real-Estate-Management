<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Models\Amenity;

use App\Repositories\AmenityRepository;
use Illuminate\Http\Request;

class AmenityController extends AppController
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
        $tags = $this->amenityRepository->get_all($custom_cond);
        return view('admin.amenity.list',compact('tags'));
    }


}
