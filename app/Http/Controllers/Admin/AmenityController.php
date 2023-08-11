<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\App\AppController;
use App\Models\Property\Amenity;
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
        $amenities = $this->amenityRepository->get_all($custom_cond);

        $amenities =$amenities->appends($request->query());

        return view('admin.amenity.list',compact('amenities'));
    }


    public function create(){

        $amenity_types = $this->amenityRepository->get_all_amenity_types();
        return view('admin.amenity.create',compact('amenity_types'));
    }


    public function store(Request $request){

        $path = 'uploads/Amenity';
        if(isset($request->document[0])){
            $path = $path.'/'.$request->document[0];
        }else{
            $path = null;
        }


        $data = [
            'name'=>$request->name,
            'file'=>$path,
            'amenity_type_id'=>$request->amenity_type ,
        ];

        $amenity = $this->amenityRepository->store($data);


        return redirect()->route('admin.amenities');
    }

    public function storePhoto(Request $request){

        //dd($request->all());
        $file = $request->file('file');

        $path = public_path('uploads/Amenity');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        //$name =trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function edit(Request $request){

        $amenity_types = $this->amenityRepository->get_all_amenity_types();
        $amenity = Amenity::find($request->id);

        return view('admin.amenity.create',compact('amenity_types','amenity'));
    }
    public function update($id,Request $request){



        if(isset($request->document[0])){
            if(str_starts_with($request->document[0],"uploads/Amenity")){
                $path =$request->document[0] ;
            }else{
                $path = 'uploads/Amenity';
                $path = $path.'/'.$request->document[0] ;
            }

        }else{
            $path=null;
        }

        $data = [
            'name'=>$request->name,
            'file'=>$path,
            'amenity_type_id'=>$request->amenity_type ,
        ];

        $amenity = \App\Models\Property\Amenity::find($id);
        $amenity = $this->amenityRepository->update($data,$amenity);


        return redirect()->route('admin.amenities');
    }

    public function delete($id) {
        $amenity = \App\Models\Property\Amenity::find($id);
        $filePath = $amenity->file;

        if (file_exists($filePath)) {

            unlink($filePath);

        }
        $this->amenityRepository->destroy($amenity);

        return redirect()->back();
    }

    public function switchActive(Request $request){
        $status = $request->is_active;
        $amenity_id = $request->id;

        $this->amenityRepository->changeActiveStatus($amenity_id,$status);

        if(isset($request->needs_redirect) && $request->needs_redirect==1){
            return redirect()->back();
        }
    }

}
