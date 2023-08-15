<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",

            ],
        ];
        return view('admin.home',compact('breadcrumb'));
    }
}
