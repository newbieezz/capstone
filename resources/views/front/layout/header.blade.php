<?php 
  use App\Models\Section;
  $sections = Section::sections();
?> 
<!-- Header -->
    <header> 
          <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1 class="text-light"><a href="index.html">P-Store</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="active" href="{{ url('/') }}">Home</a></li>
          <li><a href="#"><span>About</span></a></li>
          <li class="dropdown"><a href="#"><span>@if(Auth::check())
                        My Account
                    @else
                        Login/Register
                    @endif </span> <i class="bi bi-chevron-down"></i></a> 
            <ul class="g-dropdown" style="width:200px">
                @if(Auth::check())
                <li>
                    <a href="{{ url('user/account') }}">
                        <i class="fas fa-cog u-s-m-r-9"></i>My Account</a>
                </li>
                <li>
                    <a href="{{ url('user/logout') }}">
                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                        Logout</a>
                </li>
            @else
                <li>
                    <a href="{{ url('user/login-register') }}">
                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                        Customer Login</a>
                </li>
                <li>
                    <a href="{{ url('vendor/login-register') }}">
                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                        Vendor Login</a>
                </li>
            @endif
            </ul>
        </li>
          <li><a href="{{ url('cart') }}">
            <i class="fas fa-cart-plus u-s-m-r-9"></i>
            My Cart</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
    
  </header><!-- End Header -->

        <!-- Top-Header -->
        <div class="full-layer-outer-header">
            <div class="container clearfix">
            </div>
        </div>
        <!-- Top-Header /- -->
        <div class="container"></div>
        <!-- Mid-Header -->
        <div class="full-layer-mid-header">
            <div class="container">
            </div>
        </div>
        <!-- Mid-Header /- -->
        <!-- Bottom-Header -->
        <div class="full-layer-bottom-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="v-menu v-close">
                            <span class="v-title">
                                <i class="ion ion-md-menu"></i>
                                All Categories
                                <i class="fas fa-angle-down"></i>
                            </span>
                            <nav>
                                <div class="v-wrapper">
                                    <ul class="v-list animated fadeIn">
                                         <!-- Display the sections addded in the db /- -->
                                         @foreach($sections as $section)
                                            <!-- check if a section has a category data or not, if empty then not display /- -->
                                            @if(count($section['categories']) > 0 )
                                        <li class="js-backdrop">
                                            <a href="javascript:;">
                                                <i class="ion-ios-add-circle"></i>
                                                    {{ $section['name'] }}
                                                <i class="ion ion-ios-arrow-forward"></i>
                                            </a>
                                            <button class="v-button ion ion-md-add"></button>
                                            <div class="v-drop-right" style="width: 700px;">
                                                <div class="row"> <!-- Display the categories under each section /- -->
                                                    @foreach($section['categories'] as $category)
                                                        <div class="col-lg-4">
                                                            <ul class="v-level-2">
                                                                <li>
                                                                    <a href="{{ url($category['url']) }}">{{ $category['category_name'] }}</a>
                                                                    <ul> <!-- Display the subcategories under each category /- -->
                                                                        @foreach($category['subcategories'] as $subcategory)
                                                                            <li>
                                                                                <a href="{{ url($subcategory['url']) }}">{{ $subcategory['category_name'] }}</a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endforeach    
                                                </div>
                                            </div>
                                        </li>
                                            @endif
                                         @endforeach
                                        <li>
                                            <a class="v-more">
                                                <i class="ion ion-md-add"></i>
                                                <span>View More</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                    {{-- <div class="col-lg-9">
                        <ul class="bottom-nav g-nav u-d-none-lg">
                            <li>
                                <a href="listing-without-filters.html">New Arrivals
                                    <span class="superscript-label-new">NEW</span>
                                </a>
                            </li>
                            <li>
                                <a href="listing-without-filters.html">Best Seller
                                    <span class="superscript-label-hot">HOT</span>
                                </a>
                            </li>
                            <li>
                                <a href="listing-without-filters.html">Featured
                                </a>
                            </li>
                            <li>
                                <a href="listing-without-filters.html">Discounted
                                    <span class="superscript-label-discount">-30%</span>
                                </a>
                            </li>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- Bottom-Header /- -->
    </header>
<!-- Header /- -->



