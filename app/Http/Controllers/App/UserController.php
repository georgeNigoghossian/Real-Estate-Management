<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private UserRepository $userRepository;

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        $id = $request->user_id;
        $res = $this->userRepository->get_single_user($id);

        if ($res != null)

            return $this->response(true, $res, __("api.messages.success_retrieve_account"), 200);
        else
            return $this->response(false, null, __("api.messages.failed_retrieve_account"), 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $User
     * @return \Illuminate\Http\Response
     */
    public function edit(User $User)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $user = $request->user();
        $model = new User();

        $validator = Validator::make($request->all(),
            $model->validation_rules
        );

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->response(false, $errors, __("api.messages.failed_update_account"), 400);
        } else {
            $values = $request->all();

            $res = $this->userRepository->updateAccount($user, $values);
            if ($res) {
                return $this->response(true, $user, __("api.messages.success_update_account"), null);
            } else {
                return $this->response(false, null, __("api.messages.failed_update_account"), 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function delete()
    {

        $id = auth()->user()->id;
        $res = $this->userRepository->deleteAccount($id);

        if ($res)
            return $this->response(true, $res, __("api.messages.success_delete_account"), null);
        else
            return $this->response(false, null, __("api.messages.failed_delete_account"), null);
    }

    public function reportClient(Request $request)
    {

        $reporting_user_id = auth()->user()->id;
        $reported_user_id = $request->reported_user_id;
        $report_category_id = $request->report_category_id;
        $description = $request->description;


        $data = $this->userRepository->reportClient($reporting_user_id, $reported_user_id, $report_category_id, $description);

        if ($data)
            return $this->response(true, $data, __("api.messages.success_report_client"), 200);
        else
            return $this->response(false, null, __("api.messages.failed_report_client"), null);
    }

    public function getUserByToken(): JsonResponse
    {
        return $this->response(true, auth()->user());
    }

}
