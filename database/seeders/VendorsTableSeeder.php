<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            ['id'=>1, 'name'=>'Cherry', 'address'=>'Sambag 2', 'city'=>'Cebu City','pincode'=>'110001',
                'mobile'=>'09230442135', 'email'=>'cherry@admin.com', 'status'=>0], 
        ];
        Vendor::insert($vendorRecords);
    }
}
