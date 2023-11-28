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
                                <div class="table-responsive pt-3"> 
                                <table id="products" class="table table-bordered"> 
                                <thead> 
                                  <tr>
                                      <th> User ID</th> 
                                      <th> Credit Limit </th> 
                                      <th> Weeks</th>
                                      <th> Action </th> 
                                  </tr> 
                                </thead> 
                                <tbody> 
                                  <tr> 
                                    @foreach ($credit_limits as $credit_limit )
                                      <td> {{ $credit_limit['current_credit_limit'] }} </td>
                                      
                                    @endforeach
                                </tbody> 
                                </table> 
                              </div> 
                            </div>  
                        </div>
                    </div> 
                </div> 

            </div>  
            <footer class="footer"> 
                <div class="d-sm-flex justify-content-center justify-content-sm-between"> <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021. Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span> <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span> 
                </div> 
            </footer> 
        </div>
    </body>
</html>
<script>
  object.onclick = function(){attributes};
</script>
@endsection