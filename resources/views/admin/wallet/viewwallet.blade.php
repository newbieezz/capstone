@extends('admin.layout.layout') 
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">View Wallet Transactions</h4>
                  <h5>Admin Balance : {{ $admin['wallet_balance'] }}</h5>
                  <div class="table-responsive pt-3"> 
                    <table class="table table-bordered"> 
                    <thead> @csrf
                      <tr> 
                          <th> Date Created</th> 
                          <th> Vendor ID </th> 
                          <th> Type </th> 
                          <th> Amount </th> 
                          <th> Reference </th> 
                          <th> Proof</th> 
                          <th> Status </th> 
                          <th> Action </th> 
                      </tr> 
                    </thead> 
                    <tbody> 
                    @foreach ($walletTransactions as $wallet)
                      <tr> 
                           <td> {{ $wallet['created_at']}}  </td> 
                           <td> {{ $wallet['admin_id']}}  </td> 
                           <td> {{ $wallet['transaction_type']}}  </td> 
                           <td> {{ $wallet['amount']}}  </td> 
                           <td> {{ $wallet['reference']}}  </td>
                           <td> @if($wallet['proof_image'] != "")
                                   <img src="{{ asset('admin/images/gcashproofs/'.$wallet['proof_image']) }}" />
                                @else
                                   <img src="{{ asset('admin/images/photos/noimage.gif') }}" />
                                @endif
                           </td> 
                           <td> {{ $wallet['status'] }} </td>                      
                           <td> 
                                  <a href="{{ url('admin/update-vendor-wallet/'.$wallet['admin_id']) }}">
                                      <i style="font-size:30px" class="mdi mdi-file-document" title="Update"> </i> </a>
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
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>

@endsection