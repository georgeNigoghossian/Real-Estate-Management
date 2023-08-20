<?php

namespace App\Repositories;

use App\Http\Controllers\App\Notifications\FireBaseNotificationController;
use App\Models\Agency\Agency;
use App\Models\AgencyRequest;
use App\Models\File;
use App\Models\Location\Country;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

//use Your Model

/**
 * Class UserRepository.
 */
class CountryRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model(): string
    {
        return Country::class;
    }

    public function get_all($custom_cond = [], $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator|array|\LaravelIdea\Helper\App\Models\_IH_User_C|\Illuminate\Pagination\LengthAwarePaginator
    {
        $query = Country::query();

        if (count($custom_cond) > 0) {
            $custom_cond = implode(' AND ', $custom_cond);
            $query = $query->whereRaw($custom_cond);
        }

        return $query->paginate($perPage);
    }

    public function create($data)
    {
        return Country::create([
            'name'=>$data['name']
        ]);
    }
}
