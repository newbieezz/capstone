<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProdMeasurements;

class ProdMeasurementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id'=>1, 'measurement'=>'mg', 'description'=>'Milligrams'],
            ['id'=>2, 'measurement'=>'g', 'description'=>'Grams'],
            ['id'=>3, 'measurement'=>'kg', 'description'=>'Kilograms'],
            ['id'=>4, 'measurement'=>'ml', 'description'=>'Milliliters'],
            ['id'=>5, 'measurement'=>'l', 'description'=>'Liters'],
        ];
        ProdMeasurements::insert($records);
    
    }
}
