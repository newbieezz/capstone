<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public function vendorshopdetails(){
        //every shop belongs to a vendor (match the id of in the vendor table with the vendor_id)
        return $this->belongsTo('App\Models\VendorsBusinessDetails','id','vendor_id');
    }

    public static function getVendorShop($vendorid){
        $getVendorShop = VendorsBusinessDetails::select('shop_name')->where('vendor_id',$vendorid)->first();

        return $getVendorShop['shop_name'];
    }
}
