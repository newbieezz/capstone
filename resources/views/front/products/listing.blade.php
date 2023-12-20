
@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Shop</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="javascript;:">Shop</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Shop-Page -->
    <div class="page-shop u-s-p-t-40">
        <div class="container">
            <!-- Shop-Intro -->
            <div class="shop-intro">
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <?php echo $categoryDetails['breadcrumbs']; ?>
                </ul>
            </div>
            <!-- Shop-Intro /- -->
            <div class="row">
            @include('front.products.filters')
                <!-- Shop-Right-Wrapper -->
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <!-- Page-Bar -->
                    <div class="page-bar clearfix">
                        {{-- <div class="shop-settings">
                            <a id="list-anchor">
                                <i class="fas fa-th-list"></i>
                            </a>
                            <a id="grid-anchor" class="active">
                                <i class="fas fa-th"></i>
                            </a>
                        </div> --}}
                        <!-- Toolbar Sorter 1  --> 
                        <form name="sortProducts" id="sortProducts" >
                            <input type="hidden" name="url" id="url" value="{{ $url }}">
                            <div class="toolbar-sorter">
                                <div class="select-box-wrapper">
                                    <label class="sr-only" for="sort-by">Sort By</label>
                                    <select name="sort" id="sort" class="select-box" >
                                        {{-- <option selected="selected" value="">Sort By: Best Selling</option> --}}
                                        <option selected="">Select</option>
                                        <option value="product_latest" @if(isset($_GET['sort']) && $_GET['sort']=="product_latest") selected="" @endif>
                                            Sort By: Latest</option>
                                        <option value="price_lowest" @if(isset($_GET['sort']) && $_GET['sort']=="price_lowest") selected="" @endif>
                                            Sort By: Lowest Price</option>
                                        <option value="price_highest" @if(isset($_GET['sort']) && $_GET['sort']=="price_highest") selected="" @endif>
                                            Sort By: Highest Price</option>
                                        <option value="name_a_z" @if(isset($_GET['sort']) && $_GET['sort']=="name_a_z") selected="" @endif>
                                            Sort By: Name A - Z</option>
                                        <option value="name_z_a" @if(isset($_GET['sort']) && $_GET['sort']=="name_z_a") selected="" @endif>
                                            Sort By: Name Z - A</option>
                                        {{-- <option value="">Sort By: Best Rating</option> --}}
                                    </select>
                                </div>
                            </div>
                        </form>
                        <!-- //end Toolbar Sorter 1  -->
                        <!-- Toolbar Sorter 2  -->
                        <div class="toolbar-sorter-2">
                            <div class="select-box-wrapper">
                                <label class="sr-only" for="show-records">Show Records Per Page</label>
                                <select class="select-box" id="show-records">
                                    <option selected="selected" value="">Showing: {{ count($categoryProducts) }}</option>
                                    <option value="">Showing All</option>
                                </select>
                            </div>
                        </div> 
                    </div>
                    <div class="filter_product">
                        @include('front.products.ajax_products_listing')
                    </div>
                    @if(isset($_GET['sort']))
                        <div> {{ $categoryProducts->appends(['sort'=>$_GET['sort']])->links() }}</div> <div>&nbsp;</div> 
                    @else
                        <div> {{ $categoryProducts->links() }}</div> <div>&nbsp;</div> 
                    @endif
                    <div>{{ $categoryDetails['categoryDetails']['description'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop-Page /- -->
@endsection
