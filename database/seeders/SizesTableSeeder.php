<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['id'=>1, 'name'=>'Newborn'],
            ['id'=>2, 'name'=>'Small'],
            ['id'=>3, 'name'=>'Medium'],
            ['id'=>4, 'name'=>'Large'],
            ['id'=>5, 'name'=>'X-Large'],
            ['id'=>6, 'name'=>'XX-Large'],
            ['id'=>7, 'name'=>'XXX-Large'],
        ];
        Size::insert($records);
    }
}
