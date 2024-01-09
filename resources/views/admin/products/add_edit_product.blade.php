@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Products</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">{{ $title }}</h4>
                
                  <!--Validation Error Message -->
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                     @endif
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
                        <strong>Success: </strong> {{ Session::get('success_message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                  @endif

                  
                <form class="forms-sample" @if(empty($product['id'])) action="{{ url('admin/add-edit-product') }}"
                  @else action="{{ url('admin/add-edit-product/'.$product['id']) }}" @endif
                  method="post"enctype="multipart/form-data"> @csrf
                  {{-- <div class="form-group">
                    <label for="category_id">Select Category</label>
                    <select name="category_id" id="category_id" class="form-control text-dark" >
                        <option value="">Select</option>
                            @foreach($categories as $category) <!--CATEGORY -->
                            <option @if(!empty($product['category_id']==$category['id'])) selected="" @endif
                              value="{{ $category['id'] }}">&nbsp;&nbsp;&raquo;&nbsp;{{ $category['category_name'] }}</option>
                        @endforeach
                    </select>
                  </div> --}}
                  <div class="form-group">
                    <label for="category_id">Select Category</label>
                    <select name="category_id" id="category_id" class="form-control text-dark" >
                        <option value="">Select</option>
                        @foreach($categories as $section) <!--SECTIONS -->
                            <optgroup label="{{ $section['name'] }}"></optgroup>
                            @foreach($section['categories'] as $category) <!--CATEGORY -->
                            <option @if(!empty($product['category_id']==$category['id'])) selected="" @endif
                              value="{{ $category['id'] }}">&nbsp;&nbsp;&raquo;&nbsp;{{ $category['category_name'] }}</option>
                            @foreach($category['subcategories'] as $subcategory) <!-- SUBCATEGORY -->
                            <option @if(!empty($product['category_id']==$subcategory['id'])) selected="" @endif
                              value="{{ $subcategory['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{ $subcategory['category_name'] }}</option>
                              @endforeach
                            @endforeach
                        @endforeach
                    </select>
                  </div>
                  <div class="loadFilters"> <!--Load the filters as product is updated -->
                    @include('admin.filters.category_filters')
                    {{-- @include('admin.filters.category_filters') --}}
                  </div>
                  <div class="form-group">
                    <label for="brand_id">Select Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control text-dark" >
                        <option value="">Select</option>
                        @foreach($brands as $brand) <!--BRANDS -->
                            <option @if(!empty($product['brand_id']==$brand['id'])) selected="" @endif
                              value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                        @endforeach
                    </select>
                  </div>
                  <form class="forms-sample" @if(empty($product['id'])) action="{{ url('admin/add-edit-product') }}"
                        @else action="{{ url('admin/add-edit-product/'.$product['id']) }}" @endif
                        method="post"enctype="multipart/form-data"> @csrf
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" id="product_name" 
                            placeholder="Enter Product Name" name="product_name"    
                            @if(!empty($product['product_name'])) value="{{ $product['product_name'] }}" 
                            @else value="{{ old('product_name') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="product_price">Product Price</label>
                        <input type="text" class="form-control" id="product_price" 
                            placeholder="Enter Product Price" name="product_price"    
                            @if(!empty($product['product_price'])) value="{{ $product['product_price'] }}" 
                            @else value="{{ old('product_price') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="markup">Product Markup (profit margin to add for Selling price) </label>
                        <input type="number" class="form-control" id="markup" 
                            placeholder="Enter price to add (ex. 6)" name="markup"    
                            @if(!empty($product['markup'])) value="{{ $product['markup'] }}" 
                            @else value="{{ old('markup') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="stock_quantity">Stock Quantity </label>
                        <input type="number" class="form-control" id="stock_quantity" 
                            placeholder="Enter Stocks Available" name="stock_quantity"    
                            @if(!empty($product['stock_quantity'])) value="{{ $product['stock_quantity'] }}" 
                            @else value="{{ old('stock_quantity') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="restock_threshold">Restock Threshold </label>
                        <p><i>Value indicating when the product should be restocked.</i></p>
                        <input type="number" class="form-control" id="restock_threshold" 
                            placeholder="Enter Restock Quantity" name="restock_threshold"    
                            @if(!empty($product['restock_threshold'])) value="{{ $product['restock_threshold'] }}" 
                            @else value="{{ old('restock_threshold') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="product_discount">Product Discount (%)</label>
                        <input type="text" class="form-control" id="product_discount" 
                            placeholder="Enter product Discount" name="product_discount"    
                            @if(!empty($product['product_discount'])) value="{{ $product['product_discount'] }}" 
                            @else value="{{ old('product_discount') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="product_image">Product Photo (Recommended Size: 1000x1000)</label>
                        <input type="file" class="form-control" id="product_image" name="product_image" >
                        @if(!empty($product['product_image']))
                        <a target="_blank" href="{{ url('front/images/product_images/large/'.$product['product_image']) }}">View Image</a> &nbsp; &nbsp; | &nbsp; &nbsp;
                          <a href="javascript:void(0)" class="confirmDelete" module="product-image" 
                          moduleid="{{$product['id']}}">Delete Image </a>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="description">Product Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" 
                              >{{ $product['description'] }}</textarea>
                      </div>
                      <div class="form-group">
                        <label for="weight">Weight (Optional: Depending on type of Product) </label>
                        <input type="text" class="form-control" id="weight" 
                            placeholder="Enter Weight ( ex. 1kg )" name="weight"    
                            @if(!empty($product['weight'])) value="{{ $product['weight'] }}" 
                            @else value="{{ old('weight') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="volume">Volume (Optional: Depending on type of Product) </label>
                        <input type="text" class="form-control" id="volume" 
                            placeholder="Enter Volume ( ex. 500ml )" name="volume"    
                            @if(!empty($product['volume'])) value="{{ $product['volume'] }}" 
                            @else value="{{ old('volume') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="color">Color (Optional: Depending on type of Product) </label>
                        <input type="text" class="form-control" id="color" 
                            placeholder="Enter Color ( ex. red )" name="color"    
                            @if(!empty($product['color'])) value="{{ $product['color'] }}" 
                            @else value="{{ old('color') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="size">Size (Optional: Depending on type of Product) </label>
                        <input type="text" class="form-control" id="size" 
                            placeholder="Enter Size ( ex. Large )" name="size"    
                            @if(!empty($product['size'])) value="{{ $product['size'] }}" 
                            @else value="{{ old('size') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="is_featured">Featured Item</label>
                        <input type="checkbox" name="is_featured" id="is_featured" value="Yes"
                         @if(!empty($product['is_featured']) && $product['is_featured']=="Yes") checked="" @endif>
                      </div>
                      {{-- <div class="form-group">
                        <label for="is_bestseller">Best Seller Item</label>
                        <input type="checkbox" name="is_bestseller" id="is_bestseller" value="Yes"
                         @if(!empty($product['is_bestseller']) && $product['is_bestseller']=="Yes") checked="" @endif>
                      </div> --}}
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>

@endsection