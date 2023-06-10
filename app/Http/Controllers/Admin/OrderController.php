<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItemStatus;
use App\Models\OrdersLog;
use App\Models\OrdersProduct;
use App\Models\OrderStatus;
use App\Models\User;
use App\Models\Paylater;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use \Carbon\Carbon;

class OrderController extends Controller
{
    public function orders(){
        Session::put('page','orders');

        //asses module if vendor is not approved vendor can't view orders
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;

        if($adminType=="vendor"){
            //check vendor status
            $vendorStatus = Auth::guard('admin')->user()->status; //if 0 redirect to ask to fill for more details before he/she cann add some product
            if($vendorStatus==0){
                return redirect('admin/update-vendor-details/personal')->with('error_message','Your Vendor Account is not approved yet. Please make sure too fill your valid personal, business and bank details!');
            }
        }

        if($adminType=="vendor"){
            $orders = Order::with(['orders_products'=>function($query)use($vendor_id){
                $query->where('vendor_id',$vendor_id);
            }])->orderBy('id','Desc')->get()->toArray(); //subquery to see only those products that belongs to a particular vendor by its vendor_id
        } else {
            $orders = Order::with('orders_products')->orderBy('id','Desc')->get()->toArray(); //for admin query
            // $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        }

        return view('admin.orders.orders')->with(compact('orders'));
        
    }

    public function orderDetails($id){
        Session::put('page','orders');
        //vendor will only see his/her own products
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if($adminType=="vendor"){
            //check vendor status
            $vendorStatus = Auth::guard('admin')->user()->status; //if 0 redirect to ask to fill for more details before he/she cann add some product
            if($vendorStatus==0){
                return redirect('admin/update-vendor-details/personal')->with('error_message','Your Vendor Account is not approved yet. Please make sure too fill your valid personal, business and bank details!');
            }
        }

        if($adminType=="vendor"){
            $orderDetails = Order::with(['orders_products'=>function($query)use($vendor_id){
                $query->where('vendor_id',$vendor_id);
            }])->where('id',$id)->first()->toArray();
        } else {
            $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        }
        
        //fetch the user details
        $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();
        $orderStatus = OrderStatus::where('status',1)->get()->toArray();
        $orderLog = OrdersLog::with('orders_products')->where('order_id',$id)->orderBy('id','Desc')->get()->toArray();
        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails','orderStatus','orderLog'));
    }

    public function updateOrderStatus(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //update order status
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
          
            //update courier name and tacking number
            if(!empty($data['courier_name']) && !empty($data['tracking_number'])){
                Order::where('id',$data['order_id'])->update(['courier_name'=>$data['courier_name'],
                        'tracking_number'=>$data['tracking_number']]);
            }

            //update order log
            $log = new OrdersLog();
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();

            if ($data['order_status'] == 'Delivered') {
                $pay_later = PayLater::where('order_id', $data['order_id'])->get();
                foreach ($pay_later as $key => $value) {
                    PayLater::find($value['id'])->update([
                        'due_date' => Carbon::now()->addMonths($key + 1)->format('Y-m-d')
                    ]);
                }
            }

            //get delivery address
            $deliveryDetails = Order::select('mobile','email','name')->where('id',$data['order_id'])->first()->toArray();
            $orderDetails = Order::with('orders_products')->where('id',$data['order_id'])->first()->toArray();

            
            if(!empty($data['courier_name']) && !empty($data['tracking_number'])){
                //send order status update email
                $email = $deliveryDetails['email'];
                $messageData = [
                    'email' => $email,
                    'name' => $deliveryDetails['name'],
                    'order_id' => $data['order_id'],
                    'orderDetails' => $orderDetails,
                    'order_status' => $data['order_status'],
                    'courier_name' => $data['courier_name'],
                    'tracking_number' => $data['tracking_number']
                ];
                Mail::send('emails.order_status',$messageData,function($message)use($email){
                    $message->to($email)->subject('Order Status Updated - P-Store Mart');
                });

            } else {
                //send order status update email
                $email = $deliveryDetails['email'];
                $messageData = [
                    'email' => $email,
                    'name' => $deliveryDetails['name'],
                    'order_id' => $data['order_id'],
                    'orderDetails' => $orderDetails,
                    'order_status' => $data['order_status']
                ];
                Mail::send('emails.order_status',$messageData,function($message)use($email){
                    $message->to($email)->subject('Order Status Updated - P-Store Mart');
                });
            }

            Notification::insert([
                'module' => 'order',
                'module_id' => $data['order_id'],
                'user_id' => $orderDetails['user_id'],
                'sender' => 'vendor',
                'receiver' => 'customer',
                'message' => "Your order status is {$data['order_status']}. Please check order ID: " . $data['order_id']
            ]);

            $message = "Order Status has been updated successfuly!";
            return redirect()->back()->with('success_message',$message);
        }
    }

    public function viewOrderInvoice($order_id){
        //fetch order details
        $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();
        $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();

        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));
    }

    public function trackOrder($id){
        // if($request->isMethod)
    }
}
