<?php use App\Models\Product; 
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
                        <a href="javascript:;">Payment</a>
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
                    <h3>YOUR PAYMENT HAS BEEN CONFIRMED AND SUCCESSFUL!</h3>
                    <p>Thank you for your payment.</p><br><br><br><br>
                <a href="{{url('user/pay-later')}}"> <button type="submit" class="btn btn-primary mr-2">Back</button> </a>
                </div>
                                
            </div>
        </div>
    </div> <br><br><br>
@endsection

{{-- End Session --}}
<?php
    Session::forget('grand_total');
    Session::forget('order_id');
?>