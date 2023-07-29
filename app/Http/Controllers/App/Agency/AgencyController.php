<?php

namespace App\Http\Controllers\App\Agency;

use App\Http\Controllers\App\AppController;
use App\Http\Requests\Agency\PromoteToAgencyRequest;
use App\Models\Agency\Agency;
use App\Repositories\AgencyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AgencyController extends AppController
{
    private AgencyRepository $agency_repository;

    public function __construct(AgencyRepository $agency_repository)
    {
        $this->agency_repository = $agency_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PromoteToAgencyRequest $request
     * @return JsonResponse
     */
    public function store(PromoteToAgencyRequest $request)
    {
        $user = $request->user();
        if (Agency::where('created_by', '=',$user->id)->exists()) {
            return $this->response(false, null,  __("api.messages.promote_to_agency_failed"));
        }
        $agency = $this->agency_repository->promote($request->validated(), $user);
        return $this->response(true, $agency,  __("api.messages.promote_to_agency_success"));
    }

    /**
     * Display the specified resource.
     *
     * @param Agency $agency
     * @return JsonResponse
     */
    public function show(Agency $agency): JsonResponse
    {
        $agency = $this->agency_repository->show($agency);
        return $this->response(true, $agency,  __("api.messages.show_agency_successfully"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Agency $agency
     * @return \Illuminate\Http\Response
     */
    public function edit(Agency $agency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Agency $agency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agency $agency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Agency $agency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agency $agency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agency\Agency  $agency
     * @return Response
     */
    public function verifyAgency($id)
    {
        $res = $this->agency_repository->verifyAgency($id);
//        return $this->response(true, $res,  __("api.messages.show_agency_successfully"));
    }
}
