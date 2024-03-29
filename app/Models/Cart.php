<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;

    public static function getCartItems(){
        if(Auth::check()){
            //if user logged in / pick auth id of the user
            $getCartItems = Cart::with(['product'=>function($query){
                $query->select('id','category_id','vendor_id','product_name','product_code','product_image');
            }])->orderby('id','Desc')->where('user_id',Auth::user()->id)->get()->toArray();
        } else {
            //if user not logged in / pick session id of the user
            $getCartItems = Cart::with(['product'=>function($query){
                $query->select('id','category_id','vendor_id','product_name','product_code','product_image');
            }])->orderby('id','Desc')->where('session_id',Session::get('session_id'))->get()->toArray();
        }

        return $getCartItems;
    }

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }

    //relation between vendor and cart items
    public function vendor(){
        //cart belongs to a vendor
        return $this->belongsTo('App\Models\Vendor','vendor_id')->with('vendorshopdetails');
    }
}
