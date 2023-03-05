<?php use App\Models\Product; 
use App\Models\Order; ?>
@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
      @if(Session::has('success_message'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success: </strong> {{ Session::get('success_message')}}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Order #{{ $orderDetails['id'] }}Details</h3>
                        <h6 class="font-weight-normal mb-0"><a href="{{ url('admin/orders') }}">Back to Orders</a></h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"> Order Details </h4>
                  <div class="form-group" style="height:15px;">
                    <label style="font-weight:600;">Order ID : </label>
                    <label> #{{ $orderDetails['id'] }}</label>
                  </div>
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:600;">Order Date : </label>
                      <label>{{ date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])) }}</label>
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
                    @if(Auth::guard('admin')->user()->type!="vendor")
                      <form action="{{ url('admin/update-order-status') }}" method="post"> @csrf
                        <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                        <select name="order_status" id="order_status" required="">
                          <option value="" selected="">Select</option>
                          @foreach($orderStatus as $status)
                            <option value="{{ $status['name'] }}" 
                              @if(!empty($orderDetails['order_status'] && $orderDetails['order_status'] == $status['name'])) selected="" @endif>
                                {{ $status['name'] }}</option>
                          @endforeach
                        </select>
                        <input type="text" name="courier_name" id="courier_name" placeholder="Courier Name">
                        <input type="text" name="tracking_number" id="tracking_number" placeholder="Tracking Number">
                        <button type="submit">Update</button>
                      </form>
                      <br> @foreach($orderLog as $log)
                            <strong>{{ $log['order_status'] }}</strong> 
                            @if($log['order_status'] == "Delivering")
                              @if(!empty($orderDetails['courier_name']))
                                <br><span>Courier Name: {{ $orderDetails['courier_name'] }}</span>
                              @endif
                              @if(!empty($orderDetails['tracking_number']))
                                <br><span>Tracking Number: {{ $orderDetails['tracking_number'] }}</span>
                              @endif
                            @endif
                              <br>{{ date('Y-m-d h:i:s', strtotime($order['created_at'])) }} <br>
                            <hr>
                           @endforeach
                    @else
                      This feature is restricted!
                    @endif
                  </div>
                </div>
              </div> 
              <div class="col-md-12 grid-margin stretch-card">
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
                            <th>Item Status</th>
                        </tr>
                        @foreach ($orderDetails['orders_products'] as $product)
                            <tr>
                                <td>
                                    @php $getProductImage = Product::getProductImages($product['product_id']) @endphp
                                    <a target="blank" href="{{ url('product/'.$product['product_id']) }}">
                                        <img style="width:60px" src="{{ asset('/front/images/product_images/small/'.$getProductImage) }}" >
                                    </a>
                                </td>
                                <td>{{ $product['product_code'] }}</td>
                                <td>{{ $product['product_name'] }}</td>
                                <td>{{ $product['product_size'] }}</td>
                                <td>{{ $product['product_qty'] }}</td>
                                <td>
                                  <form action="{{ url('admin/update-order-item-status') }}" method="post"> @csrf
                                    <input type="hidden" name="order_item_id" value="{{ $product['id'] }}">
                                    <select name="order_item_status" id="order_item_status"  required="">
                                      <option value="">Select</option>
                                      @foreach($orderItemStatus as $status)
                                        <option value="{{ $status['name'] }}" 
                                          @if(!empty($product['item_status'] && $product['item_status'] == $status['name'])) selected="" @endif>
                                            {{ $status['name'] }}</option>
                                      @endforeach
                                    </select>
                                    <input style="width:110px;" type="text" name="item_courier_name" id="item_courier_name"  placeholder="Courier Name"
                                        @if(!empty($product['courier_name'])) value="{{ $product['courier_name'] }}" @endif>
                                    <input style="width:110px;" type="text" name="item_tracking_number" id="item_tracking_number" placeholder="Tracking Number"
                                        @if(!empty($product['tracking_number'])) value="{{ $product['tracking_number'] }}" @endif>
                                    <button type="submit">Update</button>
                                  </form>
                                </td>
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