<?php

namespace App\Repositories;

use App\Http\Controllers\App\Notifications\FireBaseNotificationController;
use App\Models\Agency\Agency;
use App\Models\AgencyRequest;
use App\Models\File;
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
class AgencyRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model(): string
    {
        return Agency::class;
    }

    public function show(Agency $agency): Agency
    {
        $agency->getMedia();
        return $agency;
    }

    public function promote($data, $user): Agency
    {
        $request = AgencyRequest::create([
            'reason' => $data['reason'],
            'user_id' => $user->id
        ]);
        $agency = Agency::create([
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'contact_info' => null,
            'created_by' => $user->id,
            'region_id' => null,
        ]);
        $images = $data['files'];
        foreach ($images as $image) {
            $agency->addMedia($image)->toMediaCollection('images');
        }
        FireBaseNotificationController::PromoteAgencyNotificationTrigger($user->fcm_token);
        $agency->request = $request;
        DB::table('agency_request_agency')->insert(['agency_id' => $agency->id, 'agency_request_id' => $request->id]);
        return $agency;
    }

    public function verifyAgency($id)
    {
        $agency = Agency::where('id', $id)->first();
        $agency->creator()->update(['priority' => 5]);
        return $agency->update(['is_verified' => 1]);
    }

    public function rejectAgency($id)
    {
        return Agency::where('id', $id)->delete();
    }

    public function get_all($custom_cond = [], $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator|array|\LaravelIdea\Helper\App\Models\_IH_User_C|\Illuminate\Pagination\LengthAwarePaginator
    {
        $query = User::query()->whereHas('agency', function ($query) {
            $query->where('is_verified', '=', 1);
        })->with('agency');

        if (count($custom_cond) > 0) {
            $custom_cond = implode(' AND ', $custom_cond);
            $query = $query->whereRaw($custom_cond);
        }

        return $query->paginate($perPage);
    }

    public function get_all_requests($custom_cond = [], $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator|array|\LaravelIdea\Helper\App\Models\_IH_User_C|\Illuminate\Pagination\LengthAwarePaginator
    {
        $query = User::query()->whereHas('agency', function ($query) {
            $query->where('is_verified', '=', 0);
        })->with('agency', 'agency_requests');

        if (count($custom_cond) > 0) {
            $custom_cond = implode(' AND ', $custom_cond);
            $query = $query->whereRaw($custom_cond);
        }

        return $query->paginate($perPage);
    }

    public function requestStatus($user)
    {
        $agency = Agency::where('created_by', '=', $user->id)->first();
        if ($agency) {
            return $agency->status();
        } else {
            return $user->AgencyRequestStatus();
        }
    }

    public function get_agency_request_details($id)
    {
        return AgencyRequest::where('id', $id)->with('user')->first();
    }

    public function get_agency_details($user)
    {
        $agency = $user->agency()->first();
        return $this->show($agency);
    }

    public function get_agency_user($id)
    {
        return Agency::where('id', $id)->with('creator', 'creator.properties')->first();
    }

}
