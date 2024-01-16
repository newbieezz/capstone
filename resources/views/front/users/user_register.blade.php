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
                        <a href="javascript:;">Account</a>
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
                <!-- Register -->
                <div class="col-lg-6">
                    
                    <div class="reg-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Register</h2>
                        <h6 class="account-h6 u-s-m-b-30">Registering for this site allows you to access your order status
                            and history.</h6>
                        <p id="register-success"></p>
                        <form id="registerForm" action="javascript:;" method="post"> @csrf
                            <div class="u-s-m-b-30">
                                <label for="username">First Name
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="user-name" name="name" class="text-field" placeholder="First Name">
                                <p id="register-name"></p>
                            </div>
                            {{-- last name --}}
                            <div class="u-s-m-b-30">
                                <label for="username">Last Name
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="user-lastname" name="lastname" class="text-field" placeholder="Last Name">
                                <p id="register-lastname"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="usermobile">Mobile
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="user-mobile" name="mobile" class="text-field" placeholder="11 digits mobile">
                                <p id="register-mobile"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="useremail">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="user-email" name="email" class="text-field" placeholder="User Email">
                                <p id="register-email"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="userpassword">Password
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="user-password" name="password" class="text-field" placeholder="User Password">
                                <p id="register-password"></p>
                                <p><i>( Must contain Big Letters, symbol, number and at least minimun of 8 characters long )</i></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <input type="checkbox" class="check-box" id="accept" name="accept">
                                <label class="label-text no-color" for="accept">I’ve read and accept the
                                    <a href="{{url('/terms')}}" class="u-c-brand">terms & conditions</a>
                                </label>
                                <p id="register-accept"></p>
                            </div>
                            <div class="u-s-m-b-45">
                                <button class="button button-primary w-100">Register</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
                <!-- Register /- -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-wrapper">
                            <h2 class="account-h2 u-s-m-b-20">Have your own micro Store?</h2>
                            <h6 class="account-h6 u-s-m-b-30">You are very welcome to be part of us! Click the link below to Create your Own Shop/Store Account.</h6>
                                <div class="m-b-45">
                                    <a href="{{url('vendor/login-register')}}"><button class="button button-outline-secondary w-100">Login</button></a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Account-Page /- -->
@endsection