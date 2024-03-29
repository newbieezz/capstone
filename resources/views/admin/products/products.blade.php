
@extends('admin.layout.layout') 
@section('content')

        <div class="main-panel"> 
            <div class="content-wrapper"> 
                <div class="row">   
                    <div class="col-lg-12 grid-margin stretch-card"> 
                        <div class="card"> 
                            <div class="card-body"> 
                              <h4 class="card-title">Products</h4> 
                                @if(Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success: </strong> {{ Session::get('success_message')}}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif
                                @if ($adminType == "vendor")
                                    <a style="max-width: 150px; float: left; display:inline-block;" href="{{ url('admin/add-edit-product') }}" 
                                    class="btn btn-block btn-primary">Add Product</a>
                                @endif
                                
                                <div class="table-responsive pt-3"> 
                                <table id="products" class="table table-bordered"> 
                                <thead> 
                                  <tr>
                                      <th> Date Created </th> 
                                      <th> Name </th> 
                                      <th> Code </th>
                                      <th> Measurement </th>
                                      <th> Stocks</th>
                                      <th> Price </th>  
                                      <th> Photo </th>   
                                      <th> Status </th> 
                                      <th> Action </th> 
                                  </tr> 
                                </thead> 
                                <tbody> 
                                @foreach ($products as $product)
                                  <tr> 
                                      <td> {{ $product['created_at'] }}  </td>
                                      <td> {{ $product['product_name']}}  </td>
                                      <td> {{$product['product_code']}} </td> 
                                      <td> @if(!empty($product['size']))
                                              {{$product['size']}} 
                                            @elseif(!empty($product['weight']))
                                              {{$product['weight']}} 
                                            @elseif(!empty($product['volume']))
                                              {{$product['volume']}} 
                                            @elseif(!empty($product['color']))
                                              {{$product['color']}} 
                                           @endif
                                      </td>
                                      <td> {{$product['stock_quantity']}}  </td>
                                      <td> {{ $product['selling_price']}}  </td>  
                                      <td> @if(!empty($product['product_image']))
                                              <img src="{{ asset('front/images/product_images/small/'.$product['product_image']) }}">
                                            @else
                                            <img src="{{ asset('front/images/product_images/small/noimage.png') }}">
                                            @endif
                                      </td>
                                      <td> @if($product['status']==1)   &nbsp;
                                              <a title="Enabled" class="updateProductStatus" id="product-{{$product['id']}}" product_id="{{$product['id']}}"
                                                  href="javascript:void(0)">  
                                              <i style="font-size:30px" class="mdi mdi-check-circle" status="Active"> </i> </a>
                                            @else  &nbsp;
                                            <a title="Disabled" class="updateProductStatus" id="product-{{$product['id']}}" product_id="{{$product['id']}}"
                                                  href="javascript:void(0)"> 
                                              <i style="font-size:30px" class="mdi mdi-check-circle-outline" status="Inactive"> </i> </a>
                                            @endif
                                      </td>                      
                                      <td>    &nbsp;
                                          <a title="Edit Product" href="{{ url('admin/add-edit-product/'.$product['id']) }}">
                                          <i style="font-size:30px" {{--class="mdi mdi-lead-pencil"--}}> </i>Edit</a> &nbsp; &nbsp; 
                                          <a title="Add Multiple Image" href="{{ url('admin/add-images/'.$product['id']) }}">
                                          <i style="font-size:30px" {{--class="mdi mdi-library-plus"--}}> </i> Image</a> &nbsp; &nbsp;
                                              <a title="Delete" href="javascript:void(0)" class="confirmDelete" module="product" moduleid="{{$product['id']}}">
                                              <i style="font-size:30px" {{--class="mdi mdi-delete-forever"--}}> </i> Delete</a>
                                      </td>  
                                    </tr> 
                                  @endforeach
                                </tbody> 
                                </table> 
                              </div> 
                            </div>  
                        </div> 
                    </div> 
                </div> 

            </div> <!-- content-wrapper ends --> <!-- partial:../../partials/_footer.html --> 
            <footer class="footer"> 
                <div class="d-sm-flex justify-content-center justify-content-sm-between"> <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021. Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span> <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span> 
                </div> 
            </footer> <!-- partial --> 
        </div>
    </body>
</html>
<script>
  object.onclick = function(){attributes};
</script>
@endsection