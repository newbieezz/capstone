<?php use App\Models\Product; 
      use App\Models\ProductsFilter; 
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
        <form name="checkoutForm" id="checkoutForm" action="{{ url('/checkout') }}" method="post"> @csrf
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <!-- First-Accordion -->
                    {{-- <div>
                        <div class="message-open u-s-m-b-24">
                            Returning customer?
                            <strong>
                                <a class="u-c-brand" data-toggle="collapse" href="#showlogin">Click here to login
                                </a>
                            </strong>
                        </div>
                        <div class="collapse u-s-m-b-24" id="showlogin">
                            <h6 class="collapse-h6">Welcome back! Sign in to your account.</h6>
                            <h6 class="collapse-h6">If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the Billing & Shipping section.</h6>
                                <div class="group-inline u-s-m-b-13">
                                    <div class="group-1 u-s-p-r-16">
                                        <label for="user-name-email">Username or Email
                                            <span class="astk">*</span>
                                        </label>
                                        <input type="text" id="user-name-email" class="text-field" placeholder="Username / Email">
                                    </div>
                                    <div class="group-2">
                                        <label for="password">Password
                                            <span class="astk">*</span>
                                        </label>
                                        <input type="text" id="password" class="text-field" placeholder="Password">
                                    </div>
                                </div>
                                <div class="u-s-m-b-13">
                                    <button type="submit" class="button button-outline-secondary">Login</button>
                                    <input type="checkbox" class="check-box" id="remember-me-token">
                                    <label class="label-text" for="remember-me-token">Remember me</label>
                                </div>
                                <div class="page-anchor">
                                    <a href="#" class="u-c-brand">Lost your password?</a>
                                </div>

                        </div>
                    </div>
                    <!-- First-Accordion /- -->
                    <!-- Second Accordion -->
                    <div>
                        <div class="message-open u-s-m-b-24">
                            Have a coupon?
                            <strong>
                                <a class="u-c-brand" data-toggle="collapse" href="#showcoupon">Click here to enter your code</a>
                            </strong>
                        </div>
                        <div class="collapse u-s-m-b-24" id="showcoupon">
                            <h6 class="collapse-h6">
                                Enter your coupon code if you have one.
                            </h6>
                            <div class="coupon-field">
                                <label class="sr-only" for="coupon-code">Apply Coupon</label>
                                <input id="coupon-code" type="text" class="text-field" placeholder="Coupon Code">
                                <button type="submit" class="button">Apply Coupon</button>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Second Accordion /- -->
                        <div class="row">
                            <!-- Billing-&-Shipping-Details -->
                            <div class="col-lg-6" id="deliveryAddresses"> <!-- use the id to refresh the addresses -->
                                @include('front.products.delivery_addresses')
                            </div>
                            <!-- Billing-&-Shipping-Details /- -->
                            <!-- Checkout -->
                            <div class="col-lg-6">
                                <h4 class="section-h4">Your Order</h4>
                                <div class="order-table">
                                    <table class="u-s-m-b-13">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $total_price = 0 @endphp
                                            @foreach($getCartItems as $item)
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
                                                    <h3 class="order-h3">Subtotal</h3>
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
                                                    <h6 class="order-h6">₱ 0.00</h6>
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
                                    {{-- <div class="u-s-m-b-13">
                                        <input type="radio" class="radio-box" name="payment_gateway" id="credit-card-stripe" value="Stripe">
                                        <label class="label-text" for="credit-card-stripe">Credit Card (Stripe)</label>
                                    </div> --}}
                                    <div class="u-s-m-b-13">
                                        <input type="radio" class="radio-box" name="payment_gateway" id="paypal" value="Paypal">
                                        <label class="label-text" for="paypal">Paypal</label>
                                    </div>
                                    <div class="u-s-m-b-13">
                                        <input type="radio" class="radio-box" name="payment_gateway" id="paylater" value="Paypal">
                                        <label class="label-text" for="paypal">Buy Now, Pay Later</label>
                                    </div>
                                    <div class="u-s-m-b-13">
                                        <input type="checkbox" class="check-box" id="accept" value="accepted" title="Please agree to T&C">
                                        <label class="label-text no-color" for="accept">I’ve read and accept the
                                            <a href="terms-and-conditions.html" class="u-c-brand">terms & conditions</a>
                                        </label>
                                    </div>
                                    <button type="submit" class="button button-outline-secondary">Place Order</button>
                                </div>
                            </div>
                            <!-- Checkout /- -->
                        </div>
                </div>
            </div>
        </form>
        </div>
    </div>
    <!-- Checkout-Page /- -->

@endsection