<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::create([
            'name' => 'Rita',
            'email' => 'rita@gmail.com',
            'password' => Hash::make('password'),
            'sms_verified_at' => '2023-07-15 11:52:50',
            'mobile' => '+963932909535'
        ]);

    }
}
