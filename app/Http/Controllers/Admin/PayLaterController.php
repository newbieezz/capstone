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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class PayLaterController extends Controller
{
    public function paylaters(){
        Session::put('page','bpaylater');

            $credit_limit = CreditLimit::getCreditLimit();
            // dd($credit_limit);

            $credit_limits = User::with('credit_limits')->where(Auth::user()->id,$credit_limit['user_id'])->first()->toArray();

        return view('admin.paylater.paylaters')->with(compact('credit_limits','credit_limit'));;
    }

}
