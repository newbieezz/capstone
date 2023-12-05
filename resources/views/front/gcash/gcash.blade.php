<?php use App\Models\Product; 
      use App\Models\ProductsFilter; 
?>
@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Payment</h2>
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
                    <form action="{{url('/gcashpay')}}" method="post"> @csrf
                        <input type="hidden" name="grand_total" value="{{ Session::get('grand_total') }}"> <br> <br>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"> <br> <br>
                        <div class="table-responsive pt-3"> 
                                <h5><i>Note: Send GCash screenshot for Proof of Payment.</i></h5> <br><br>
                                <h4>Vendor Gcash number: <b> {{$vendor['account_number']}}</b></h4>
                                <div class="form-group">
                                    <label for="payment_proof">Proof of Payment</label>
                                    <input type="file" class="form-control" id="payment_proof" name="payment_proof" required="" style="width: 30%">
                                </div>
                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                         </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection