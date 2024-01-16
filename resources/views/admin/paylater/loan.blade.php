@extends('admin.layout.layout') 
@section('content')

        <div class="main-panel"> 
            <div class="content-wrapper"> 
                <div class="row">   
                    <div class="col-lg-12 grid-margin stretch-card"> 
                        <div class="card"> 
                            <div class="card-body"> 
                              <h4 class="card-title">List of Loans</h4>
                              <div class="table-responsive pt-3"> 
                              <table id="orders" class="table table-bordered"> 
                              <thead> 
                                <tr> 
                                    <th> Date Created </th> 
                                    <th> User ID</th> 
                                    <th> Due Date </th> 
                                    <th> Amount </th> 
                                    <th> Interest Rate </th> 
                                    <th> Status </th> 
                                    {{-- <th> Action </th>  --}}
                                </tr> 
                              </thead> 
                              <tbody> 
                            @foreach ($loans as $loan)
                                <tr> 
                                     <td> {{ date('Y-m-d', strtotime($loan['created_at'])) }} </td> 
                                     <td> {{ $loan['user_id']}}  </td> 
                                     <td> {{ $loan['due_date']}}  </td> 
                                     <td>₱ {{ $loan['amount'] }} </td>
                                     <td> {{ $loan['interest_rate'] }} %</td>
                                     <td> @if($loan['is_paid']==0) Not Paid
                                         @else Paid @endif
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