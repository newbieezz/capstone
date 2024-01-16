<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\GcashPayment;
use App\Models\Order;
use App\Models\OrdersProduct;
use App\Models\ProductsAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;
use App\Models\Notification;
use App\Models\Rider;
use App\Models\VendorsBusinessDetails;
use App\Models\VendorsBankDetails;
class OrderController extends Controller
{
    public function orders($id=null){

        //for order details, id used to pass
        if(empty($id)){
            $orders = Order::with('orders_products')->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
            return view('front.orders.orders')->with(compact('orders'));
        } else {
            $orderDetails = Order::with('orders_products')->where('id',$id)->orderBy('id','Desc')->first()->toArray();//fetch the details from id
            // $rider = Rider::first()->toArray();
            $rider = Rider::where('order_id',$orderDetails['id'])->first();
            
            return view('front.orders.order_details')->with(compact('orderDetails','rider'));
            
        }
        
    }

    public function receiveOrder(Request $request){
        // dd($orders['vendor_id']);//
        if($request->isMethod('post')){
            $data = $request->all();
            // dd($data);
                $orders = Order::with('orders_products')->where('user_id',Auth::user()->id)->first()->toArray();
                $vendor_id = $orders['vendor_id'];
                $received = "Yes";
            Order::where('id',$data['order_id'])->update(['order_received'=>$received]);
            Notification::insert([
                'module' => 'order',
                'module_id' => $data['order_id'],
                'user_id' => $vendor_id, //VENDOR id
                'sender' => 'customer',
                'receiver' => 'vendor',
                'message' => "Order has been received. Check order ID: " . $data['order_id']
            ]);
        }
        
        return view('front.orders.received');
        
    }

    public function gcash(Request $request){
        
        // dd($vendor);

        if(Session::has('order_id'))
        {   
            $orderDetails = Order::get()->first()->toArray();//fetch the details from id
            $vendor = VendorsBankDetails::where('vendor_id',$orderDetails['vendor_id'])->first()->toArray();
            return view('front.gcash.gcash')->with(compact('vendor','orderDetails'));
            
        } else{
            return redirect('cart');
        }
    }

    public function gcashpay(Request $request){
        Session::get('user_name');
        // Session::get('order_id');
            if($request->isMethod('post')){
                $data = $request->all();
                
             // Upload Image/Photo
            if($image = $request->file('payment_proof')){
                $path = 'front/images/gcash';
                $name = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($path, $name);
                $data['payment_proof'] = "$name";
            } 
                    $received = "Yes";

                    $gcash = new GcashPayment;
                    $gcash->order_id = Session::get('order_id');
                    $gcash->user_id = Auth::user()->id;
                    $gcash->payer_id = mt_rand(100000,999999);
                    $gcash->amount = Session::get('grand_total');
                    $gcash->payment_status = 'Success';
                    $gcash->payment_proof = $data['payment_proof'];
                    // dd($gcash);
                    $gcash->save();

                    // send order email upon successfully paid
                    $order_id = Session::get('order_id');
                    $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();
                    //update order status in db
                    Order::where('id',$order_id)->update(['order_status'=>'Paid']);
                    $email = Auth::user()->email; //get the email from user model
                    $messageData = [
                        'email' => $email,
                        'name' => Auth::user()->name,
                        'order_id' => $order_id,
                        'orderDetails' => $orderDetails
                    ];
                    Mail::send('emails.order',$messageData,function($message)use($email){
                        $message->to($email)->subject('Order Placed - P-Store Mart');
                    });
                    
                    Notification::insert([
                        'module' => 'order',
                        'module_id' => $order_id,
                        'user_id' => $orderDetails['orders_products'][0]['vendor_id'],
                        'sender' => 'customer',
                        'receiver' => 'vendor',
                        'message' => Auth::user()->name . ' has made an order. Please check order ID: ' . $order_id
                    ]);

                
            
            //empty the cart
            Cart::where('user_id',Auth::user()->id)->delete();
            return view('front.pay_later.paymentsuccess');
            
        }
    }

}
