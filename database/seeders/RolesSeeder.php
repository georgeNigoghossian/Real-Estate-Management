<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Role::create([
            'name'=>'admin',
            'guard_name'=>'Admin'
        ]);
        Role::create([
            'name'=>'client',
            'guard_name'=>'Client'
        ]);
        Role::create([
            'name'=>'agency',
            'guard_name'=>'Agency'
        ]);
    }
}
