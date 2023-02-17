<?php use App\Models\Product; ?>
@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <d class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Order #{{ $orderDetails['id'] }}Details</h3>
                        <h6 class="font-weight-normal mb-0"><a href="{{ url('admin/orders') }}">Back to Orders</a></h6>
                    </div>
                </div>
            </div>
        </d iv>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"> Order Details </h4>
                  <div class="form-group" style="height:15px;">
                    <label style="font-weight:600;">Order ID : </label>
                    <label> #{{ $orderDetails['id'] }}</label>
                  </div>
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:600;">Order Date : </label>
                      <label>{{ date('Y-m-d h:i:s', strtotime($order['created_at'])) }}</label>
                    </div>
                  <div class="form-group" style="height:15px;">
                    <label style="font-weight:600;">Order Status : </label>
                    <label>{{ $orderDetails['order_status'] }}</label>
                  </div>
                  <div class="form-group" style="height:15px;">
                    <label style="font-weight:600;">Delivery Fee : </label>
                    <label>₱ {{ $orderDetails['delivery_fee'] }}</label>
                  </div>
                  <div class="form-group" style="height:15px;">
                    <label style="font-weight:600;">Total Price : </label>
                    <label>₱ {{ $orderDetails['grand_total'] }}</label>
                  </div>
                  <div class="form-group" style="height:15px;">
                    <label style="font-weight:600;">Payment Method : </label>
                    <label>{{ $orderDetails['payment_method'] }}</label>
                  </div>
                  <div class="form-group" style="height:15px;">
                    <label style="font-weight:600;">Payment Gateway : </label>
                    <label>{{ $orderDetails['payment_gateway'] }}</label>
                  </div>
                </div>
              </div>
            </div> 
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> Customer Details</h4>
                    <div class="form-group" style="height:15px;">
                        <label style="font-weight:600;">Name : </label>
                        <label>{{ $userDetails['name'] }}</label>
                    </div>
                    @if(!empty($userDetails['address']))
                    <div class="form-group" style="height:15px;">
                        <label style="font-weight:600;">Address : </label>
                        <label>{{ $userDetails['address'] }}</label>
                    </div> @endif
                    <div class="form-group" style="height:15px;">
                        <label style="font-weight:600;">Mobile : </label>
                        <label>{{ $userDetails['mobile'] }}</label>
                    </div>
                    <div class="form-group" style="height:15px;">
                        <label style="font-weight:600;">Email : </label>
                        <label>{{ $userDetails['email'] }}</label>
                    </div>
                  </div>
                </div>
              </div>       
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> Delivery Addresse </h4>
                    <div class="form-group" style="height:15px;">
                        <label style="font-weight:600;">Name : </label>
                        <label>{{ $orderDetails['name'] }}</label>
                    </div>
                    <div class="form-group" style="height:15px;">
                        <label style="font-weight:600;">Address : </label>
                        <label>{{ $orderDetails['address'] }}</label>
                    </div> 
                    <div class="form-group" style="height:15px;">
                        <label style="font-weight:600;">Mobile : </label>
                        <label>{{ $orderDetails['mobile'] }}</label>
                    </div>
                  </div>
                </div>
              </div> 
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> Update Order Status </h4>
                  </div>
                </div>
              </div> 
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> Ordered Products </h4>
                    <table class="table table-striped table-borderless">
                        <tr  class="table-success">
                            <th>Product Image</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Product Size</th>
                            <th>Product Qty</th>
                        </tr>
                        @foreach ($orderDetails['order_products'] as $product)
                            <tr>
                                <td>
                                    @php $getProductImage = Product::getProductImage($product['product_id']) @endphp
                                    <a target="blank" href="{{ url('product/'.$product['product_id']) }}">
                                        <img src="{{ asset('/front/images/product_images/small/'.$getProductImage) }}" >
                                    </a>
                                </td>
                                <td>{{ $product['product_code'] }}</td>
                                <td>{{ $product['product_name'] }}</td>
                                <td>{{ $product['product_size'] }}</td>
                                <td>{{ $product['product_qty'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                  </div>
                </div>
              </div> 
        </div> 
    </div> 
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>

@endsection