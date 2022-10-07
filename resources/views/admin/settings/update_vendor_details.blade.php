@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <d class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Update Vendor Details</h3>
                    </div>
                </div>
            </div>
        </d iv>
        <!--Conditional statements -->
        @if($slug=="personal")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Personal Information </h4>
                
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
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}"
                        method="post"enctype="multipart/form-data"> @csrf
                    <div class="form-group">
                      <label>Vendor Username/Email</label>
                      <input class="form-control" readonly="" value="{{ Auth::guard('admin')->user()->email }}"> 
                    </div>
                    <div class="form-group">
                        <label for="vendor_name">Name</label>
                        <input type="text" class="form-control" id="vendor_name" 
                            placeholder="Enter New Name" name="vendor_name" required="" value="{{ Auth::guard('admin')->user()->name }}">
                      </div>
                      <div class="form-group">
                        <label for="vendor_address">Address</label>
                        <input type="text" class="form-control" id="vendor_address" 
                            placeholder="Enter Address" name="vendor_address" required="" value="{{ $vendorDetails['address']}}">
                      </div>
                      <div class="form-group">
                        <label for="vendor_city">City</label>
                        <input type="text" class="form-control" id="vendor_city" 
                            placeholder="Enter City" name="vendor_city" required="" value="{{ $vendorDetails['city']}}">
                      </div>
                      <div class="form-group">
                        <label for="vendor_pincode">Pin Code</label>
                        <input type="text" class="form-control" id="vendor_pincode" maxlength="11" minlength="4"
                            placeholder="Enter Pin Code" name="vendor_pincode" required="" value="{{ $vendorDetails['pincode']}}">
                      </div>
                    <div class="form-group">
                      <label for="vendor_mobile">Mobile</label>
                      <input type="text" class="form-control" id="vendor_mobile" maxlength="11" minlength="11"
                      placeholder="Enter 11 Digit Mobile Number" name="vendor_mobile" required="" value="{{ $vendorDetails['mobile'] }}">
                    </div>
                    <div class="form-group">
                        <label for="vendor_image">Photo</label>
                        <input type="file" class="form-control" id="vendor_image" name="vendor_image" required="">
                        @if(!empty(Auth::guard('admin')->user()->image))
                          <a target="_blank" href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}"> View Current Image</a>
                          <input type="hidden" name="current_vendor_image" value="{{Auth::guard('admin')->user()->image}}">
                        @endif
                      </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>        
        </div> 
        @elseif($slug=="business")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Shop Information </h4>
                
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
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}"
                        method="post"enctype="multipart/form-data"> @csrf
                    <div class="form-group">
                      <label>Vendor Username/Email</label>
                      <input class="form-control" readonly="" value="{{ Auth::guard('admin')->user()->email }}"> 
                    </div>
                    <div class="form-group">
                        <label for="shop_name">Shop Name</label>
                        <input type="text" class="form-control" id="shop_name" 
                            placeholder="Enter Shop Name" name="shop_name" required="" value="{{ $vendorDetails['shop_name']}}">
                      </div>
                      <div class="form-group">
                        <label for="shop_address">Shop Address</label>
                        <input type="text" class="form-control" id="shop_address" 
                            placeholder="Enter Shop Address" name="shop_address" required="" value="{{ $vendorDetails['shop_address']}}">
                      </div>
                      <div class="form-group">
                        <label for="shop_city">Shop City</label>
                        <input type="text" class="form-control" id="shop_city" 
                            placeholder="Enter Shop City" name="shop_city" required="" value="{{ $vendorDetails['shop_city']}}">
                      </div>
                      <div class="form-group">
                        <label for="shop_pincode">Shop Pin Code</label>
                        <input type="text" class="form-control" id="shop_pincode" maxlength="11" minlength="4"
                            placeholder="Enter Shop Pin Code" name="shop_pincode" required="" value="{{ $vendorDetails['shop_pincode']}}">
                      </div>
                    <div class="form-group">
                      <label for="shop_mobile">Mobile</label>
                      <input type="text" class="form-control" id="shop_mobile" maxlength="11" minlength="11"
                      placeholder="Enter 11 Digit Mobile Number" name="shop_mobile" required="" value="{{ $vendorDetails['shop_mobile'] }}">
                    </div>
                    <div class="form-group">
                        <label for="shop_website">Shop Website</label>
                        <input type="text" class="form-control" id="shop_website" 
                            placeholder="Enter Shop Website" name="shop_website" required="" value="{{ $vendorDetails['shop_website']}}">
                      </div>
                      <div class="form-group">
                        <label for="business_license_number">Business License Number</label>
                        <input type="text" class="form-control" id="business_license_number" 
                            placeholder="Enter Business License Number" name="business_license_number" required="" value="{{ $vendorDetails['business_license_number']}}">
                      </div>
                      <div class="form-group">
                        <label for="address_proof">Address Proof</label>
                        <select class="form-group" name="address_proof" id="address_proof">
                            <option value="Passport" @if($vendorDetails['address_proof']=="Passport") selected @endif>Passport</option>
                            <option value="National ID" @if($vendorDetails['address_proof']=="National ID") selected @endif>National ID</option>
                            <option value="UMID" @if($vendorDetails['address_proof']=="UMID Card") selected @endif>UMID Card</option>
                            <option value="Driver's License" @if($vendorDetails['address_proof']=="Driver's License") selected @endif>Driver's License</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="address_proof_image">Address Proof Image</label>
                        <input type="file" class="form-control" id="address_proof_image" name="address_proof_image" required="">
                        @if(!empty($vendorDetails['address_proof_image']))
                          <a target="_blank" href="{{ url('admin/images/proofs/'.$vendorDetails['address_proof_image']) }}"> View Current Image</a>
                          <input type="hidden" name="current_address_proof" value="{{$vendorDetails['address_proof_image']}}">
                        @endif
                        
                      </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>        
        </div> 
       @elseif($slug=="bank")
       <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Update Bank Information </h4>
            
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
              <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank') }}"
                    method="post"enctype="multipart/form-data"> @csrf
                <div class="form-group">
                  <label>Vendor Username/Email</label>
                  <input class="form-control" readonly="" value="{{ Auth::guard('admin')->user()->email }}"> 
                </div>
                <div class="form-group">
                    <label for="account_holder_name">Account Holder Name</label>
                    <input type="text" class="form-control" id="account_holder_name" 
                        placeholder="Enter Shop Name" name="account_holder_name" required="" value="{{ $vendorDetails['account_holder_name']}}">
                  </div>
                  <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" class="form-control" id="bank_name" 
                        placeholder="Enter Shop Address" name="bank_name" required="" value="{{ $vendorDetails['bank_name']}}">
                  </div>
                  <div class="form-group">
                    <label for="account_number">Account Number</label>
                    <input type="text" class="form-control" id="account_number" 
                        placeholder="Enter Shop City" name="account_number" required="" value="{{ $vendorDetails['account_number']}}">
                  </div>
                  <div class="form-group">
                    <label for="bank_swift_code">Bank SWIFT Code</label>
                    <input type="text" class="form-control" id="bank_swift_code" maxlength="11" minlength="8"
                        placeholder="Enter Shop Country" name="bank_swift_code" required="" value="{{ $vendorDetails['bank_swift_code']}}">
                  </div>

                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button class="btn btn-light">Cancel</button>
              </form>
            </div>
          </div>
        </div>        
    </div> 
        @endif
    </div> 
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>

@endsection