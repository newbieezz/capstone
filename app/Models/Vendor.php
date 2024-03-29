<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stephenjude\Wallet\Interfaces\Wallet;
use Stephenjude\Wallet\Traits\HasWallet;
class Vendor extends Model implements Wallet
{
    use HasFactory;
    use HasWallet;
    public function vendorshopdetails(){
        //every shop belongs to a vendor (match the id of in the vendor table with the vendor_id)
        return $this->belongsTo('App\Models\VendorsBusinessDetails','id','vendor_id');
    }

    public static function getVendorShop($vendorid){
        $getVendorShop = VendorsBusinessDetails::select('shop_name')->where('vendor_id',$vendorid)->first()->toArray();

        return $getVendorShop['shop_name'];
    }
    public static function getVendorImages($vendorid){
        $getVendorImage = VendorsBusinessDetails::select('shop_image')->where('vendor_id',$vendorid)->first()->toArray();
        return $getVendorImage['shop_image'];
    }

    public static function getVendorDetails(){
        //use of get() for multiple addresses and toArray to convert it to Arrays
        $getVendorDetails = VendorsBusinessDetails::get()->toArray();

        return $getVendorDetails; //used in checkout page (checkout function inside ProductController)
    }

    public static function getVendorTransferFee($vendorid){
        $getVendorTransferFee = Vendor::select('transfer_fee')->first()->toArray();
        return $getVendorTransferFee['transfer_fee'];
    
    }
    
    public function paylaters() {
        return $this->belongsTo('App\Models\Vendor','id','vendor_id');
    }
}
