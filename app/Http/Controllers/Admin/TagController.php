<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Models\Tag;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class TagController extends AppController
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
        return view('admin.tag.list',compact('tags'));
    }


}
