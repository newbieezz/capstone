@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <d class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Products</h3>
                    </div>
                </div>
            </div>
        </d iv>
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
                  <div class="form-group">
                    <label for="category_id">Select Category</label>
                    <select name="category_id" id="category_id" class="form-control" style="color: black">
                        <option value="">Select</option>
                        @foreach($categories as $section) <!--SECTIONS -->
                            <optgroup label="{{ $section['name'] }}"></optgroup>
                            @foreach($section['categories'] as $category) <!--CATEGORY -->
                            <option value="{{ $category['id'] }}">&nbsp;&nbsp;&raquo;&nbsp;{{ $category['category_name'] }}</option>
                            @endforeach
                            @foreach($category['subcategories'] as $subcategory) <!-- SUBCATEGORY -->
                            <option value="{{ $subcategory['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{ $category['category_name'] }}</option>
                            @endforeach
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="brand_id">Select Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control" style="color: black">
                        <option value="">Select</option>
                        @foreach($brands as $brand) <!--BRANDS -->
                            <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
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
                        <label for="product_code">Product Code</label>
                        <input type="text" class="form-control" id="product_code" 
                            placeholder="Enter Product Code" name="product_code"    
                            @if(!empty($product['product_code'])) value="{{ $product['product_code'] }}" 
                            @else value="{{ old('product_code') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="product_price">Product Price</label>
                        <input type="text" class="form-control" id="product_price" 
                            placeholder="Enter Product Price" name="product_price"    
                            @if(!empty($product['product_price'])) value="{{ $product['product_price'] }}" 
                            @else value="{{ old('product_price') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="product_discount">Product Discount (%)</label>
                        <input type="text" class="form-control" id="product_discount" 
                            placeholder="Enter product Discount" name="product_discount"    
                            @if(!empty($product['product_discount'])) value="{{ $product['product_discount'] }}" 
                            @else value="{{ old('product_discount') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="product_image">Product Photo</label>
                        <input type="file" class="form-control" id="product_image" name="product_image" >
                        @if(!empty($product['product_image']))
                        <a target="_blank" href="{{ url('front/images/product_images/'.$product['product_image']) }}">View Image</a> &nbsp; &nbsp; | &nbsp; &nbsp;
                          <a href="javascript:void(0)" class="confirmDelete" module="product-image" 
                          moduleid="{{$product['id']}}">Delete Image</a>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="product_video">Product Video</label>
                        <input type="file" class="form-control" id="product_video" name="product_video" >
                        @if(!empty($product['product_video']))
                        <a target="_blank" href="{{ url('front/videos/product_videos/'.$product['product_video']) }}">View Image</a> &nbsp; &nbsp; | &nbsp; &nbsp;
                          <a href="javascript:void(0)" class="confirmDelete" module="product-video" 
                          moduleid="{{$product['id']}}">Delete Video</a>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="description">Product Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" >
                        </textarea>
                      </div>
                      <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" 
                            placeholder="Enter Meta Title" name="meta_title"    
                            @if(!empty($product['meta_title'])) value="{{ $product['meta_title'] }}" 
                            @else value="{{ old('meta_title') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <input type="text" class="form-control" id="meta_description" 
                            placeholder="Enter Meta Description" name="meta_description"    
                            @if(!empty($product['meta_description'])) value="{{ $product['meta_description'] }}" 
                            @else value="{{ old('meta_description') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" class="form-control" id="meta_keywords" 
                            placeholder="Enter Meta Keywords" name="meta_keywords"    
                            @if(!empty($product['meta_keywords'])) value="{{ $product['meta_keywords'] }}" 
                            @else value="{{ old('meta_keywords') }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="is_featured">Featured Item</label>
                        <input type="checkbox" name="is_featured" id="is_featured" value="Yes"
                         @if(!empty($product['is_featured']) && $product['is_featured']=="Yes") checked="" @endif>
                      </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
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