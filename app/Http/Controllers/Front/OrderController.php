<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrdersProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function receiveOrder($id=null){
       $getOrders = Order::getOrders();
        //    dd($getOrders);
        foreach($getOrders as $order['orders_products']){
            $order_id = $order['orders_products']['id'];
            // dd($order_id);
                foreach($order as $current){
                    // dd($current['orders_products']);
                    foreach ($current as $final){
                        dd($final);
                        if($order_id == $final){
                            $received = "Yes";
                            Order::where(['id'==$final])->update(['order_received'=>$received]);

                        }
                    }
                }
                
        }
        //    dd($order_id);
       
    //     // Order::where(['id'=>$selectedOrderId])->update(['order_received'=>$received]);
            
    //     }
    

        
        return view('front.orders.received')->with(compact('getOrders'));
        

    }
}
