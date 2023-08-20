<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\CreateCityRequest;
use App\Models\Location\City;
use App\Models\Location\Country;
use App\Models\Property\AmenityType;
use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JsValidator;

class CityController extends Controller
{
    private CityRepository $city_repository;

    public function __construct(CityRepository $city_repository)
    {
        $this->city_repository = $city_repository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $custom_cond = [];
        if ($request->name != "") {
            $custom_cond[] = "name LIKE '%$request->name%'";
        }
        $cities = $this->city_repository->get_all($custom_cond);

        $cities = $cities->appends($request->query());

        $breadcrumb = [
            '0' => [
                'title' => "Dashboard",
                'url' => route('admin.home'),
            ],
            '1' => [
                'title' => "City",

            ]
        ];


        return view('admin.city.list', compact('cities', 'breadcrumb'));
    }

    public function create_page()
    {
        $model = new City();

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
                'title'=>"Cities",
                'url'=>route('admin.city.index')
            ],
            '2'=>[
                'title'=>"Insert City",
            ]
        ];
        $countries = Country::all();
        return view('admin.city.create',compact('countries','jsValidator', 'breadcrumb'));
    }

    public function create(CreateCityRequest $request){
        $this->city_repository->create($request->validated());

        return redirect()->route('admin.city.index');
    }
}
