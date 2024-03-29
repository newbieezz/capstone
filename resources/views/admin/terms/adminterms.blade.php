@extends('admin.layout.layout') 
@section('content')

        <div class="main-panel"> 
            <div class="content-wrapper"> 
                <div class="row">   
                    <div class="col-lg-12 grid-margin stretch-card"> 
                        <div class="card"> 
                            <div class="card-body"> 
                              <h4 class="card-title">Terms And Conditions</h4> 
                              @if(Session::has('success_message'))
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                                  <strong>Success: </strong> {{ Session::get('success_message')}}
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              @endif
                              <a style="max-width: 150px; float: left; display:inline-block;" href="{{ url('admin/add-edit-terms') }}" 
                                class="btn btn-block btn-primary">Add Terms</a>
                              <div class="table-responsive pt-3"> 
                              <table id="terms" class="table table-bordered"> 
                              <thead> 
                                <tr> 
                                    <th> ID </th> 
                                    <th> Name of Terms</th> 
                                    <th> Descriptions </th> 
                                    <th> Action </th> 
                                </tr> 
                              </thead> 
                              @foreach ($terms as $terms)
                                <tr> 
                                     <td> {{ $terms['id']}}  </td> 
                                     <td> {{ $terms['name']}}  </td> 
                                     <td> {{ $terms['description']}} </td>    &nbsp;
                                            {{-- <a class="updateTermstatus" id="terms-{{$terms['id']}}" terms_id="{{$terms['id']}}"
                                                href="javascript:void(0)"> 
                                            <i style="font-size:30px" class="mdi mdi-check-circle" status="Active"> </i> </a>
                                          @else  &nbsp;
                                          <a class="updateTermsStatus" id="terms-{{$terms['id']}}" terms_id="{{$terms['id']}}"
                                                href="javascript:void(0)"> 
                                            <i style="font-size:30px" class="mdi mdi-check-circle-outline" status="Inactive"> </i> </a>
                                          @endif --}}
                                    </td>                      
                                     <td>    &nbsp;
                                         <a href="{{ url('admin/add-edit-terms/'.$terms['id']) }}">
                                         <i style="font-size:30px" class="mdi mdi-lead-pencil"> </i> </a> &nbsp; &nbsp;  &nbsp;
                                         <a href="javascript:void(0)" class="confirmDelete" module="terms" moduleid="{{$terms['id']}}">
                                         <i style="font-size:30px" class="mdi mdi-delete-forever"> </i> </a>
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

@endsection 