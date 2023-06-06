<?php use App\Models\Product;
    use App\Models\Vendor;  ?>
@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>{{ $getVendorShop }}</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="javascript:;">{{ $getVendorShop}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Shop-Page -->
    <div class="page-shop u-s-p-t-80">
        <div class="container">
            <!-- Shop-Intro -->
            {{-- <div class="shop-intro">
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>{{ $getVendorShop }}</li>
                </ul>
            </div> --}}
            <!-- Shop-Intro /- -->
            <div class="row">
                <!-- Shop-Right-Wrapper -->
                <div class="col-lg-10 col-md col-sm-12">
                    <!-- Page-Bar -->
                    <div class="page-bar clearfix">
                    </div>
                    <!-- Page-Bar /- -->
                    <!-- Simple Paganitaion /- -->
                    <div class="">
                        @include('front.products.vendor_products_listing')
                    </div>
                    @if(isset($_GET['sort']))
                        <div> {{ $vendorProducts->appends(['sort'=>$_GET['sort']])->links() }}</div> <div>&nbsp;</div> 
                    @else
                        <div> {{ $vendorProducts->links() }}</div> <div>&nbsp;</div> 
                    @endif
                </div>
                <!-- Shop-Right-Wrapper /- -->
                <!-- Shop-Pagination -->
                 <?php /* {{-- <div class="pagination-area">
                    <div class="pagination-number">
                        <ul>
                            <li style="display: none">
                                <a href="shop-v1-root-category.html" title="Previous">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                            </li>
                            <li class="active">
                                <a href="shop-v1-root-category.html">1</a>
                            </li>
                            <li>
                                <a href="shop-v1-root-category.html">2</a>
                            </li>
                            <li>
                                <a href="shop-v1-root-category.html">3</a>
                            </li>
                            <li>
                                <a href="shop-v1-root-category.html">...</a>
                            </li>
                            <li>
                                <a href="shop-v1-root-category.html">10</a>
                            </li>
                            <li>
                                <a href="shop-v1-root-category.html" title="Next">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>  --}}  */?>
                <!-- Shop-Pagination /- -->
            </div>
        </div>
    </div>
    <!-- Shop-Page /- -->
@endsection
