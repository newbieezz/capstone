<?php use App\Models\Product;
    use App\Models\Vendor;  
    $collection = new Illuminate\Database\Eloquent\Collection();
?>
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
    <div class="page-shop u-s-p-t-40">
        <div class="container">
                <!-- Shop-Right-Wrapper -->
                <div class="col-lg-12 col-md col-sm-8 ">
                    <!-- Page-Bar -->
                    @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif 
                    <div class="page-bar clearfix">
                        <form action="{{ url('pay-later/'.$vendorid) }}" method="post"> @csrf
                            <input type="hidden" name="vendor_id" value="{{ $vendorid }}"/>
                           <h4>Activate your PayLater Now! &nbsp;<button class="btn btn-primary" type="submit">Click to Apply</button></h4> 
                        </form>
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
        </div>
    </div>
    <!-- Shop-Page /- -->
@endsection
