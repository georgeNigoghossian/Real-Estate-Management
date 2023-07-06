<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;

class HomeController extends AppController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
