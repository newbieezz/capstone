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
                        <a href="{{ url('/') }}">Home</a>
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
            @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success: </strong> {{ Session::get('success_message')}}
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
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error: </strong> <?php echo implode('', $errors->all('<div>:message</div>')); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-6" style="margin-bottom: 60px;">
                    <div class="login-wrapper">
                        <h2 class="account-h2 u-s-m-b-20" style="font-size: 20px;">Update Contact Details</h2>
                        <p id="account-error"></p>
                        <p id="account-success" style="color: green;"></p>
                        <form id="accountForm" action="javascript:;" method="post"> @csrf
                            <div class="u-s-m-b-30">
                                <label for="user-email">Email
                                </label>
                                <input  class="text-field" value="{{ Auth::user()->email }}" readonly="" disabled="" style="background-color: #e9e9e9">
                                <p id="account-email"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="user-name">Name
                                    <span class="astk">*</span>
                                </label>
                                <input  class="text-field" type="text" id="user-name" name="name" value="{{ Auth::user()->name }}">
                                <p id="account-name"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="user-address">Address
                                    <span class="astk">*</span>
                                </label>
                                <input  class="text-field" type="text" id="user-address" name="address" value="{{ Auth::user()->address }}">
                                <p id="account-address"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="user-mobile">Mobile
                                    <span class="astk">*</span>
                                </label>
                                <input  class="text-field" type="text" id="user-mobile" name="mobile" value="{{ Auth::user()->mobile }}">
                                <p id="account-mobile"></p>
                            </div>
                            <div class="m-b-45">
                                <button class="button button-outline-secondary w-100">Update</button>
                            </div> <div></div>
                        </form>
                    </div>
                </div>
                 <!-- update password -->
                 <div class="col-lg-6">
                    <div class="reg-wrapper">
                        <h2 class="account-h2 u-s-m-b-20" style="font-size: 20px;">Update Password</h2>
                        <p id="password-error"></p>
                        <p id="password-success" style="color: green;"></p>
                        <form id="passwordForm" action="javascript:;" method="post"> @csrf
                            <div class="u-s-m-b-30">
                                <label for="current-password">Current Password
                                </label>
                                <input type="password" id="current-password" name="current_password" class="text-field" placeholder="Current Password">
                                <p id="password-current_password"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="new-password">New Password
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="new-password" name="new_password" class="text-field" placeholder="New Password">
                                <p id="password-new_password"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="confirm-password">Confirm Password
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="confirm-password" name="confirm_password" class="text-field" placeholder="Confirm Password">
                                <p id="password-confirm_password"></p>
                            </div>
                            <div class="u-s-m-b-45">
                                <button class="button button-primary w-100">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- update password /- -->
            </div>
        </div>
    </div>
@endsection
