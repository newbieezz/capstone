@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Account</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="account.html">Account</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Account-Page -->
    <div class="page-account u-s-p-t-80">
        <div class="container">
           
            <div class="row">
                <!-- Login -->
                <div class="col-lg-6">
                    <div class="login-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Login</h2>
                        <h6 class="account-h6 u-s-m-b-30">Welcome back! Sign in to your account.</h6>
                        <form action="{{ url('admin/login') }}" method="post"> @csrf
                            <div class="u-s-m-b-30">
                                <label for="vendor-email">Email
                                    <span class="astk">*</span>
                                </label>
                                <input  type="email" name="email" id="vendor-email" class="text-field"
                                    placeholder="Email">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendor-password">Password
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" name="password" id="vendor-password"  class="text-field" placeholder="Password">
                            </div>
                            <div class="m-b-45">
                                <button class="button button-outline-secondary w-100">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Login /- -->
               
            </div>
        </div>
    </div>
    <!-- Account-Page /- -->
@endsection
