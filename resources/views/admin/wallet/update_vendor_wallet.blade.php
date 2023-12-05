@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <d class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Settings</h3>
                        <button class="btn btn-light"><a href="{{ url('admin/wallet-transactions') }}">Back </a> </button>
                    </div>
                </div>
            </div>
        </d iv>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Vendors Wallet Form</h4>
                  
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
                  <form class="forms-sample" action="{{ url('admin/update-vendor-wallet/'.$vendorDetails['vendor_id']) }}"
                        method="post" name="updateVendorWallet" id="updateVendorWallet"> @csrf
                      <input type="hidden" id="vendor_id" name="vendor_id" value="{{$vendorDetails['vendor_id']}}">
                    <div class="form-group">
                      <label>Vendor Name</label>
                      <input class="form-control" readonly="" value="{{ $vendorDetails['name']}}"> 
                    </div>
                    @if(!empty($vendorDetails['wallet_transactions']['proof_image']))
                        <div class="form-group">
                            <label for="proof_image">Proof of Payment</label>
                            <br>
                            <img style="width:200px;" src="{{ url('admin/images/gcashproofs/'.$vendorDetails['wallet_transactions']['proof_image'] ) }}"></img>
                          </div>
                      @else 
                        <div class="form-group">
                          <label for="vendor_image">Proof of Payment</label>
                          <br>
                          <img style="width:200px;" src="{{ url('admin/images/photos/noimage.gif') }}"></img>
                        </div>
                      @endif
                      <label>Wallet Balance : </label>
                      <input class="form-control" readonly="" value="{{ $vendorDetails['vendor_personal']['wallet_balance']}}"> <br>
                      <label for="amount">Enter Amount</label>
                      <input class="form-control" id="amount" 
                      placeholder="Enter Amount" name="amount" required="">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Add</button>
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