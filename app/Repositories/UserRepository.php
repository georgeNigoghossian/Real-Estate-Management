<?php

namespace App\Repositories;

use App\Models\Agency\Agency;
use App\Models\ReportedClient;
use App\Models\User;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Illuminate\Support\Facades\Validator;

//use Your Model

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function reportClient($reporting_user_id, $reported_user_id, $report_category_id, $description)
    {
        return ReportedClient::create([
            'description' => $description ?: null,
            'reporting_user_id' => $reporting_user_id,
            'reported_user_id' => $reported_user_id,
            'report_category_id' => $report_category_id,
        ]);
    }

    public function deleteAccount($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return true;
        } else {
            return false;
        }


    }

    public function get_all($custom_cond = [], $perPage = 10)
    {
        $query = User::query();


        if (count($custom_cond) > 0) {
            $custom_cond = implode(' AND ', $custom_cond);
            $query = $query->whereRaw($custom_cond);
        }

        $usersWithAgency = Agency::whereNotNull('created_by')->pluck('created_by');

        $query = $query->whereNotIn('id', $usersWithAgency);


        return $query->paginate($perPage);
    }

    public function get_single_user($id)
    {
        $user = User::find($id);

        if ($user) {
            return $user;
        } else {
            return null;
        }
    }


    public function updateAccount($user, $values)
    {

        $allowed_fields = ['name', 'email', 'facebook', 'mobile', 'gender', 'date_of_birth', 'fcm_token'];

        foreach ($allowed_fields as $field) {

            if (isset($values[$field]) && $values[$field] != null) {
                $user->$field = $values[$field];
            }
        }

        return $user->save();
    }


    public function changeBlockStatus($user_id, $status)
    {
        $user = User::where('id', $user_id)->update([
            'is_blocked' => $status,
        ]);
        return $user;
    }

    public function updatePriority($user_id, $priority)
    {
        $user = User::where('id', $user_id)->update([
            'priority' => $priority
        ]);
    }

}
