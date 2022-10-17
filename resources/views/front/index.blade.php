<?php use App\Models\Product;  ?>
@extends('front.layout.layout')
@section('content')
<!-- Main-Slider -->
<div class="default-height ph-item">
    <div class="slider-main owl-carousel">
        @foreach($sliderbanners as $banner)
        <div class="bg-image">
            <div class="slide-content">
                    <h1> <a @if(!empty($banner['link'])) href="{{ url($banner['link']) }}" @else href="javascript:;" @endif>
                        <img title="{{ $banner['title'] }}" alt="{{ $banner['alt'] }}" src="{{ asset('front/images/banner_images/'.$banner['image']) }}"></a></h1>
                    <h2>{{ $banner['title'] }}</h2>
            </div>
        </div>
        @endforeach
 </div>
</div>
    <!-- If the fix banner is coming only, then execute/- -->
 @if(isset($fixBanners [0] ['image']))
    <!-- Banner-Layer -->
    <div class="banner-layer">
        <div class="container">
            <div class="image-banner">
                <a target="_blank" rel="nofollow" href="{{ url($fixBanners [0] ['link']) }}" class="mx-auto banner-hover effect-dark-opacity">
                    <img class="img-fluid" src="{{ asset('front/images/banner_images/'.$fixBanners [0] ['image']) }}" alt="$fixBanners [0] ['alt']" title="$fixBanners [0] ['title']">
                </a>
            </div>
        </div>
    </div>
 @endif
    <!-- Banner-Layer /- -->
    <!-- Latest Collection -->
<section class="section-maker">
        <div class="container">
            <div class="sec-maker-header text-center">
                <h3 class="sec-maker-h3">Latest Products</h3>
                <ul class="nav tab-nav-style-1-a justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#men-latest-products">New Arrivals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#men-best-selling-products">Best Sellers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#discounted-products">Discounted Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#men-featured-products">Featured Products</a>
                    </li>
                </ul>
            </div>
            <div class="wrapper-content">
                <div class="outer-area-tab">
                    <div class="tab-content">
                        <div class="tab-pane active show fade" id="men-latest-products">
                            <div class="slider-fouc">
                                <div class="products-slider owl-carousel" data-item="4">
                                     <!-- ForeachLoop of Array for the latest products to display -->
                                    @foreach($newProducts as $product)
                                     <!-- Fetching the Image to be displayed -->
                                    <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                        <div class="item">
                                            <div class="image-container">
                                                <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                    <!-- Check if the file exist or not, if not then show dummy image -->
                                                    @if(!empty($product['product_image']) && file_exists($product_image_path))
                                                        <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                                    @else
                                                        <img class="img-fluid" src="{{ asset('front/images/product_images/small/noimage.png') }}" alt="NoImage">
                                                    @endif
                                                </a>
                                                <div class="item-action-behaviors">
                                                    <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                                                    </a>
                                                    <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                    <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                    <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                                </div>
                                            </div>
                                            <div class="item-content">
                                                <div class="what-product-is">
                                                    <ul class="bread-crumb">
                                                        <li>
                                                            <a href="{{ url('product/'.$product['product_code']) }} ">{{ $product['product_code'] }}</a>
                                                        </li>
                                                    </ul>
                                                    <h6 class="item-title">
                                                        <a href="{{ url('product/'.$product['product_name']) }}">{{ $product['product_name'] }}</a>
                                                    </h6>
                                                    <div class="item-stars">
                                                        <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                            <span style='width:0'></span>
                                                        </div>
                                                        <span>(0)</span>
                                                    </div>
                                                </div>
                                                <!-- Call the dunction created inside the products model for the discounted price -->
                                                <?php $getDiscountedPrice = Product::getDiscountedPrice($product['id']);  ?>
                                                @if ($getDiscountedPrice > 0)
                                                    <div class="price-template">
                                                        <div class="item-new-price">
                                                            ₱ {{ $getDiscountedPrice }}
                                                        </div>
                                                        <div class="item-old-price">
                                                            ₱ {{ $product['product_price'] }}
                                                        </div>
                                                    </div>
                                                @else
                                                <div class="price-template">
                                                    <div class="item-new-price">
                                                        ₱ {{ $product['product_price'] }}
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="tag new">
                                                <span>NEW</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane show fade" id="men-best-selling-products">
                            <div class="slider-fouc">
                                <div class="products-slider owl-carousel" data-item="4">
                                    <!-- ForeachLoop of Array for the latest products to display -->
                                   @foreach($bestSeller as $product)
                                    <!-- Fetching the Image to be displayed --> 
                                   <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                       <div class="item">
                                           <div class="image-container">
                                               <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                   <!-- Check if the file exist or not, if not then show dummy image -->
                                                   @if(!empty($product['product_image']) && file_exists($product_image_path))
                                                       <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                                   @else
                                                       <img class="img-fluid" src="{{ asset('front/images/product_images/small/noimage.png') }}" alt="NoImage">
                                                   @endif
                                               </a>
                                               <div class="item-action-behaviors">
                                                   <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                                                   </a>
                                                   <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                   <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                   <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                               </div>
                                           </div>
                                           <div class="item-content">
                                               <div class="what-product-is">
                                                   <ul class="bread-crumb">
                                                       <li>
                                                           <a href="{{ url('product/'.$product['product_code']) }} ">{{ $product['product_code'] }}</a>
                                                       </li>
                                                   </ul>
                                                   <h6 class="item-title">
                                                       <a href="{{ url('product/'.$product['product_name']) }}">{{ $product['product_name'] }}</a>
                                                   </h6>
                                                   <div class="item-stars">
                                                       <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                           <span style='width:0'></span>
                                                       </div>
                                                       <span>(0)</span>
                                                   </div>
                                               </div>
                                               <!-- Call the dunction created inside the products model for the discounted price -->
                                               <?php $getDiscountedPrice = Product::getDiscountedPrice($product['id']);  ?>
                                               @if ($getDiscountedPrice > 0)
                                                   <div class="price-template">
                                                       <div class="item-new-price">
                                                           ₱ {{ $getDiscountedPrice }}
                                                       </div>
                                                       <div class="item-old-price">
                                                           ₱ {{ $product['product_price'] }}
                                                       </div>
                                                   </div>
                                               @else
                                               <div class="price-template">
                                                   <div class="item-new-price">
                                                       ₱ {{ $product['product_price'] }}
                                                   </div>
                                               </div>
                                               @endif
                                           </div>
                                           <div class="tag new">
                                               <span>NEW</span>
                                           </div>
                                       </div>
                                   @endforeach
                               </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="discounted-products">
                            <div class="slider-fouc">
                                <div class="products-slider owl-carousel" data-item="4">
                                    <!-- ForeachLoop of Array for the latest products to display -->
                                   @foreach($discountedProds as $product)
                                    <!-- Fetching the Image to be displayed --> 
                                   <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                       <div class="item">
                                           <div class="image-container">
                                               <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                   <!-- Check if the file exist or not, if not then show dummy image -->
                                                   @if(!empty($product['product_image']) && file_exists($product_image_path))
                                                       <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                                   @else
                                                       <img class="img-fluid" src="{{ asset('front/images/product_images/small/noimage.png') }}" alt="NoImage">
                                                   @endif
                                               </a>
                                               <div class="item-action-behaviors">
                                                   <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                                                   </a>
                                                   <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                   <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                   <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                               </div>
                                           </div>
                                           <div class="item-content">
                                               <div class="what-product-is">
                                                   <ul class="bread-crumb">
                                                       <li>
                                                           <a href="{{ url('product/'.$product['product_code']) }} ">{{ $product['product_code'] }}</a>
                                                       </li>
                                                   </ul>
                                                   <h6 class="item-title">
                                                       <a href="{{ url('product/'.$product['product_name']) }}">{{ $product['product_name'] }}</a>
                                                   </h6>
                                                   <div class="item-stars">
                                                       <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                           <span style='width:0'></span>
                                                       </div>
                                                       <span>(0)</span>
                                                   </div>
                                               </div>
                                               <!-- Call the dunction created inside the products model for the discounted price -->
                                               <?php $getDiscountedPrice = Product::getDiscountedPrice($product['id']);  ?>
                                               @if ($getDiscountedPrice > 0)
                                                   <div class="price-template">
                                                       <div class="item-new-price">
                                                           ₱ {{ $getDiscountedPrice }}
                                                       </div>
                                                       <div class="item-old-price">
                                                           ₱ {{ $product['product_price'] }}
                                                       </div>
                                                   </div>
                                               @else
                                               <div class="price-template">
                                                   <div class="item-new-price">
                                                       ₱ {{ $product['product_price'] }}
                                                   </div>
                                               </div>
                                               @endif
                                           </div>
                                           <div class="tag new">
                                               <span>NEW</span>
                                           </div>
                                       </div>
                                   @endforeach
                               </div>   
                            </div>
                        </div>
                        <div class="tab-pane fade" id="men-featured-products">
                            <div class="slider-fouc">
                                <div class="products-slider owl-carousel" data-item="4">
                                    <!-- ForeachLoop of Array for the latest products to display -->
                                   @foreach($featured as $product)
                                    <!-- Fetching the Image to be displayed --> 
                                   <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                       <div class="item">
                                           <div class="image-container">
                                               <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                   <!-- Check if the file exist or not, if not then show dummy image -->
                                                   @if(!empty($product['product_image']) && file_exists($product_image_path))
                                                       <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                                   @else
                                                       <img class="img-fluid" src="{{ asset('front/images/product_images/small/noimage.png') }}" alt="NoImage">
                                                   @endif
                                               </a>
                                               <div class="item-action-behaviors">
                                                   <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                                                   </a>
                                                   <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                   <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                   <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                               </div>
                                           </div>
                                           <div class="item-content">
                                               <div class="what-product-is">
                                                   <ul class="bread-crumb">
                                                       <li>
                                                           <a href="{{ url('product/'.$product['product_code']) }} ">{{ $product['product_code'] }}</a>
                                                       </li>
                                                   </ul>
                                                   <h6 class="item-title">
                                                       <a href="{{ url('product/'.$product['product_name']) }}">{{ $product['product_name'] }}</a>
                                                   </h6>
                                                   <div class="item-stars">
                                                       <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                           <span style='width:0'></span>
                                                       </div>
                                                       <span>(0)</span>
                                                   </div>
                                               </div>
                                               <!-- Call the dunction created inside the products model for the discounted price -->
                                               <?php $getDiscountedPrice = Product::getDiscountedPrice($product['id']);  ?>
                                               @if ($getDiscountedPrice > 0)
                                                   <div class="price-template">
                                                       <div class="item-new-price">
                                                           ₱ {{ $getDiscountedPrice }}
                                                       </div>
                                                       <div class="item-old-price">
                                                           ₱ {{ $product['product_price'] }}
                                                       </div>
                                                   </div>
                                               @else
                                               <div class="price-template">
                                                   <div class="item-new-price">
                                                       ₱ {{ $product['product_price'] }}
                                                   </div>
                                               </div>
                                               @endif
                                           </div>
                                           <div class="tag new">
                                               <span>NEW</span>
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
    <!-- Top Collection /- -->
    <!-- Banner-Layer -->
<div class="banner-layer">
        <div class="container">
            <div class="image-banner">
                <a target="_blank" rel="nofollow" href="" class="mx-auto banner-hover effect-dark-opacity">
                    <img class="img-fluid" src="{{ asset('front/images/banners/logoo.png') }}" alt="Winter Season Banner">
                </a>
            </div>
        </div>
</div>
    <!-- Banner-Layer /- -->
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