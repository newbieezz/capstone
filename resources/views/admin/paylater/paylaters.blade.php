@extends('admin.layout.layout') 
@section('content')

        <div class="main-panel"> 
            <div class="content-wrapper"> 
                <div class="row">   
                    <div class="col-lg-12 grid-margin stretch-card"> 
                        <div class="card"> 
                            <div class="card-body"> 
                              <h4 class="card-title">Buy Now Pay Later</h4> 
                                @if(Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success: </strong> {{ Session::get('success_message')}}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif
                                <a style="max-width: 150px; float: left; display:inline-block;" href="{{ url('admin/add-edit-product') }}" 
                                class="btn btn-block btn-primary">Add Product</a>
                                <div class="table-responsive pt-3"> 
                                <table id="products" class="table table-bordered"> 
                                <thead> 
                                  <tr>
                                      <th> User ID</th> 
                                      <th> Order ID </th> 
                                      <th> Weeks</th>  
                                      <th> Installment Amount</th> 
                                      <th> Interest </th>
                                      <th> Action </th> 
                                  </tr> 
                                </thead> 
                                <tbody> 
                                @foreach ($userDetails as $user)
                                  <tr> 
                                      <td> {{ $user['name']}}  </td>
                                      <td> {{ $paylaters['order_id']}}  </td> 
                                      <td> {{ $paylaters['installment_id']}}  </td> 
                                      <td> {{ $paylaters['amount']}}  </td> 
                                      <td> {{ $paylaters['interest_rate']}}  </td> 
                                      <td>    
                                        <a href="{{ url('admin/view-vendor-details/'.$paylater['id']) }}">
                                            <i style="font-size:30px" class="mdi mdi-file-document"> </i> </a>
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