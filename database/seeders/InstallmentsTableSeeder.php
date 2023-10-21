<?php

namespace Database\Seeders;

use App\Models\Installment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstallmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $installmentsRecords = [
                ['number_of_weeks'=>1, 'interest_rate'=>2, 'description'=>'Pay in 1 week'],
                ['number_of_weeks'=>2, 'interest_rate'=>3, 'description'=>'Pay in 2 week'],
                ['number_of_weeks'=>3, 'interest_rate'=>4, 'description'=>'Pay in 3 week'],
                ['number_of_weeks'=>4, 'interest_rate'=>5, 'description'=>'Pay in 4 week'],
            ];
            Installment::insert($installmentsRecords);
    }
}
