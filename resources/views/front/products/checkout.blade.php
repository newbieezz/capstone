<?php use App\Models\Product; 
      use App\Models\ProductsFilter; 
      use App\Models\PaylaterApplication;
?>
@extends('front.layout.layout')
@section('content')

    <!-- Page Introduction Wrapper /- -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Cart</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="javascript:;">Checkout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Checkout-Page -->
    <div class="page-checkout u-s-p-t-80">
        <div class="container">
                @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error: </strong> {{ Session::get('error_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <!-- Second Accordion /- -->
                            <div class="row">
                                <!-- Delivery Address-Details -->
                                <div class="col-lg-6" id="deliveryAddresses"> <!-- use the id to refresh the addresses -->
                                    @include('front.products.delivery_addresses')
                                </div>
                             <!-- Checkout - -->
                        <div class="col-lg-6">
                            <form name="checkoutForm" id="checkoutForm" action="{{ url('checkout/') }}" method="post"> @csrf
                                <!-- Delivery Address-Details /- -->
                                {{--check if the array comes --}}
                                    @if(count($deliveryAddresses)>0) 
                                      <h4 class="section-h4">Delivery Details</h4>
                                        @foreach($deliveryAddresses as $address)
                                            <div class="control-group" style="float:left; margin-right:8px;"><input type="radio" name="address_id" id="address{{ $address['id'] }}" value="{{ $address['id'] }}" /></div>
                                            <div>
                                                <label class="control-label">
                                                    {{ $address['name'] }} , {{ $address['address'] }} , ( {{ $address['mobile'] }} )
                                                </label>
                                                <a style="float:right; margin-left:10px" href="javascript:;" data-addressid="{{ $address['id'] }}"
                                                    class="removeAddress">Remove</a>
                                                <a style="float:right;" href="javascript:;" data-addressid="{{ $address['id'] }}"
                                                    class="editAddress">Edit</a>
                                            </div>
                                            <br />
                                        @endforeach <br />
                                     @endif
                                    <h4 class="section-h4">Your Order</h4> <br><br>
                                    <div class="order-table" id="udcartItems" >
                                        <table class="u-s-m-b-13">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $total_price = 0 @endphp
                                                @foreach($selectedVendorItems as $item)
                                                    <?php 
                                                        $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                                                    ?> 
                                                        <tr>
                                                            <td>
                                                                <a href="{{ url('product/'.$item['product_id']) }}"> 
                                                                <img width="30" src="{{ asset('front/images/product_images/small/'.$item['product']['product_image']) }}" alt="Product">
                                                                <h6 class="order-h6">{{ $item['product']['product_name'] }}</h6>
                                                                <span class="order-span-quantity">  {{ $item['size'] }}  (x{{ $item['quantity'] }})</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="order-h6">₱ {{ $getDiscountAttributePrice['final_price'] * $item['quantity']}}</h6>
                                                            </td>
                                                        </tr> 
                                                    {{-- Calculate the subtotal for each produuct by its desired quantity --}}
                                                    @php $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp
                                                @endforeach
                                                <tr>
                                                    <td>
                                                        <h3 class="order-h3">Transaction Fee</h3>
                                                    </td>
                                                    <td>
                                                        <h3 class="order-h3">₱ {{ $total_price }}</h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="order-h6">Delivery Fee</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="order-h6">To be followed . . .</h6>
                                                    </td>
                                                </tr>
                                                {{-- <tr>  T  A  X
                                                    <td>
                                                        <h3 class="order-h3">Tax</h3>
                                                    </td>
                                                    <td>
                                                        <h3 class="order-h3">₱ 0.00</h3>
                                                    </td>
                                                </tr> --}}
                                                <tr>
                                                    <td>
                                                        <h3 class="order-h3">Total</h3>
                                                    </td>
                                                    <td>
                                                        <h3 class="order-h3">₱ {{ $total_price }}</h3>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="u-s-m-b-13">
                                            <input type="radio" class="radio-box" name="payment_gateway" id="cash-on-delivery" value="COD">
                                            <label class="label-text" for="cash-on-delivery">Cash on Delivery</label>
                                        </div>
                                        <div class="u-s-m-b-13">
                                            <input type="radio" class="radio-box" name="payment_gateway" id="credit-card-stripe" value="Stripe">
                                            <label class="label-text" for="credit-card-stripe">Credit Card (Stripe)</label>
                                        </div>
                                        <div class="u-s-m-b-13">
                                            <input type="radio" class="radio-box" name="payment_gateway" id="paypal" value="Paypal">
                                            <label class="label-text" for="paypal">Paypal</label>
                                        </div>
                                        {{-- FOR BUY NOW PAY LATER --}}
                                        @if($status['appstatus'] ='Approved')
                                            <div class="u-s-m-b-13">
                                                <label class="label-text" for="paylater">Buy Now, Pay Later</label>
                                                
                                                {{-- INSTALLMENTS --}}
                                            {{-- @foreach($installments as $installment)
                                                <div style="margin-left:25px" class="u-s-m-b-13">
                                                    <input type="radio" class="radio-box" name="{{$installment['installment_id']}}" id="{{$installment['installment_id']}}" value="{{$installment['installment_id']}}">
                                                    <label class="label-text" for="{{$installment['installment_id']}}">{{ $installment['description'] }}</label>
                                                    <br>
                                                    <span>For {{ round(($total_price + ($total_price * ($installment['interest_rate']/100))) / $installment['number_of_months'] , 2) }} Php/Month</span>
                                                </div>
                                                @endforeach --}}
                                            </div>
                                            <div class="u-s-m-b-13">
                                                @foreach($installments as $key => $installment)
                                                <div style="margin-left:25px" class="u-s-m-b-13">
                                                    <input type="radio" class="radio-box" name="payment_gateway" id="paylater{{$key}}" value="paylater-{{ $installment['id'] }}">
                                                    <label class="label-text" for="paylater{{$key}}">{{ $installment['description'] }} For {{ round(($total_price + ($total_price * ($installment['interest_rate']/100))) / $installment['number_of_weeks'] , 2) }} Php/week</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="u-s-m-b-13">
                                            <input type="checkbox" required="" class="check-box" id="accept"  name="accept" value="Yes" title="Please agree to T&C" >
                                            <label class="label-text no-color" for="accept">I’ve read and accept the
                                                <a href="terms-and-conditions.html" class="u-c-brand">terms & conditions</a>
                                            </label>
                                        </div>
                                        <button type="submit" class="button button-outline-secondary">Place Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout-Page /- -->

@endsection