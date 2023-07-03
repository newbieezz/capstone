<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorsBusinessDetails extends Model
{
    use HasFactory;

    
    public static function getVendorShop($vendorid){
        $getVendorShop = VendorsBusinessDetails::select('shop_name')->where('vendor_id',$vendorid)->first();

        return $getVendorShop['shop_name'];
    }
}
