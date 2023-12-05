<?php 
  use App\Models\Section;
  use App\Models\Notification;
  $sections = Section::sections();
//   $totalCartItems = totalCartItems();
?> 
<style>
@media (max-width: 767px) {
  header {
    text-align: center;
  }     

  nav ul {
    display: block;
  }

  nav li {
    display: block;
    margin-right: 0;
  }
}
</style>
<!-- Header -->
    <header> 
          <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1 class="text-light"><a href="{{ url('/') }}">P-Store</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
        
            @if(Auth::check())
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="icon-bell mx-0"></i>
                    <span class="count"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>

                        @foreach(Notification::where('user_id', Auth::guard('web')->user()->id)->orderByDesc('id')->get() as $key => $value)
                            @if ($value->module == 'order' && $value->receiver == 'vendor')
                            <a style="padding-right: 30px" href="{{ url('admin/orders/'. $value->module_id)}}" class="dropdown-item preview-item">
                            @elseif ($value->module == 'order' && $value->receiver == 'customer')
                            <a style="padding-right: 30px" href="{{ url('user/orders/'. $value->module_id)}}" class="dropdown-item preview-item">
                            @endif
                                <!-- <div class="preview-thumbnail">
                                    <div class="preview-icon bg-success">
                                        <i class="ti-info-alt mx-0"></i>
                                    </div>
                                </div> -->
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">{{ strtoupper($value->module) }}</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        {{ $value->message }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </li>
            @endif
          <li><a class="active" href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('about') }}"><span>About</span></a></li>
          <li class="dropdown"><a href="{{ url('user/account') }}"><span>@if(Auth::check())
            {{Auth::guard('web')->user()->name}}
                    @else
            <li><a href="{{ url('user/login-register') }}"><span>Login</span></a></li>
            <li><a href="{{ url('user/userReg') }}"><span>Register</span></a></li>
                    
                    @endif </span> <i class="bi bi-chevron-down"></i></a> 
            <ul class="g-dropdown" style="width:200px">
                @if(Auth::check())
                <li>
                    <a href="{{ url('user/account') }}">
                        <i class="fas fa-cog u-s-m-r-9"></i>My Account</a>
                </li>
                <li>
                    <a href="{{ url('user/orders') }}">
                        <i class="fas fa-cog u-s-m-r-9"></i>My Orders</a>
                </li>
                <li>
                    <a href="{{ url('user/pay-later') }}">
                        <i class="fas fa-cog u-s-m-r-9"></i>Pay Later</a>
                </li>
                <li>
                    <a href="{{ url('user/logout') }}">
                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                        Logout</a>
                </li>
            @endif
            </ul>
            <li><a href="{{ url('cart') }}">
                <i class="fas fa-cart-plus u-s-m-r-9"></i><span class="item-counter"> 
                    {{-- {{ $totalCartItems }} --}}
                </span>My Cart</a>
            </li>
        </li>
          
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
                        {{-- next to categories --}}
                </div>
            </div>
            
        </div>
        <!-- Bottom-Header /- -->
    </header>
<!-- Header /- -->



