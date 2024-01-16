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
                        <a href="javascript:;">PayLater Application</a>
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
                    <h5><a href="{{ url('/') }}">Back</a></h5>
                    <div class="login-wrapper">
                        <h2 class="account-h2 u-s-m-b-20" style="font-size: 20px;">Update Application</h2>
                        <p id="account-error"></p>
                        <p id="account-success" style="color: green;"></p>
                        <form id="accountForm" action="{{url('paylater/update')}}" method="post"> @csrf
                            @foreach ($garantor as $value)
                            @foreach($userDetails as $user)
                            @if($value['user_id'] == $user['id'] && $value['garantor_id'] == Auth::user()->id) 
                            @if($value['appstatus'] == 'Pending' && $value['garantorstatus'] != 'Approved' && $value['garantorstatus'] != 'Rejected') 
                                <input type="hidden" id="userid" name="userid" value="{{$value['user_id']}}">
                                <input type="hidden" id="paylater_application_id" class="form-control" readonly="" value="{{ $value['id'] }}"> 
                                <div class="u-s-m-b-30">
                                    <label for="user-name">Applicant Name
                                    </label>
                                    <input  class="text-field" type="text" id="user-name" name="name" value=" {{$user['name']}}  {{$user['lastname']}}">
                                    <p id="account-name"></p>
                                </div>
                                <div class="u-s-m-b-30">
                                    <label for="user-address">Work
                                    </label>
                                    <input  class="text-field" type="text" id="user-address" name="address" value="{{ $value['work']  }}">
                                    <p id="account-address"></p>
                                </div>
                                <div class="u-s-m-b-30">
                                    <label for="user-mobile">Salary
                                    </label>
                                    <input  class="text-field" type="text" id="user-mobile" name="mobile" value="{{ $value['salary']  }}">
                                    <p id="account-mobile"></p>
                                </div>
                                <div class="u-s-m-b-30"> <label for="status">Select Response</label> &nbsp;
                                    <select name="status" id="status" required="">
                                        <option value="Approved" selected="">Approve</option>
                                        <option value="Rejected" selected="">Reject</option>
                                    </select>
                                </div> <br><br> @endif @endif
                            @endforeach
                            @endforeach

                            <div class="m-b-45">
                                <button type="submit"  class="btn btn-primary mr-2">Update</button>
                            </div> <div></div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection
