<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Paylater;
use App\Models\CreditLimit;
use App\Models\GcashPaylater;
use App\Models\PayLaterApplication;
use App\Models\User;
use App\Models\VendorsBusinessDetails;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Notification;
use App\Models\Vendor;
use App\Models\VendorsBankDetails;
use Illuminate\Support\Facades\Session;

class PaylaterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pay_laters = Paylater::with('orders')
            ->where('user_id', Auth::user()->id)
            ->where('is_paid', 0)
            ->get()->toArray();
            // dd($pay_laters);
        //         $credit_limit = CreditLimit::where('user_id', Auth::user()->id)->first();
        $paids = Paylater::with('orders')
            ->where('user_id', Auth::user()->id)
            ->where('is_paid', 1)
            ->get()->toArray();
        return view('front.pay_later.pay_later')->with(compact('pay_laters','paids'));

    }

    public function application(){
        return view('front.pay_later.pay_later_application');    
    }

    //user pay now button 
    public function userpayment($id){
       
            $userpay_laters = Paylater::where('id',$id)->first();
            $pay_laters = Paylater::with('orders')
                    ->where('id', $id)
                    ->first();
            $vendor = VendorsBankDetails::where('vendor_id',$pay_laters['orders']['vendor_id'])->first();
            // dd($vendor['account_number']);
            return view('front.pay_later.gcashpaylater')->with(compact('id','vendor','pay_laters','userpay_laters'));
        
    }
    public function gcashpaylater(Request $request){
        Session::get('id');
        if($request->isMethod('post')){
            $data = $request->all();
            
         // Upload Image/Photo
        if($image = $request->file('payment_proof')){
            $path = 'front/images/gcash/';
            $name = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($path, $name);
            $data['payment_proof'] = "$name";
        } 

                $gcash = new GcashPaylater();
                $gcash->order_id = $data['order_id'];
                $gcash->user_id = $data['user_id'];
                $gcash->vendor_id = $data['vendor_id'];
                $gcash->paylater_id = $data['paylater_id'];
                $gcash->payer_id = mt_rand(100000,999999);
                $gcash->amount = $data['amount'];
                $gcash->payment_status = 'Success';
                $gcash->payment_proof = $data['payment_proof'];
                // dd($gcash);
                $gcash->save();

                
                
                Notification::insert([
                    'module' => 'paylaterpayment',
                    'module_id' => $data['order_id'],
                    'user_id' => $data['user_id'],
                    'sender' => 'customer',
                    'receiver' => 'vendor',
                    'message' => Auth::user()->name . ' has paid an installment.' 
                ]);

                Paylater::where('id',$data['paylater_id'])->update(['is_paid'=>1]);

        return view('front.pay_later.paymentsuccess');
        
    }
    }

    //credit limit, paylater informations w/ pay now button
    public function credits()
    {
        try {
            $pay_laters = Paylater::with('orders')
                ->where('user_id', Auth::user()->id)
                ->where('due_date', '!=', null)
                ->where('is_paid', 0)
                ->get();
            $credit_limit = CreditLimit::where('user_id', Auth::user()->id)->first();
            return view('front.pay_later.pay_later')->with(compact('pay_laters', 'credit_limit'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paylater  $paylater
     * @return \Illuminate\Http\Response
     */
    public function show(Paylater $paylater)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paylater  $paylater
     * @return \Illuminate\Http\Response
     */
    public function edit(Paylater $paylater)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paylater  $paylater
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paylater $paylater)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paylater  $paylater
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paylater $paylater)
    {
        //
    }
}
