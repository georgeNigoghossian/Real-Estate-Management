<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\Controller;
use App\Models\Property\Property;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Enums\StatusEnum;

class UserController extends Controller
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $custom_cond = [];
        if($request->is_blocked != "" ){
            $custom_cond[] = "is_blocked = '$request->is_blocked'";
        }
        if($request->name != ""){
            $custom_cond[] = "name LIKE '%$request->name%'";
        }
        $users = $this->userRepository->get_all($custom_cond);

        $users = $users->appends($request->query());

        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",
                'url'=>route('admin.home'),
            ],
            '1'=>[
                'title'=>"Users",

            ]
        ];

        return view('admin.user.list',compact('users','breadcrumb'));
    }

    public function blocked_users(Request $request)
    {
        $custom_cond = [];

        $custom_cond[] = "is_blocked = '1'";

        if($request->name != ""){
            $custom_cond[] = "name LIKE '%$request->name%'";
        }
        $users = $this->userRepository->get_all($custom_cond);

        $users =$users->appends($request->query());

        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",
                'url'=>route('admin.home'),
            ],
            '1'=>[
                'title'=>"Blocked Users",

            ]
        ];
        return view('admin.user.blocked_list',compact('users','breadcrumb'));
    }

    public function switchBlock(Request $request){
        $status = $request->is_blocked;
        $user_id = $request->id;

        $this->userRepository->changeBlockStatus($user_id,$status);

        if(isset($request->needs_redirect) && $request->needs_redirect==1){
            return redirect()->back();
        }
    }

    public function updatePriority(Request $request){

        $user_id = $request->userId;
        $new_priority = $request->newPriority;
        $this->userRepository->updatePriority($user_id,$new_priority);

    }

    public function details($id){
        $user = $this->userRepository->get_single_user($id);

        $properties = $user->properties;

        $status = [
            'in_market'=>'In Market',
            'purchased'=>'Purchased',
            'rented'=>'Rented',
        ];

        foreach($properties as $property){
            $property->getMedia();
            $media = $property["media"]->toArray();

            if(count($media) >0 ){
                $photo_url = $media["0"]["original_url"];

            }else{
                $photo_url = asset('assets/img/home-decor-1.jpg');
            }

            $property["first_image_url"] = $photo_url;
        }

        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",
                'url'=>route('admin.home'),
            ],
            '1'=>[
                'title'=>"Users",
                'url'=>route('admin.user.list')
            ],
            '2'=>[
                'title'=>"Details",
            ]
        ];
        return view('admin.user.details',compact('user','properties','status','breadcrumb'));
    }
}
