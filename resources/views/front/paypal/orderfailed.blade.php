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
                        <a href="javascript:;">Payment Failed</a>
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
                    <h3>YOUR PAYMENT HAS FAILED!</h3>
                    <p>Please try again after some time and feel free to contact us if there is any inquiry.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- End Session --}}
<?php
    Session::forget('grand_total');
    Session::forget('order_id');
?>