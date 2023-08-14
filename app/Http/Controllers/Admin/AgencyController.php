<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Http\Requests\Agency\PromoteToAgencyRequest;
use App\Models\Agency\Agency;
use App\Repositories\AgencyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AgencyController extends Controller
{
    private AgencyRepository $agency_repository;

    public function __construct(AgencyRepository $agency_repository)
    {
        $this->agency_repository = $agency_repository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $custom_cond = [];
        if ($request->is_blocked != "") {
            $custom_cond[] = "is_blocked = '$request->is_blocked'";
        }
        if ($request->name != "") {
            $custom_cond[] = "name LIKE '%$request->name%'";
        }
        $users = $this->agency_repository->get_all($custom_cond);

        $users = $users->appends($request->query());

        return view('admin.agency.list', compact('users'));
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
     * Display the specified resource.
     *
     * @param Agency $agency
     * @return JsonResponse
     */
    public function show(Agency $agency): JsonResponse
    {
        $agency = $this->agency_repository->show($agency);
        return $this->response(true, $agency, __("api.messages.show_agency_successfully"));
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
     * @param \Illuminate\Http\Request $request
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
     * @param \App\Models\Agency\Agency $agency
     * @return JsonResponse
     */
    public function verifyAgency($id)
    {
        $res = $this->agency_repository->verifyAgency($id);
        return response()->json([
            'success'=>true,
            'data'=>$res,
            'message'=>__("api.messages.show_agency_successfully")
        ]);
    }

}
