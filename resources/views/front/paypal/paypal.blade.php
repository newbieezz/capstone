<?php use App\Models\Product; 
      use App\Models\ProductsFilter; 
?>
@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Order Placed</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="javascript:;">Proceed to Payment</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Cart-Page -->
    <div class="page-cart u-s-p-t-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" align="center">
                    <h3>PLEASE MAKE PAYMENT FOR YOUR ORDER!</h3>
                    <form action="{{ route('payment') }}" method="post"> @csrf
                        {{-- round of the amount hten convert to usd  --}}
                        <input type="hidden" name="amount" value="{{ round(Session::get('grand_total')/55,2) }}"> <br> <br>
                        <!-- PayPal Logo -->
                        <input type="image" src="https://www.paypalobjects.com/digitalassets/c/website/marketing/apac/C2/logos-buttons/optimize/44_Grey_PayPal_Pill_Button.png" alt="PayPal">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection