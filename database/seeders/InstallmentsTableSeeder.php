<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstallmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('installments')
            ->insert([
                [
                    'number_of_months' => 1,
                    'interest_rate' => 1,
                    'description'      => 'Pay in 1 month'
                ],
                [
                    'number_of_months' => 3,
                    'interest_rate' => 1.25,
                    'description'      => 'Pay in 3 months'
                ],
                [
                    'number_of_months' =>  6,
                    'interest_rate' => 1.50,
                    'description'      => 'Pay in 6 months'
                ],
                [
                    'number_of_months' => 9,
                    'interest_rate' => 1.75,
                    'description'      => 'Pay in 9 months'
                ],
                [
                    'number_of_months' => 12,
                    'interest_rate' => 2,
                    'description'      => 'Pay in 12 months'
                ],
            ]);
    }
}
