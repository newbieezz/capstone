<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Paylater;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class PayLaterController extends Controller
{
    public function paylaters(){
        Session::put('page','bpaylater');
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

        // if($adminType=="vendor"){
        //     $orders = Order::with(['orders_products'=>function($query)use($vendor_id){
        //         $query->where('vendor_id',$vendor_id);
        //     }])->orderBy('id','Desc')->get()->toArray(); //subquery to see only those products that belongs to a particular vendor by its vendor_id
        //     $paylater = Paylater::with('user');
        // } else {
        //     $orders = Order::with('orders_products')->orderBy('id','Desc')->get()->toArray(); //for admin query
        //     // $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        // }
        $userDetails = User::get()->first()->toArray();
        // dd($userDetails);
        try {
            $pay_laters = Paylater::with('orders')
                ->where('user_id', $userDetails['id'])
                ->where('due_date', '!=', null)
                ->where('is_paid', 0)
                ->get();
            // $credit_limit = CreditLimit::where('user_id', Auth::user()->id)->first();
            dd($pay_laters);
            return view('admin.paylater.paylaters')->with(compact('pay_laters'));
        } catch (\Throwable $th) {
            throw $th;
        }

        return view('admin.paylater.paylaters')->with(compact('orders'));
    }

}
