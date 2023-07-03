<?php

namespace App\Http\Controllers\App;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private UserRepository $userRepository ;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show(User $User)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function edit(User $User)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $User)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->user_id;
        $res = $this->userRepository->deleteAccount($id);

        if($res)
            return response()->json(['message'=>__("api.messages.success_delete_account"),'success'=>true,'data'=>$res]);
        else
            return response()->json(['message'=>__("api.messages.failed_delete_account"),'success'=>false]);
    }

    public function reportClient(Request $request){

        $reporting_user_id = $request->reporting_user_id;
        $reported_user_id = $request->reported_user_id;
        $report_category_id = $request->report_category_id;
        $description = $request->description;


        $data = $this->userRepository->reportClient($reporting_user_id,$reported_user_id,$report_category_id,$description);

        if($data)
            return response()->json(['message'=>__("api.messages.success_report_client"),'success'=>true,'data'=>$data]);
        else
            return response()->json(['message'=>__("api.messages.failed_report_client"),'success'=>false]);
    }
}
