<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;

class DeliveryAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryInfo = [
                ['id'=>1,'user_id'=>1, 'name'=>'Cherry Veloso', 'address'=>'Sambag 2', 
                  'city'=>'Cebu ','mobile'=>'09321654987','email'=>'sample@email.com','status'=>1],
                  
                ['id'=>2,'user_id'=>1, 'name'=>'Cherry Veloso', 'address'=>'Sapangdaku', 
                  'city'=>'Cebu ','mobile'=>'09789654123','email'=>'sample@email.com','status'=>1],
        ];
        DeliveryAddress::insert($deliveryInfo);
    }
}
