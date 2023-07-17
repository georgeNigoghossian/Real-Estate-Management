<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends AppController
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
        return view('admin.user.list',compact('users'));
    }

    public function blocked_users(Request $request)
    {
        $custom_cond = [];

        $custom_cond[] = "is_blocked = '1'";

        if($request->name != ""){
            $custom_cond[] = "name LIKE '%$request->name%'";
        }
        $users = $this->userRepository->get_all($custom_cond);
        return view('admin.user.blocked_list',compact('users'));
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
}
