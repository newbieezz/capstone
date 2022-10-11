@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <d class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Settings</h3>
                    </div>
                </div>
            </div>
        </d iv>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Admin Details Form</h4>
                
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
                  <form class="forms-sample" action="{{ url('admin/update-admin-details') }}"
                        method="post"enctype="multipart/form-data"> @csrf
                    <div class="form-group">
                      <label>Admin Username/Email</label>
                      <input class="form-control" readonly="" value="{{ Auth::guard('admin')->user()->email }}"> 
                    </div>
                    <div class="form-group">
                      <label>Admin Type</label>
                      <input class="form-control" readonly="" value="{{  Auth::guard('admin')->user()->type}}">
                    </div>
                    <div class="form-group">
                        <label for="admin_name">Name</label>
                        <input type="text" class="form-control" id="admin_name" 
                            placeholder="Enter New Name" name="admin_name" required="" value="{{ Auth::guard('admin')->user()->name }}">
                      </div>
                    <div class="form-group">
                      <label for="admin_mobile">Mobile</label>
                      <input type="text" class="form-control" id="admin_mobile" maxlength="11" minlength="11"
                      placeholder="Enter 11 Digit Mobile Number" name="admin_mobile" required="" value="{{ Auth::guard('admin')->user()->mobile }}">
                    </div>
                    <div class="form-group">
                        <label for="admin_image">Admin Photo</label>
                        <input type="file" class="form-control" id="admin_image" name="admin_image" required="">
                        @if(!empty(Auth::guard('admin')->user()->image))
                          <a target="_blank" href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}"> View Current Image</a>
                          <input type="hidden" name="current_admin_image" value="{{Auth::guard('admin')->user()->image}}">
                        @endif
                      </div>
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