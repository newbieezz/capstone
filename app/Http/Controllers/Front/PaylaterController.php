<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Paylater;
use App\Models\CreditLimit;
use App\Models\PayLaterApplication;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
        
        // $getUserBNPLstatus = User::getUserBNPLstatus('bnpl_status');

        //  if( $getUserBNPLstatus=="NotActivated"){

            
        //     return view('front.pay_later.pay_later')->with('getUserBNPLstatus');

        //  }
        // else if($getUserBNPLstatus=="Approved"){
        
        $pay_laters = Paylater::with('orders')
            ->where('user_id', Auth::user()->id)
            ->where('due_date', '!=', null)
            ->where('is_paid', 0)
            ->get()->toArray();
        //         $credit_limit = CreditLimit::where('user_id', Auth::user()->id)->first();
        return view('front.pay_later.pay_later')->with(compact('pay_laters'));
        //  return view('front.pay_later.pay_later');//->with(compact('status','pay_laters', 'credit_limit','getUserBNPLstatus'));

    }

    public function application(){
        return view('front.pay_later.pay_later_application');    
    }

    //user pay now button 
    public function userpayment($id=null){
        if(empty($id)){
            echo 'BAAKKKAAAA!!';

            return view('front.pay_later.payment');
        } else {
            $pay_laters = Paylater::where('id',$id)->first();
            // dd($pay_laters);
            return view('front.pay_later.payment')->with(compact('pay_laters'));
        }
    }
    public function userPayNow(Request $request){
        $paylater_id=Session::get('id');
        if($request->isMethod('post')){
            $data = $request->all();
            dd($data);
        }
        $pay_laters = Paylater::with('orders')
                    ->where('user_id', Auth::user()->id)
                    ->get()->toArray();
        // dd($pay_laters['id']);
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
