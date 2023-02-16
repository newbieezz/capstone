<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orders($id=null){

        //for order details, id used to pass
        if(empty($id)){
            $orders = Order::with('orders_products')->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
            return view('front.orders.orders')->with(compact('orders'));
        } else {
            $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();//fetch the details from id
            return view('front.orders.order_details')->with(compact('orderDetails'));
            
        }
        
    }
}
