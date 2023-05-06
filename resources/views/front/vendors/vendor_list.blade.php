<?php use App\Models\Product;
    use App\Models\Vendor;  ?>
@extends('front.layout.layout')
@section('content')

     <!-- Produuct Section and Categories -->
<section class="section-maker">
    <div class="container">
        <div class="sec-maker-header text-center">
            <h3 class="sec-maker-h3">List of Shops</h3>
        </div>
        <div class="wrapper-content">
            <div class="outer-area-tab">
                <div class="tab-content">
                    <div class="tab-pane active show fade" id="men-latest-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="10">
                                 <!-- ForeachLoop of Array for the list of stores/vendors available to display -->
                                @foreach($getVendorDetails as $vendors)
                                 <!-- Fetching the list of stores/vendors available to display -->
                                    <div class="image-container">
                                        <a class="item-img-wrapper-link" href="">
                                            <!-- Check if the file exist or not, if not then show dummy image -->
                                            @if(!empty($vendors['shop_image']) && file_exists($product_image_path))
                                                <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Vendor">
                                            @else
                                                <img class="img-fluid" src="{{ asset('front/images/shop_images/noimage.png') }}" alt="NoImage">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="item-content">
                                        <div class="what-product-is">
                                            <ul class="bread-crumb">
                                                <li>
                                                </li>
                                            </ul>
                                            <h6 class="item-title">
                                                <a href="/products/{{ $vendors['vendor_id'] }}">{{ $vendors['shop_name'] }}</a>
                                            </h6>
                                            <div class="item-stars">
                                                <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                    <span style='width:0'></span>
                                                </div>
                                                <span>(0)</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Site-Priorities -->
<section class="app-priority">
        <div class="container">
            <div class="priority-wrapper u-s-p-b-80">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="single-item-wrapper">
                            <div class="single-item-icon">
                                <i class="ion ion-md-star"></i>
                            </div>
                            <h2>
                                Great Value
                            </h2>
                            <p>We offer competitive prices on our 100 million plus product range</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="single-item-wrapper">
                            <div class="single-item-icon">
                                <i class="ion ion-md-cash"></i>
                            </div>
                            <h2>
                                Shop with Confidence
                            </h2>
                            <p>Our Protection covers your purchase from click to delivery</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="single-item-wrapper">
                            <div class="single-item-icon">
                                <i class="ion ion-ios-card"></i>
                            </div>
                            <h2>
                                Safe Payment
                            </h2>
                            <p>Pay with the world’s most popular and secure payment methods</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="single-item-wrapper">
                            <div class="single-item-icon">
                                <i class="ion ion-md-contacts"></i>
                            </div>
                            <h2>
                                24/7 Help Center
                            </h2>
                            <p>Round-the-clock assistance for a smooth shopping experience</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
    <!-- Site-Priorities /- -->
@endsection