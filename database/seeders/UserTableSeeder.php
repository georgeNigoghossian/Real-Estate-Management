<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Agency\Agency;
use App\Models\AgencyRequest;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $client = User::create([
            'name' => 'Rita',
            'email' => 'rita@gmail.com',
            'password' => Hash::make('password'),
            'sms_verified_at' => '2023-07-15 11:52:50',
            'mobile' => '+963932909535'
        ]);
        $role = Role::find(2);
        $client->roles()->attach($role);
        $admin = Admin::create([
            'name' => 'RitaAdmin',
            'email' => 'rita2@gmail.com',
            'password' => Hash::make('password'),
            'mobile' => '+963932909536',
        ]);
        $role = Role::find(1);
        $admin->roles()->attach($role);
        $admin->save();
        $agency_user = User::create([
            'name' => 'RitaAgency',
            'email' => 'rita3@gmail.com',
            'password' => Hash::make('password'),
            'mobile' => '+963932909537',
            'sms_verified_at' => '2023-07-15 11:52:50'
        ]);
        $agency = Agency::create([
            'latitude' => 56.5,
            'longitude' => 23.7,
        ]);
        $request = AgencyRequest::create([
            'reason' => 'I want to become an agency.',
            'user_id' => $agency_user->id
        ]);
        DB::table('agency_request_agency')->insert(['agency_id' => $agency->id, 'agency_request_id' => $request->id]);

        $role = Role::find(3);
        $agency_user->roles()->attach($role);
        $agency->creator()->associate($agency_user);
        $agency->save();
    }
}
