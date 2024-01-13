
@extends('admin.layout.layout') 
@section('content')

        <div class="main-panel"> 
            <div class="content-wrapper"> 
                <div class="row">   
                    <div class="col-lg-12 grid-margin stretch-card"> 
                        <div class="card"> 
                            <div class="card-body"> 
                              <h4 class="card-title">Paylater</h4> 
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
                                        <th> Name </th> 
                                        <th> Lastname </th>
                                        <th> Guarantor Name </th> 
                                        <th> Guarantor Lastname </th>
                                        <th> Guarantor Credit Score </th>
                                        <th> Action </th>
                                    </tr>
                                  </thead> 
                                  <tbody> 
                                    @foreach ($pendings as $key => $pending)
                                      <tr> 
                                        <td> {{ $pending['users']['name'] }}  </td>
                                        <td> {{ $pending['users']['lastname'] }}  </td>
                                        <td> {{ $pending['garantor']['name'] }}  </td>
                                        <td> {{ $pending['garantor']['lastname'] }}  </td>
                                        <td> {{ $pending['garantor']['credit_score'] }}  </td>
                                        <td>    &nbsp;
                                          <a title="View" href="{{ url('admin/paylater/pending/'.$pending['id']) }}">
                                          <i style="font-size:30px" {{--class="mdi mdi-lead-pencil"--}}> </i>View</a> &nbsp; &nbsp;
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