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
                  <form class="forms-sample" @if(empty($terms['id'])) action="{{ url('admin/add-edit-terms') }}"
                        @else action="{{ url('admin/add-edit-terms/'.$terms['id']) }}" @endif
                        method="post"enctype="multipart/form-data"> @csrf
                    <div class="form-group">
                        <label for="terms_name">Terms Name</label>
                        <input type="text" class="form-control" id="admin_name" 
                            placeholder="Enter Terms Name" name="terms_name"    
                            @if(!empty($terms['name'])) value="{{ $terms['name'] }}" 
                            @else value="{{ old('terms_name') }}" @endif>
                      </div>
                      {{-- description --}}
                      <div class="form-group">
                        <label for="terms_description">Terms Description</label>
                        <input type="text" class="form-control" id="admin_description" 
                            placeholder="Enter Terms Description" name="terms_description"    
                            @if(!empty($terms['description'])) value="{{ $terms['description'] }}" 
                            @else value="{{ old('terms_description') }}" @endif>
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