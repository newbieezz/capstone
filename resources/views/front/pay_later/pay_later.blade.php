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
            <div class="row">
                {{-- <h2>Credit Limit:  {{$credit_limit['current_credit_limit']}} <h6>&nbsp;&nbsp; </h6></h2> &nbsp; --}}
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
                        <td> @if (empty($pay_later['due_date']))
                                Order Not Yet Accepted
                            @else
                                {{ date('Y-m-d', strtotime($pay_later['due_date'])) }}
                            @endif
                        </td>
                        <td>₱ {{ $pay_later['amount'] }}</td>
                        <td>
                        <a href="{{url('payment/'.$pay_later['id'])}}"><button class="button button-outline-secondary w-100">Pay Now</button></a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div> <br><br>
            <div class="row">
                <h2>My Transactions <h6>&nbsp;&nbsp; </h6></h2> &nbsp;
                <table class="table table-striped table-borderless">
                    <tr>
                        <th>Amount</th>
                        <th>Date Paid</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach ($paids as $paid)
                        <tr>
                            <td> ₱ {{ $paid['amount'] }} </td>
                            <td> {{ date('Y-m-d', strtotime($paid['updated_at'])) }} </td>
                        </tr>
                    @endforeach
                </table>
            </div> 
        </div>
    </div>  
@endsection