<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\PromoteToAgencyRequest;
use App\Models\Agency\Agency;
use App\Models\AgencyRequest;
use App\Repositories\AgencyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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

        $breadcrumb = [
            '0' => [
                'title' => "Dashboard",
                'url' => route('admin.home'),
            ],
            '1' => [
                'title' => "Agency",

            ]
        ];


        return view('admin.agency.list', compact('users', 'breadcrumb'));
    }

    public function requests_index(Request $request)
    {

        $custom_cond = [];
        if ($request->name != "") {
            $custom_cond[] = "name LIKE '%$request->name%'";
        }
        $users = $this->agency_repository->get_all_requests($custom_cond);

        $users = $users->appends($request->query());

        $breadcrumb = [
            '0' => [
                'title' => "Dashboard",
                'url' => route('admin.home'),
            ],
            '1' => [
                'title' => "Agency Requests",

            ]
        ];


        return view('admin.agency_request.list', compact('users', 'breadcrumb'));
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
     * @param $id
     * @return RedirectResponse
     */
    public function verifyAgency($id)
    {
        $this->agency_repository->verifyAgency($id);
        return redirect()->route('admin.agency_requests.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function rejectAgency($id)
    {
        $res = $this->agency_repository->rejectAgency($id);
        return redirect()->route('admin.agency_requests.index');
    }

    public function agency_request_details($id)
    {
        $agency_request = $this->agency_repository->get_agency_request_details($id);
        $agency = $this->agency_repository->get_agency_details($agency_request['user']);
        $user = $agency_request['user']
;
//        $media = $agency["media"]->toArray();
//
//        if(count($media) >0 ){
//            $photo_url = $media["0"]["original_url"];
//
//        }else{
//            $photo_url = asset('assets/img/home-decor-1.jpg');
//        }

        $breadcrumb = [
            '0' => [
                'title' => "Dashboard",
                'url' => route('admin.home'),
            ],
            '1' => [
                'title' => "Agency Requests",
                'url' => route('admin.agency_requests.index')
            ],
            '2' => [
                'title' => "Details",
            ]
        ];
        return view('admin.agency_request.details', compact('agency_request', 'agency', 'user', 'breadcrumb'));
    }

}
