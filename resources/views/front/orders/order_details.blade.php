<?php use App\Models\Product; 
use App\Models\Order; 
?>
@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Order #{{ $orderDetails['id'] }} Details</h2>
                <ul class="bread-crumb">    
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="{{ url('user/orders') }}">Orders</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <div class="page-cart u-s-p-t-80">
        <div class="container">
            <div class="row">               
                <form action="{{ url('user/order-received') }}" method="post"> @csrf
                    <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}"/>
                    <table class="table table-striped table-borderless">
                        <tr  class="table-success"><td colspan="2"><strong>Order Details</strong></td></tr>
                        <tr><td>Order Date</td><td>{{ date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])) }}</td></tr>
                        <tr><td>Order Status</td><td>{{ $orderDetails['order_status'] }}</td></tr>
                        <tr><td>Order Total</td><td>₱ {{ $orderDetails['grand_total'] }}</td></tr>
                        <tr><td>Payment Method</td><td>{{ $orderDetails['payment_method'] }}</td></tr>
                    </table>
                    <table class="table table-striped table-borderless">
                        <tr  class="table-success">
                            <th>Product Image</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Product Size</th>
                            <th>Product Qty</th>
                        </tr>
                        @foreach ($orderDetails['orders_products'] as $product)
                            <tr>
                                <td>
                                    @php $getProductImage = Product::getProductImages($product['product_id']) @endphp
                                    <a target="blank" href="{{ url('product/'.$product['product_id']) }}">
                                        <img style="width:80px" src="{{ asset('/front/images/product_images/small/'.$getProductImage) }}" >
                                    </a>
                                </td>
                                <td>{{ $product['product_code'] }}</td>
                                <td>{{ $product['product_name'] }}</td>
                                <td>{{ $product['product_size'] }}</td>
                                <td>{{ $product['product_qty'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <table class="table table-striped table-borderless">
                        <tr class="table-success"><td colspan="2"><strong>Delivery Address</strong></td></tr>
                        <tr><td>Name</td><td>{{ $orderDetails['name'] }}</td></tr>
                        <tr><td>Address</td><td>{{ $orderDetails['address'] }}</td></tr>
                        <tr><td>Mobile</td><td>{{ $orderDetails['mobile'] }}</td></tr>
                        <tr><td>Email</td><td>{{ $orderDetails['email'] }}</td></tr>
                    </table>
                    <div class="col border-end d-flex justify-content-center align-items-end">
                        <button class="btn btn-primary" type="submit">
                        Order Received 
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection