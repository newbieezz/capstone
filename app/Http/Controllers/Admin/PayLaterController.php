<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreditLimit;
use App\Models\Installment;
use App\Models\Order;
use App\Models\Paylater;
use App\Models\PaylaterApplication;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetails;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

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

    public function pending () {
        Session::put('page','pending');
        $pendings = PayLaterApplication::where('appstatus', 'Pending')
        ->where('vendor_id', Auth::guard('admin')->user()->id)
        ->with(['users', 'vendor', 'garantor'])->first()
        ->paginate(6);
        dd($pendings);
        return view('admin.paylater_applications.pending', compact('pendings','users'));
    }

    public function approved () {
        Session::put('page','approved');
        $approved = PayLaterApplication::where('appstatus', 'Approved')
        ->where('vendor_id', Auth::guard('admin')->user()->id)
        ->with(['users', 'vendor', 'garantor'])
        ->paginate(6);
        // dd($approved );

        return view('admin.paylater_applications.approved', compact('approved'));
    }
    
    public function getById ($id) {
        Session::put('page', 'details');
        $details = PayLaterApplication::get()->toArray();
        $userDetails = User::get()->toArray();

        // dd($details);

        return view('admin.paylater_applications.details', compact('details','userDetails','id'));
    }

    public function approveById ($id) {
        $details = PayLaterApplication::where('appstatus', 'Pending')
        ->where('vendor_id', Auth::guard('admin')->user()->id)
        ->where('id', $id)
        ->update(['appstatus' => 'Approved']);
        // Notification::insert([
        //     'module' => 'paylater',
        //     'module_id' => $details['user_id'],
        //     'user_id' => $details['vendor_id'],
        //     'sender' => 'vendor',
        //     'receiver' => 'customer',
        //     'message' => ' Your application has been Approved.'
        // ]);

        return response()->json(['message' => 'Success']);

    }

    public function declineById ($id) {
        $details = PayLaterApplication::where('appstatus', 'Pending')
        ->where('vendor_id', Auth::guard('admin')->user()->id)
        ->where('id', $id)
        ->update(['appstatus' => 'Rejected']);
        
        return response()->json(['message' => 'Success']);

    }
}
