<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Order extends Model
{
    use HasFactory;

    public static function getOrders(){
        if(Auth::check()){
            //if user logged in / pick auth id of the user
            $getOrders = Order::with(['orders_products'=>function($query){
                $query->select('id','order_id','vendor_id','product_name','product_code');
            }])->orderby('id','Desc')->where('user_id',Auth::user()->id)->get()->toArray();
        } else {
            //if user not logged in / pick session id of the user
            $getOrders = Order::with(['orders_products'=>function($query){
                $query->select('id','order_id','vendor_id','product_name','product_code');
            }])->orderby('id','Desc')->where('session_id',Session::get('session_id'))->get()->toArray();
        }
        return $getOrders;
    }
    //one order can have multiple/many products
    public function orders_products(){
        return $this->hasMany('App\Models\OrdersProduct','order_id');
    }

    public function pay_laters(){
        return $this->hasMany('App\Models\PayLater', 'order_id', 'id');
    }
    

}
