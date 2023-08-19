<?php

namespace Database\Seeders;

use App\Models\ReportCategory;
use Illuminate\Database\Seeder;

class ReportCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReportCategory::create(['name'=>'Scam']);
        ReportCategory::create(['name'=>'This is my property']);
        ReportCategory::create(['name'=>'Fraud']);
        ReportCategory::create(['name'=>'Inappropriate Content']);
        ReportCategory::create(['name'=>'Hate Speech']);
    }
}
