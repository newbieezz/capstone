<?php 
    use App\Models\Paylater;
?>
@extends('front.layout.layout')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>PsMart-PayLater</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="javascript:;">Pay Later Application</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="page-cart u-s-p-t-80">
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
                <h2 class="account-h2 u-s-m-b-20">Fill up all information needed  </h2>
                    <p id="emerCon-error"></p>
                    <div class="u-s-m-b-30">
                        <label >Search Guarantors Name
                            <span class="astk">*</span>
                            </label>
                            @include('front.pay_later.searchg')
                    </div>
            <form action="{{url('pay-later-application')}}" method="post" enctype="multipart/form-data"> @csrf
                <input type="hidden" name="appstatus" value="1" id="appstatus">
                        <div class="u-s-m-b-30">
                            <label for="valid_id"> Government Valid ID
                                <span class="astk">*</span>
                            </label>
                            <input name="valid_id" id="valid_id" type="file" class="form-control">
                            <p id="emerCon-valid_id"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="selfie"> Selfie with ID 
                                <span class="astk">*</span>
                            </label>
                                <input type="file" class="form-control" id="selfie" name="selfie">
                                <p id="emerCon-selfie"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label >Work
                                <span class="astk">*</span>
                            </label>
                            <input type="mobile" id="users-sof" name="sof" class="text-field" placeholder="Job Position">
                            <p id="emerCon-sof"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label >Monthly Salary/Income
                                <span class="astk">*</span>
                            </label>
                            <input type="mobile" id="users-income" name="income" class="text-field" placeholder="Monthly Salary/Income">
                            <p id="emerCon-income"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <input type="checkbox" class="check-box" id="accept" name="accept">
                            <label class="label-text no-color" for="accept">I’ve read and accept the
                                <a href="terms-and-conditions.html" class="u-c-brand">terms & conditions</a>
                            </label>
                            <p id="accept"></p>
                        </div>
                 <div class="u-s-m-b-45">
                    <button class="button button-primary w-100" type="submit">Submit</button>
                </div> 
            </form>
        </div>
    </div> <br><br><br><br><br><br><br><br><br>
    <script type="text/javascript">
        $('.date').datepicker({  
            format: '{{ config('app.date_format_js') }}'
         });  
        //  $( function(){
        //     $(".datepicker").datepicker();
        //  });
    </script> 
@endsection