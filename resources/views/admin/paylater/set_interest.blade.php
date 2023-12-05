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
                                <h5 class="card-title">Update Installment Interest</h5> 
                                <div>
                                    @if(Auth::guard('admin')->user()->type=="vendor" )
                                    <form action="{{ url('admin/set-interest') }}" method="post" enctype="multipart/form-data"> @csrf
                                        <div class="form-group">
                                            <label>Current Installment Week & Interest</label>
                                            <input class="form-control" readonly="" value="{{ $shopDetails['installment_weeks'] }} weeks - {{$shopDetails['interest']}} % interest"> 
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="vendor_id" value="{{ $vendor ['id'] }}">
                                            <label>Installment Weeks</label>
                                            <select name="number_of_weeks" id="number_of_weeks" required="">
                                            <option value="" selected="">Select</option>
                                            @foreach($installments as $installment)
                                                <option value="{{ $installment['number_of_weeks'] }}">
                                                {{ $installment['number_of_weeks'] }} </option>
                                            @endforeach
                                            </select> <br><br>
                                            <label>Interest Rate</label>
                                            <select name="interest_rate" id="interest_rate" required="">
                                                <option value="" selected="">Select</option>
                                                @foreach($installments as $installment)
                                                    <option value="{{ $installment['interest_rate'] }}">
                                                    {{ $installment['interest_rate'] }} %</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <h5>NOTE! <i>Only the available list of weeks and interest rate are applicable.</i></h5>
                                        <button type="submit">Update</button>
                                    </form> @endif
                                </div>
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