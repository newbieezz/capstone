<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItemStatus;
use App\Models\OrdersProduct;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $orderItemStatus = OrderItemStatus::where('status',1)->get()->toArray();

        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails','orderStatus','orderItemStatus'));
    }

    public function updateOrderStatus(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //update order status
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            $message = "Order Status has been updated successfuly!";
            return redirect()->back()->with('success_message',$message);
        }
    }
    
    public function updateOrderItemStatus(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //update status
            OrdersProduct::where('id',$data['order_item_id'])->update(['item_status'=>$data['order_item_status']]);
            $message = "Item Status has been updated successfuly!";
            return redirect()->back()->with('success_message',$message);
        }
    }
}
