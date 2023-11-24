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
                      <div class="table-responsive pt-3"> 
                        <h4>Balance: </h4> <br>
                        <form id="addFundsForm">
                            <label for="amount">Add Funds to Wallet:</label>
                            <input type="number" id="amount" name="amount" step="0.01" required>
                            <button type="submit">Add Funds</button>
                        </form>
                    
                        <form id="transferToAdminForm">
                            <label for="transferAmount">Transfer to Admin:</label>
                            <input type="number" id="transferAmount" name="transferAmount" step="0.01" required>
                            <button type="submit">Transfer to Admin</button>
                        </form>
                    
                        <form id="deductInterestForm">
                            <label for="deductAmount">Deduct 5% Interest:</label>
                            <input type="number" id="deductAmount" name="deductAmount" step="0.01" required>
                            <button type="submit">Deduct Interest</button>
                        </form>
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

@endsection 
