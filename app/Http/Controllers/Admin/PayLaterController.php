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

    }

}
