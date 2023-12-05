@extends('admin.layout.layout') 
@section('content')


<!DOCTYPE html>
<html>
<head>
<style>
body {
      /* margin: 50px; */
     border: 2px solid powderblue;
      
    }

    ul.a {
  list-style-type: circle;
 font-size: 20px;
    }

</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h2 class="font-weight-bold">Welcome {{ Auth::guard('admin')->user()->name}}</h2>
                        <h6 class="font-weight-normal mb-0">All systems are running smoothly!</h6>
                    </div>
                </div>
            </div>
    
     <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">To Start selling your products Please follow the Guide below !</h3><br><br>
                        <h4 class="font-weight-normal mb-0"> <ul class="a"> <li> STEP 1 :SUPPLY/UPDATE THE PERSONAL INFORMATION </li><br>
                        &bull;Vendor User Email<br> 
                        &bull;Name<br>
                        &bull;Address<br>
                        &bull;Mobile<br>
                        &bull;Photo<br> <br>

                        <li>STEP 2:SUPPLY/UPDATE SHOP INFORMATION</li><br>
                        &bull;Shop Name<br> 
                        &bull;Shop Address<br>
                        &bull;Shop Address Proof/Landmark<br>
                        &bull;Shop Address Image<br>
                        &bull;Shop Contact<br>
                        &bull;Shop Website<br>
                        &bull;Business licenses Number<br>
                        &bull;<br> <br>

                        
                        <li>STEP 3: PROCEED TO  PAYMENT INFORMATION or BANK DETAILS </li><br>
                        &bull;Account Holder Name<br> 
                        &bull;Bank Name<br>
                        &bull;Bank Account Numer (for payment transfer for installement or Online Payment)<br><br>

                        <li>STEP 4:SUPPLY YOUR SHOP</li><br>
                        &bull;Add Product Name<br> 
                        &bull;Add Product Price <br>
                        &bull;Product Photo<br>
                        &bull;Product Category<br>
                        &bull;Product Section<br>
                        &bull;Shop Address Image<br><br>

                        <li>STEP 5: ADD PRODUCT STATUS FOR STOCK MANAGEMENT </li><br>
                        &bull;Product Action for Stocks, product specification and details<br> 

                        <ul>
</h4>
                    
                    </div>
                </div>
            </div>

            
         
        </div>
        {{-- <div class="row">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card tale-bg">
                    <div class="card-people mt-auto">
                        <img src="images/dashboard/people.svg" alt="people">
                        <div class="weather-info">
                            <div class="d-flex">
                                <div>
                                    <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                                </div>
                                <div class="ml-2">
                                    <h4 class="location font-weight-normal">Cebu City</h4>
                                    <h6 class="font-weight-normal">Philippines</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Today’s Orders</p>
                                <p class="fs-30 mb-2">4006</p>
                                <p>10.00% (30 days)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Orders</p>
                                <p class="fs-30 mb-2">61344</p>
                                <p>22.00% (30 days)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Number of Meetings</p>
                                <p class="fs-30 mb-2">34040</p>
                                <p>2.00% (30 days)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-4">Number of Clients</p>
                                <p class="fs-30 mb-2">47033</p>
                                <p>0.22% (30 days)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   --}}
    </div>
    @include('admin.layout.footer')
</div>
@endsection