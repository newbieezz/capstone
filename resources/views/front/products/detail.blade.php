<?php use App\Models\Product; 
      use App\Models\ProductsFilter; 
    $productFilters = ProductsFilter::productFilters();
?>

@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Detail</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="javascript:;">Detail</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Single-Product-Full-Width-Page -->
    <div class="page-detail u-s-p-t-80">
        <div class="container">
            <!-- Product-Detail -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <!-- Product-zoom-area -->
                    <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                        <a href="{{ asset('front/images/product_images/large/'.$productDetails['product_image']) }}">
                            <img src="{{ asset('front/images/product_images/large/'.$productDetails['product_image']) }}" alt="" width="500" height="500" />
                        </a>
                    </div>
                    <div class="thumbnails" style="margin-top: 30px; ">
                        <a href="{{ asset('front/images/product_images/large/'.$productDetails['product_image']) }}" 
                            data-standard="{{ asset('front/images/product_images/small/'.$productDetails['product_image']) }}">
                            <img width="120" height="120" src="{{ asset('front/images/product_images/small/'.$productDetails['product_image']) }}" alt="Product" />
                        </a>
                        @foreach($productDetails['images'] as $image)
                            <a href="{{ asset('front/images/product_images/large/'.$image['image']) }}" 
                                data-standard="{{ asset('front/images/product_images/small/'.$image['image']) }}">
                                <img width="120" height="120" src="{{ asset('front/images/product_images/small/'.$image['image']) }}" alt="Product" />
                            </a>
                        @endforeach
                    </div>
                    <!-- Product-zoom-area /- -->
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <!-- Product-details -->
                    <div class="all-information-wrapper"> 
                        @if(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>Error: </strong> {{ Session::get('error_message')}}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                      @endif
                      @if(Session::has('success_message'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message')}} &nbsp;&nbsp; <i><a href="{{ url('/cart') }}"> View Cart</a></i>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                      @endif
                        <div class="section-1-title-breadcrumb-rating">
                            <div class="product-title">
                                <h1>
                                    <a href="javascript:;">{{ $productDetails['product_name'] }}</a>
                                </h1>
                            </div>
                            <ul class="bread-crumb">
                                <li class="has-separator">
                                    <a href="{{url('/')}}">Home</a>
                                </li>
                                <li class="has-separator">
                                    <a href="javascript:;">{{ $productDetails['section']['name'] }}</a>
                                </li>
                                <?php echo $categoryDetails['breadcrumbs']; ?>
                            </ul>
                        </div>
                        <div class="section-2-short-description u-s-p-y-14">
                            <h6 class="information-heading u-s-m-b-8">Description:</h6>
                            <p>{{ $productDetails['description'] }}
                            </p>
                        </div>
                        <div class="section-3-price-original-discount u-s-p-y-14">
                            <?php $getDiscountedPrice = Product::getDiscountedPrice($productDetails['id']);  ?>
                            <span class="getAttributePrice">
                                @if ($getDiscountedPrice > 0)
                                    <div class="price">
                                        <h4>₱ {{ $getDiscountedPrice }}</h4>
                                    </div>
                                    <div class="original-price">
                                        <span>Original Price:</span>
                                        <span>₱ {{ $productDetails['product_price'] }}</span>
                                    </div>
                                @else
                                    <div class="price">
                                        <h4>₱ {{ $productDetails['product_price'] }}</h4>
                                    </div>
                                @endif 
                            </span>
                                {{-- <div class="discount-price">
                                    <span>Discount:</span>
                                    <span>15%</span>
                                </div>
                                <div class="total-save">
                                    <span>Save:</span>
                                    <span>$20</span>
                                </div> --}}
                        </div>
                        <div class="section-4-sku-information u-s-p-y-14">
                            <h6 class="information-heading u-s-m-b-8">Sku Information:</h6>
                            <div class="left">
                                <span>Product Code:</span>
                                <span>{{ $productDetails['product_code'] }}</span>
                            </div>
                            <div class="availability">
                                <span>Availability:</span>
                                @if($totalStock > 0)
                                    <span>In stock</span>
                                @else
                                    <span style="color: red">Out of Stock</span>
                                @endif
                            </div>
                            @if($totalStock > 0)
                                <div class="left">
                                    <span>Only:</span>
                                    <span>{{ $totalStock }} left</span>
                                </div>
                            @endif
                        </div>
                        {{-- Show Vendor of the Product --}}
                        @if(isset($productDetails['vendor']))
                            <div>Sold by : <a  href="/products/{{ $productDetails['vendor']['id'] }}">{{$productDetails['vendor']['vendorshopdetails']['shop_name'] }}</a> </div>
                        @endif
                        <form action="{{ url('cart/add') }}" class="post-form" method="Post"> @csrf
                            <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                            <div class="section-5-product-variants u-s-p-y-14">
                                <div class="sizes u-s-m-b-11">
                                    <span>Available Unit:</span>
                                    <div class="size-variant select-box-wrapper">
                                        <select name="size" id="getPrice" product-id="{{ $productDetails['id'] }}" class="select-box product-size" required="">
                                            <option value="">Select</option>
                                            @foreach($productDetails['attributes'] as $attribute)
                                                {{-- @if (empty($attribute['size'] ))
                                                    <option value="{{ $attribute['weight'] }}">{{ $attribute['weight'] }} {{$attribute['measurement'] }}</option>
                                                @else --}}
                                                    <option value="{{ $attribute['size'] }}">{{ $attribute['size'] }}</option>
                                                {{-- @endif --}}
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="section-6-social-media-quantity-actions u-s-p-y-14">
                                {{-- <div class="quick-social-media-wrapper u-s-m-b-22">
                                    <span>Share:</span>
                                    <ul class="social-media-list">
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-google-plus-g"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fas fa-rss"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-pinterest"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div> --}}
                                <div class="quantity-wrapper u-s-m-b-22">
                                    <span>Quantity:</span>
                                    <div class="quantity">
                                        <input type="number" class="quantity-text-field" name="quantity" value="1">
                                    </div>
                                </div>
                                <div>
                                    <button class="button button-outline-secondary" type="submit">Add to cart</button>
                                    <button class="button button-outline-secondary far fa-heart u-s-m-l-6"></button>
                                    <button class="button button-outline-secondary far fa-envelope u-s-m-l-6"></button>
                                </div>
                        </div>
                        </form>
                    </div>
                    <!-- Product-details /- -->
                </div>
            </div>

            <!-- Different-Product-Section -->
            <div class="detail-different-product-section u-s-p-t-80">
                <!-- Similar-Products -->
                <section class="section-maker">
                    <div class="container">
                        <div class="sec-maker-header text-center">
                            <h3 class="sec-maker-h3">Similar Products</h3>
                        </div>
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">
                                @foreach($similarProducts as $product)
                                    <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                                <!-- Check if the file exist or not, if not then show dummy image -->
                                                @if(!empty($product['product_image']) && file_exists($product_image_path))
                                                    <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                                @else
                                                    <img class="img-fluid" src="{{ asset('front/images/product_images/small/noimage.png') }}" alt="NoImage">
                                                @endif
                                            </a>
                                            <div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look</a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li class="has-separator">
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{$product ['brands'] ['name'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-description">
                                                    <p>{{ $product['description'] }} </p>
                                                </div>
                                                <div class="item-stars">
                                                    <div class='star' title="4.5 out of 5 - based on 23 Reviews">
                                                        <span style='width:67px'></span>
                                                    </div>
                                                    <span>(23)</span>
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
                                    <div class="image-container">
                                        <div class="item-action-behaviors">
                                            <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look</a>
                                            <a class="item-mail" href="javascript:void(0)">Mail</a>
                                            <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                            <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Similar-Products /- -->
                <!-- Recently-View-Products  -->
                <section class="section-maker">
                    <div class="container">
                        <div class="sec-maker-header text-center">
                            <h3 class="sec-maker-h3">Recently Viewed Products</h3>
                        </div>
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">
                                @foreach($recenltyViewedProd as $product)
                                    <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                                <!-- Check if the file exist or not, if not then show dummy image -->
                                                @if(!empty($product['product_image']) && file_exists($product_image_path))
                                                    <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                                @else
                                                    <img class="img-fluid" src="{{ asset('front/images/product_images/small/noimage.png') }}" alt="NoImage">
                                                @endif
                                            </a>
                                            <div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look</a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                                <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li class="has-separator">
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{$product ['brands'] ['name'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-description">
                                                    <p>{{ $product['description'] }} </p>
                                                </div>
                                                <div class="item-stars">
                                                    <div class='star' title="4.5 out of 5 - based on 23 Reviews">
                                                        <span style='width:67px'></span>
                                                    </div>
                                                    <span>(23)</span>
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
                </section>
                <!-- Recently-View-Products /- -->
            </div>
            <!-- Different-Product-Section /- -->
        </div>
    </div>
    <!-- Single-Product-Full-Width-Page /- -->
@endsection