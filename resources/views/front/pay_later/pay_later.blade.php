<?php 
    use App\Models\Order;
?>
@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>My Orders</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="javascript:;">Pay Later</a>
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
                <h2>Credit Limit: {{$credit_limit['current_credit_limit']}}</h2>
            </div>
            <div class="row">
                <table class="table table-striped table-borderless">
                    <tr>
                        <th>Order ID</th>
                        <th>Due Date</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                    @foreach ($pay_laters as $pay_later)
                    <tr>
                        <td><a href="{{ url('user/orders/'.$pay_later['order_id']) }}">{{ $pay_later['order_id'] }}</a></td>
                        <td>{{ date('Y-m-d', strtotime($pay_later['due_date'])) }}</td>
                        <td>₱ {{ $pay_later['amount'] }}</td>
                        <td>
                          <button class="button button-outline-secondary w-100">Pay Now</button>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div> <br><br><br><br><br><br><br><br><br>
    <!-- Cart-Page /- -->
@endsection