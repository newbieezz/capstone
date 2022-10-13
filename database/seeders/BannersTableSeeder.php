<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerRecords = [
            ['id'=>1, 'image'=>'banner-1.jpg','link'=>'grocery-stores', 'title'=>'Grocery Stores', 'alt'=>'Grocery Stores', 'status'=>1],
            ['id'=>2, 'image'=>'banner-2.jpg','link'=>'fruits-vegetables', 'title'=>'Fruits and Vegies', 'alt'=>'Fruits and Vegies', 'status'=>1],
        ];
        Banner::insert($bannerRecords);
    }
}
