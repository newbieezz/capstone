<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        //inserting data to admins table
        $adminRecords = [
            ['id' => 1,'name'=>'Veloso','type'=>'subadmin','vendor_id'=>0,'mobile'=>'09230442135',
                'email'=>'admin@admin.com','password'=>'$2a$12$IEVhzwmNT5N6VRqxWuS5wuS2wCeSoRu37mpfIpV9/VGR5teCVvBCW','image'=>'','status'=>1],
        ];
        Admin::insert($adminRecords);

    }
}
