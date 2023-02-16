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
                        <a href="javascript:;">Order Placed</a>
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
                    <h3>YOUR ORDER HAS BEEN PLACED SUCCESSFULLY!</h3>
                    <p>Your order number is {{ Session::get('order_id') }}  and Grand Total is Php {{ Session::get('grand_total') }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart-Page /- -->
@endsection