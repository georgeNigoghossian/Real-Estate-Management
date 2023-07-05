<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;

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
