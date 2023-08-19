<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JsValidator;
use Spatie\Permission\Models\Permission;

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

        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",
                'url'=>route('admin.home'),
            ],
            '1'=>[
                'title'=>"Admins",

            ]
        ];

        return view('admin.admins.list', compact('admins','breadcrumb'));
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

        $model = new Admin();

        $validation_rules = [];
        if(isset($model->validation_rules) && count($model->validation_rules)>0){
            $validation_rules = $model->validation_rules;
        }

        $jsValidator = JsValidator::make($validation_rules);

        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",
                'url'=>route('admin.home'),
            ],
            '1'=>[
                'title'=>"Admins",
                'url'=>route('admin.admins.list')
            ],
            '2'=>[
                'title'=>"Create Admin",
            ]
        ];

        return view('admin.admins.create',compact('jsValidator','breadcrumb'));
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

        $model = new Admin();
        if (isset($model->validation_rules) && is_array($model->validation_rules)) {
            $validation_rules = $model->validation_rules;
            $validation_rules['mobile']='required|unique:admins,mobile';

            $request->validate($validation_rules);
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
        ]);

        $adminRole = Role::findByName('admin');
        $admin->assignRole($adminRole);

        session()->flash('success', 'Admin Created successfully!');
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
        if (!Auth::user()->hasRole('superadmin')) {
            abort(404);
        }

        $model = new Admin();

        $validation_rules = [];
        if(isset($model->validation_rules) && count($model->validation_rules)>0){
            $validation_rules = $model->validation_rules;
        }
        unset($validation_rules['password']);
        $jsValidator = JsValidator::make($validation_rules);

        $admin = Admin::find($request->id);


        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",
                'url'=>route('admin.home'),
            ],
            '1'=>[
                'title'=>"Admins",
                'url'=>route('admin.admins.list')
            ],
            '2'=>[
                'title'=>"Edit Admin",
            ]
        ];

        return view('admin.admins.create',compact('admin','jsValidator','breadcrumb'));
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

        if (!Auth::user()->hasRole('superadmin')) {
            abort(404);
        }

        $model = new Admin();
        if (isset($model->validation_rules) && is_array($model->validation_rules)) {
            $validation_rules = $model->validation_rules;
            $validation_rules['mobile']='required|unique:admins,mobile,'.$id;
            unset($validation_rules['password']);

            $request->validate($validation_rules);
        }

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

        session()->flash('success', 'Admin Updated successfully!');
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

    public function edit_profile(){
        $model = new Admin();

        $validation_rules = [];
        if(isset($model->validation_rules) && count($model->validation_rules)>0){
            $validation_rules = $model->validation_rules;
        }
        unset($validation_rules['password']);
        $jsValidator = JsValidator::make($validation_rules);

        $admin = Admin::find(auth()->user()->id);


        $breadcrumb =  [
            '0'=>[
                'title'=>"Dashboard",
                'url'=>route('admin.home'),
            ],
            '1'=>[
                'title'=>"Edit Profile",
            ]
        ];

        return view('admin.edit_profile',compact('admin','jsValidator','breadcrumb'));

    }

    public function update_profile($id,Request $request)
    {


        $model = new Admin();
        if (isset($model->validation_rules) && is_array($model->validation_rules)) {
            $validation_rules = $model->validation_rules;
            $validation_rules['mobile']='required|unique:admins,mobile,'.$id;
            unset($validation_rules['password']);

            $request->validate($validation_rules);
        }

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

        session()->flash('success', 'Profile Information Updated successfully!');
        return redirect()->back();
    }

}
