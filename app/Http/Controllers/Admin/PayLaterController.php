<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreditLimit;
use App\Models\Installment;
use App\Models\Order;
use App\Models\Paylater;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetails;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class PayLaterController extends Controller
{
    public function paylaters(Request $request){
        Session::put('page','bpaylater');

    }

    public function setInterest(Request $request){
        Session::put('page','bpaylater');

        $vendor = Vendor::where('id',Auth::guard('admin')->user()->id)->first()->toArray();
        $shopDetails = VendorsBusinessDetails::where('vendor_id',Auth::guard('admin')->user()->id)->first()->toArray();
            // dd($shopDetails);

            $installments = Installment::get()->toArray();
            if($request->isMethod('post')){
                $data = $request->all();
                // dd($data);
                VendorsBusinessDetails::where('vendor_id',$vendor['id'])->update(['installment_weeks'=>$data['number_of_weeks'],'interest'=>$data['interest_rate']]);

                    return redirect()->back()->with('success_message','Installemts Interest set successfully!');
            }
        return view('admin.paylater.set_interest')->with(compact('installments','vendor','shopDetails'));
        
    }

}
