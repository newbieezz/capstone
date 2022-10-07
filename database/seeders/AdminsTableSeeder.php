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
            ['id' => 2,'name'=>'Cherry','type'=>'vendor','vendor_id'=>1,'mobile'=>'09230442135',
                'email'=>'cherry@admin.com','password'=>'$2a$12$GkhnfzbiN19p07DWiovzPe1zUBv1VKRGTyGFC2mbgX6qZibOZvAli','image'=>'','status'=>0],
        ];
        Admin::insert($adminRecords);

    }
}
