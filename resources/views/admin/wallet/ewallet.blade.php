@extends('admin.layout.layout') 
@section('content')

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wallet</title>
<div class="main-panel"> 
    <div class="content-wrapper"> 
        <div class="row">   
            <div class="col-lg-12 grid-margin stretch-card"> 
                <div class="card"> 
                    <div class="card-body"> 
                      <h4 class="card-title">Wallet Management</h4>
                      @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                      @endif
                      <div class="table-responsive pt-3"> 
                        <h4>Balance: {{$vendorDetails['vendorPersonal']['wallet_balance']}}</h4> <br>
                        <form id="addFundsForm" action="{{url('admin/addFunds')}}" method="post"> @csrf
                            <h5><i>Note: Send GCash screenshot for Proof of Payment then wait for Admin to approve to transfer the amount to your Wallet.</i></h5> <br><br>
                            <div class="form-group">
                                <label for="transferAmount">Amount:</label>
                                <input type="number" id="transferAmount" name="transferAmount" step="0.01" required><br>
                            </div>
                            <div class="form-group">
                                <label for="proof_image">Proof of Payment</label>
                                <input type="file" class="form-control" id="proof_image" name="proof_image" required="" style="width: 40%">
                                @if(!empty(Auth::guard('admin')->user()->proof_image))
                                  <a target="_blank" href="{{ url('admin/images/proofs/'.$walletTransaction['proof_image']) }}"> View Current Image</a>
                                  <input type="hidden" name="current_proof" value="{{Auth::guard('admin')->user()->proof_image}}">
                                @endif
                            </div>
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>
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

@endsection 
