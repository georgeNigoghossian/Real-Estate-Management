<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\CreateCountryRequest;
use App\Models\Location\Country;
use App\Models\Property\AmenityType;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JsValidator;

class CountryController extends Controller
{
    private CountryRepository $country_repository;

    public function __construct(CountryRepository $country_repository)
    {
        $this->country_repository = $country_repository;
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
        $countries = $this->country_repository->get_all($custom_cond);

        $countries = $countries->appends($request->query());

        $breadcrumb = [
            '0' => [
                'title' => "Dashboard",
                'url' => route('admin.home'),
            ],
            '1' => [
                'title' => "Country",

            ]
        ];


        return view('admin.country.list', compact('countries', 'breadcrumb'));
    }

    public function create_page()
    {
        $model = new Country();

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
                'title'=>"Countries",
                'url'=>route('admin.country.index')
            ],
            '2'=>[
                'title'=>"Insert Country",
            ]
        ];
        return view('admin.country.create',compact('jsValidator', 'breadcrumb'));
    }

    public function create(CreateCountryRequest $request){
        $this->country_repository->create($request->validated());

        return redirect()->route('admin.country.index');
    }
}
