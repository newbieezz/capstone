@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <d class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Vendor Details</h3>
                        <h6 class="font-weight-normal mb-0"><a href="{{ url('admin/admins/vendor') }}">Back to Vendors</a></h6>
                    </div>
                </div>
            </div>
        </d iv>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"> Personal Information </h4>
                    <div class="form-group">
                      <label>Email</label>
                      <input class="form-control" readonly="" @if(isset($vendorDetails['email'])) value="{{ $vendorDetails['email'] }}" @endif> 
                    </div>
                    <div class="form-group">
                        <label for="vendor_name">Name</label>
                        <input type="text" class="form-control"readonly=""  @if(isset($vendorDetails['name'])) value="{{ $vendorDetails['name'] }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="vendor_address">Address</label>
                        <input type="text" class="form-control" readonly="" @if(isset($vendorDetails['address'])) value="{{ $vendorDetails['address'] }}" @endif>
                      </div>
                    <div class="form-group">
                      <label for="vendor_mobile">Mobile</label>
                      <input type="text" class="form-control" readonly="" @if(isset($vendorDetails['mobile'])) value="{{ $vendorDetails['mobile'] }}" @endif>
                    </div>
                    @if(!empty($vendorDetails['image']))
                    <div class="form-group">
                        <label for="vendor_image">Photo</label>
                        <br>
                        <img style="width:200px;" src="{{ url('admin/images/photos/'.$vendorDetails['image']) }}"></img>
                      </div>
                    @endif
                  </form>
                </div>
              </div>
            </div> 
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> Shop Information </h4>
                      <div class="form-group">
                        <label>Shop Name</label>
                        <input class="form-control" readonly="" @if(isset($venBusiness['shop_name'])) value="{{ $venBusiness['shop_name']}}" @endif> 
                      </div>
                      <div class="form-group">
                          <label for="shop_address">Shop Address</label>
                          <input type="text" class="form-control"readonly="" @if(isset($venBusiness['shop_address'])) value="{{ $venBusiness['shop_address']}}" @endif>
                        </div>
                      <div class="form-group">
                        <label for="vendor_mobile">Shop Mobile</label>
                        <input type="text" class="form-control" readonly="" @if(isset($venBusiness['shop_mobile'])) value="{{ $venBusiness['shop_mobile']}}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="vendor_name">Shop Website</label>
                        <input type="text" class="form-control"readonly="" @if(isset($venBusiness['shop_website'])) value="{{ $venBusiness['shop_website']}}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="address_proof">Vendor Address Proof</label>
                        <input type="text" class="form-control" readonly="" @if(isset($venBusiness['address_proof'])) value="{{ $venBusiness['address_proof'] }}" @endif>
                      </div>
                      <div class="form-group">
                        <label for="business_license_number">Business License Number </label>
                        <input type="text" class="form-control" readonly="" @if(isset($venBusiness['business_license_number'])) value="{{  $venBusiness['business_license_number'] }}" @endif>
                      </div>
                      @if(!empty($venBusiness['address_proof_image']))
                        <div class="form-group">
                            <label for="vendor_image">Address Proof Image</label>
                            <br>
                            <img style="width:200px;" src="{{ url('admin/images/proofs/'.$venBusiness['address_proof_image'] ) }}"></img>
                          </div>
                      @else 
                        <div class="form-group">
                          <label for="vendor_image">Address Proof Image</label>
                          <br>
                          <img style="width:200px;" src="{{ url('admin/images/photos/noimage.gif') }}"></img>
                        </div>
                      @endif
                      @if(!empty($venBusiness['shop_image']))
                      <div class="form-group">
                          <label for="shop_image">Shop Image</label>
                          <br>
                          <img style="width:200px;" src="{{ url('admin/images/shops/'.$venBusiness['shop_image']) }}"></img>
                        </div>
                    @else 
                      <div class="form-group">
                        <label for="shop_image">Shop Image</label>
                        <br>
                        <img style="width:200px;" src="{{ url('admin/images/photos/noimage.gif') }}"></img>
                      </div>
                    @endif
                    </form>
                  </div>
                </div>
              </div>       
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> GCash Information </h4>
                      <div class="form-group">
                        <label>Account Holder Name</label>
                        <input class="form-control" readonly="" @if(isset($venBank['account_holder_name']))value="{{ $venBank['account_holder_name'] }}" @endif> 
                      </div>
                        <div class="form-group">
                          <label for="vendor_address">Account Number</label>
                          <input type="text" class="form-control" readonly="" @if(isset($venBank['account_number'] ))value="{{  $venBank['account_number'] }}" @endif>
                        </div>
                  </div>
                </div>
              </div> 
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> Wallet Information </h4>
                      <div class="form-group">
                        <label>Balance</label>
                        <input class="form-control" readonly="" @if(isset($vendorDetails['wallet_balance']))value="{{ $vendorDetails['wallet_balance'] }}" @endif> 
                      </div>
                  </div>
                </div>
              </div> 
        </div> 
    </div> 
    @include('admin.layout.footer')
</div>

@endsection