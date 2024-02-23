<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\ReportCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportCategoryController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $report_categories = ReportCategory::all();
        return $this->response(true, $report_categories, 'All report categories');
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
     * @param \App\Models\ReportCategory $reportCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ReportCategory $reportCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ReportCategory $reportCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportCategory $reportCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReportCategory $reportCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportCategory $reportCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ReportCategory $reportCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportCategory $reportCategory)
    {
        //
    }
}
