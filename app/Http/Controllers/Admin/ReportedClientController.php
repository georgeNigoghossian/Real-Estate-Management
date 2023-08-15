<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\Controller;
use App\Models\ReportedClient;
use App\Repositories\ReportedClientRepository;
use Illuminate\Http\Request;

class ReportedClientController extends Controller
{
    private $reportedClientRepository;
    public function __construct(ReportedClientRepository $reportedClientRepository)
    {
        $this->reportedClientRepository = $reportedClientRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $custom_cond = [];
        $users = $this->reportedClientRepository->get_all($custom_cond);

        $users =$users->appends($request->query());
        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",
                'url'=>route('admin.home'),
            ],
            '1'=>[
                'title'=>"Reported Users",

            ]
        ];

        return view('admin.repoted_client.list',compact('users','breadcrumb'));
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
     * @param  \App\Models\ReportedClient  $reportedClient
     * @return \Illuminate\Http\Response
     */
    public function show(ReportedClient $reportedClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReportedClient  $reportedClient
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportedClient $reportedClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReportedClient  $reportedClient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportedClient $reportedClient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReportedClient  $reportedClient
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportedClient $reportedClient)
    {
        //
    }
}
