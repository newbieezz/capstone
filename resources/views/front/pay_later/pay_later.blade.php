<?php 
    use App\Models\PayLaterApplication;
?>
@extends('front.layout.layout')
@section('content')
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Pay Later</h2>
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
    <div class="page-cart u-s-p-t-80">
        <div class="container">
            @if ($status['id'] != 0  && $status['appstatus'] =='Pending' )
                <div class="row" style="center">
                    <h1>Good Day!   </h1> <br> <br> <br>
                    <h2>Your Application is Pending / Under Review. We will inform you the updates by email.</h2>
                </div>
            @elseif ($status['id'] != 0  && $status['appstatus'] =='Approved' )
                {{-- Approved Users Pay Later Information Details --}}
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
            @else
                <div class="row">
                    {{-- <h2>Credit Limit:  {{$credit_limit['current_credit_limit']}} <h6>&nbsp;&nbsp; </h6></h2> &nbsp; --}}
                    <h2>Want to use and avail PayLater payment method?</h2> &nbsp;  <br> <br>
                        <button type="button" class="btn btn-primary w-right" ><a href="{{ url('pay-later') }}" style="color:white;">Click to Apply</a></button>
                    <div style="row">
                    </div>
                </div>
                {{--End of Approved User's Payment Info--}}
            @endif  
        </div>
    </div> <br><br><br><br><br><br><br><br><br>
@endsection