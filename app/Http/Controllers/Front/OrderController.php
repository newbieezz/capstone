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
            $orderDetails = Order::with('orders_products')->where('id',$id)->orderBy('id','Desc')->first()->toArray();//fetch the details from id
            return view('front.orders.order_details')->with(compact('orderDetails'));
            
        }
        
    }

    public function receiveOrder(Request $request){
    //    $getOrders = Order::getOrders();
    //     //    dd($getOrders);
    //     // foreach($getOrders as $order['orders_products']){
    //     //     $order_id = $order['orders_products']['id'];
    //     //     // dd($order_id);
    //     //     $received = "Yes";
    //     //     Order::where('id',$order_id)->update(['order_received'=>$received]);
                
    //     // }
    //             // NOT DONE YET -> ALL THE ORDERS WILL CHANGED
    //      //group the cart items by vendor
    //      foreach($getOrders as $order['orders_products']){
    //         $order_id = $order['orders_products']['id'];
    //         if (!isset($getOrderid[$order_id])) {
    //             $getOrderid[$order_id] = [];
    //         }
    //         $getOrderid[$order_id][] = $order;
    //         // dd($getOrderid);
    //         $selectedOrderId = $getOrderid;
    //         // dd($selectedOrderId);
    //         $groupedProducts = [];
    //         foreach($selectedOrderId as $key => $value) {
    //             $groupedProducts[$key] = $value;
    //             // dd($groupedProducts);
    //             $received = "Yes";
    //             Order::where('id',$order_id)->update(['order_received'=>$received]);
    //         }
    //     }
    
        if($request->isMethod('post')){
            $data = $request->all();
            // dd($data);
                $received = "Yes";
            Order::where('id',$data['order_id'])->update(['order_received'=>$received]);
        }

        
        return view('front.orders.received');
        

    }
}
