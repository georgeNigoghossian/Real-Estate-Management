<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\Controller;
use App\Models\Property\Tag;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use JsValidator;

class TagController extends Controller
{
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function index(Request $request){
        $custom_cond = [];
        if($request->name != ""){
            $custom_cond[] = "name LIKE '%$request->name%'";
        }
        $tags = $this->tagRepository->get_all($custom_cond);
        $tags =$tags->appends($request->query());

        $property_types = [
            'residential'=>'Residential',
            'agricultural'=>'Agricultural',
            'commercial'=>'Commercial'
        ];
        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",
                'url'=>route('admin.home'),
            ],
            '1'=>[
                'title'=>"Tags",

            ]
        ];
        return view('admin.tag.list',compact('tags','property_types','breadcrumb'));
    }

    public function create(){


        $property_types = [
            'residential'=>'Residential',
            'agricultural'=>'Agricultural',
            'commercial'=>'Commercial'
        ];

        $model = new Tag();

        $validation_rules = [];
        if(isset($model->validation_rules) && count($model->validation_rules)>0){
            $validation_rules = $model->validation_rules;
        }

        $jsValidator = JsValidator::make($validation_rules);

        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",
                'url'=>route('admin.home'),
            ],
            '1'=>[
                'title'=>"Tags",
                'url'=>route('admin.tags')
            ],
            '2'=>[
                'title'=>"Create Tag",
            ]
        ];
        return view('admin.tag.create',compact('property_types','jsValidator','breadcrumb'));
    }

    public function store(Request $request){

        $model = new Tag();
        if (isset($model->validation_rules) && is_array($model->validation_rules)) {
            $validation_rules = $model->validation_rules;

            $request->validate($validation_rules);
        }

        $path = 'uploads/Tag';
        if(isset($request->document[0])){
            $path = $path.'/'.$request->document[0];
        }else{
            $path = null;
        }


        $data = [
            'name_en'=>$request->name_en,
            'name_ar'=>$request->name_ar,
            'file'=>$path,
            'property_type'=>$request->property_type ,
        ];

        $tag = $this->tagRepository->store($data);


        return redirect()->route('admin.tags');
    }

    public function storePhoto(Request $request){

        //dd($request->all());
        $file = $request->file('file');

        $path = public_path('uploads/Tag');

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

        $property_types = [
            'residential'=>'Residential',
            'agricultural'=>'Agricultural',
            'commercial'=>'Commercial'
        ];

        $tag = $this->tagRepository->get_single_tag($request->id);


        $model = new Tag();

        $validation_rules = [];
        if(isset($model->validation_rules) && count($model->validation_rules)>0){
            $validation_rules = $model->validation_rules;
        }

        $jsValidator = JsValidator::make($validation_rules);

        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",
                'url'=>route('admin.home'),
            ],
            '1'=>[
                'title'=>"Tags",
                'url'=>route('admin.tags')
            ],
            '2'=>[
                'title'=>"Edit Tag",
            ]
        ];

        return view('admin.tag.create',compact('property_types','tag','jsValidator','breadcrumb'));
    }
    public function update($id,Request $request){

        $model = new Tag();
        if (isset($model->validation_rules) && is_array($model->validation_rules)) {
            $validation_rules = $model->validation_rules;

            $request->validate($validation_rules);
        }


        $tag = Tag::find($id);
//        $filePath = $tag->file;
//        if (file_exists($filePath)) {
//            unlink($filePath);
//        }

        if(isset($request->document[0])){
            if(str_starts_with($request->document[0],"uploads/Tag")){
                $path =$request->document[0] ;
            }else{
                $path = 'uploads/Tag';
                $path = $path.'/'.$request->document[0] ;
            }

        }else{
            $path=null;
        }

        $data = [
            'name_en'=>$request->name_en,
            'name_ar'=>$request->name_ar,
            'file'=>$path,
            'property_type'=>$request->property_type ,
        ];


        $tag = $this->tagRepository->update($data,$tag);


        return redirect()->route('admin.tags');
    }

    public function delete($id) {
        $tag = Tag::find($id);
        $filePath = $tag->file;

        if (file_exists($filePath)) {

            unlink($filePath);

        }
        $this->tagRepository->destroy($tag);

        return redirect()->back();
    }

    public function switchActive(Request $request){
        $status = $request->is_active;
        $tag_id = $request->id;

        $this->tagRepository->changeActiveStatus($tag_id,$status);

        if(isset($request->needs_redirect) && $request->needs_redirect==1){
            return redirect()->back();
        }
    }
}
