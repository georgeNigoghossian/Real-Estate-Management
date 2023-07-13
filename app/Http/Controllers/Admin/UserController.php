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

    public function switchBlock(Request $request){
        $status = $request->is_blocked;

        $this->userRepository->changeBlockStatus($status);
    }
}
