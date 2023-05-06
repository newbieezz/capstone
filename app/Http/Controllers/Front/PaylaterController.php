<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Paylater;
use App\Models\CreditLimit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaylaterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
