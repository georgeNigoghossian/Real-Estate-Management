<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            UserTableSeeder::class,
            CountriesTableSeeder::class,
            CitiesTableSeeder::class,
            RegionsTableSeeder::class,
        ]);
    }
}
