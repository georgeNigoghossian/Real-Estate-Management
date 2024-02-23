<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\Controller;
use App\Models\Agency\Agency;
use App\Models\Property\Agricultural;
use App\Models\Property\Commercial;
use App\Models\Property\Property;
use App\Models\Property\Residential;
use App\Models\User;

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

        $properties_count = Property::count();
        $users_count = User::count();
        $agencies_count = Agency::count();
        $blocked_users_count = User::where('is_blocked',1)->count();

        $total_residential = Residential::count();
        $total_agricultural = Agricultural::count();
        $total_commercial = Commercial::count();

        return view('admin.home',compact('breadcrumb','users_count','properties_count','agencies_count','blocked_users_count','total_residential','total_agricultural','total_commercial'));
    }
}
