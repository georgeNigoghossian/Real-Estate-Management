<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasRole('superadmin')) {
            abort(404);
        }

        $custom_cond = [];

        $adminRole = Role::where('name', 'admin')->first();

        if ($request->name != "") {
            $custom_cond[] = "name LIKE '%$request->name%'";
        }

        $query = Admin::role($adminRole->name);

        if (count($custom_cond) > 0) {
            $custom_cond = implode(' AND ', $custom_cond);
            $query = $query->whereRaw($custom_cond);
        }

        $admins = $query->paginate(10)->appends($request->query());

        return view('admin.admins.list', compact('admins'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!Auth::user()->hasRole('superadmin')) {
            abort(404);
        }
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('superadmin')) {
            abort(404);
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
        ]);

        $adminRole = Role::findByName('admin');
        $admin->assignRole($adminRole);

        return redirect()->route('admin.admins.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $admin = Admin::find($request->id);

        return view('admin.admins.create',compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $admin = Admin::find($id);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ];

        if($request->password != ""){
            $data["password"]= bcrypt($request->password);
        }
        $admin = $admin->update($data);

        return redirect()->route('admin.admins.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $admin = Admin::find($id);
        $admin->delete();

        return redirect()->back();
    }

    public function run(){
        $admin = Admin::find(1);

        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $admin->assignRole($superadminRole);
    }
}
