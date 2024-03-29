<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\GcashPayment;
use App\Models\Order;
use App\Models\OrderItemStatus;
use App\Models\OrdersLog;
use App\Models\OrdersProduct;
use App\Models\OrderStatus;
use App\Models\User;
use App\Models\Paylater;
use App\Models\Notification;
use App\Models\Rider;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use \Carbon\Carbon;
use App\Models\WalletTransaction;
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
            // dd($orderDetails);
            $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();

            if($orderDetails['payment_method']=="Gcash"){
                //fetch the user details
                $gcashpay = GcashPayment::where('user_id',$orderDetails['user_id'])->first()->toArray();
                //    dd($gcashpay);
                if(!empty($rider)){
                    $rider = Rider::where('order_id',$orderDetails['id'])->first()->toArray();
                } 
            }
            // dd($rider);
        } else {
            $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        }
        
        $rider = Rider::where('order_id',$orderDetails['id'])->first();
        $orderStatus = OrderStatus::where('status',1)->get()->toArray();
        $orderLog = OrdersLog::with('orders_products')->where('order_id',$id)->orderBy('id','Desc')->get()->toArray();
        return view('admin.orders.order_details')->with(compact('orderDetails','rider','userDetails','orderStatus','orderLog'));
    }

    public function updateOrderStatus(Request $request){
        
        if($request->isMethod('post')){
            $data = $request->all();
            //update order status
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);

            //update order log
            $log = new OrdersLog();
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();

            //get delivery address
            $deliveryDetails = Order::select('mobile','email','name')->where('id',$data['order_id'])->first()->toArray();
            $orderDetails = Order::with('orders_products')->where('id',$data['order_id'])->first()->toArray();
            
                // dd($new_balance);

                

            if ($data['order_status'] == 'Accept') {
                $pay_later = PayLater::where('order_id', $data['order_id'])->get();
                foreach ($pay_later as $key => $value) {
                    PayLater::find($value['id'])->update([
                        'due_date' => Carbon::now()->addWeeks($key + 1)->format('Y-m-d')
                    ]);
                }
                //upate vendors table with transfer fee
                //insert wallet deduction 
                $transaction_fee = $orderDetails['grand_total'] * 0.05;
                $walletTransactions = WalletTransaction::get()->first();
                $vendor = Vendor::where('id',$walletTransactions['admin_id'])->get()->first()->toArray();
                $new_balance = $vendor['wallet_balance'] - $transaction_fee;
                Vendor::where('id',$walletTransactions['admin_id'])->update(['wallet_balance'=>$new_balance]);
                $admin_id = 0;
                $admin = Admin::where('id',$admin_id)->get()->first()->toArray();
                // dd($admin);
                $admin_fee = $admin['wallet_balance'] + $transaction_fee;
                Admin::where('id',$admin_id)->update(['wallet_balance'=>$admin_fee]);
            }

            //get delivery address
            $deliveryDetails = Order::select('mobile','email','name')->where('id',$data['order_id'])->first()->toArray();
            $orderDetails = Order::with('orders_products')->where('id',$data['order_id'])->first()->toArray();

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

    public function updateRiderDetails(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //save or update
            $rider = new Rider;
            $rider->order_id = $data['order_id'];
            $rider->name = $data['ridername'];
            $rider->plate_num = $data['platenum'];
            $rider->mobile = $data['activemobile'];
            $rider->delivery_fee = $data['deliveryfee'];
            // dd($rider);
            $rider->save();

            $orderDetails = Order::with('orders_products')->where('id',$data['order_id'])->first()->toArray();
            

            Notification::insert([
                'module' => 'order',
                'module_id' => $data['order_id'],
                'user_id' => $orderDetails['user_id'],
                'sender' => 'vendor',
                'receiver' => 'customer',
                'message' => "Your delivery rider is {$data['ridername']}. Please check order ID: " . $data['order_id']
            ]);

            $message = "Delivery Details has been updated successfuly!";
            return redirect()->back()->with('success_message',$message);
        }
    }

    public function viewOrderInvoice($order_id){
        //fetch order details
        $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();
        $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();

        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));
    }
 
}
