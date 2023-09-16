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
                <h2 class="account-h2 u-s-m-b-20">Emergency Contact</h2>
                <h6 class="account-h6 u-s-m-b-30">Please be mindful and truthful!</h6>
                    <p id="emerCon-error"></p>
            <form action="{{url('pay-later-application')}}" method="post"> @csrf
                <input type="hidden" name="appstatus" value="1" id="appstatus">
                        <div class="u-s-m-b-30">
                            <label >Name
                                <span class="astk">*</span>
                             </label>
                            <input  name="emerCon_name" id="emerCon-name" class="text-field" placeholder="Complete Name">
                            <p id="emerCon-name"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label >Phone Number
                                <span class="astk">*</span>
                            </label>
                            <input name="emerCon_mobile" id="emerCon-mobile"  class="text-field" placeholder="Phone Number">
                            <p id="emerCon-mobile"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label >Relationship
                                <span class="astk">*</span>
                            </label>
                            <input name="relationship" id="emerCon-rs"  class="text-field" placeholder="Relationship">
                            <p id="emerCon-rs"></p>
                        </div>
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
                        {{-- <div class="form-group">
                            <label for="valid_id">Goverment ID upload</label>
                            <input type="file" class="form-control" id="valid_id" name="valid_id" >
                            <p id="emerCon-valid_id"></p>
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="selfie">Selfie with ID</label>
                            <input type="file" class="form-control" id="selfie" name="selfie" >
                            <p id="emerCon-selfie"></p>
                        </div> --}}
                    <h2 class="account-h2 u-s-m-b-20">Additional Informations</h2>
                    <h6 class="account-h6 u-s-m-b-30">Upload your Government ID and additional information needed.</h6>
                    <p id="emerCon-success"></p>
                        <div class="u-s-m-b-30">
                            <label >Date of Birth
                                <span class="astk">*</span>
                            </label>
                            <input class="date form-control datepicker" type="text" id="dob" name="dob">
                            <p id="emerCon-dob"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label >Place of Birth
                                <span class="astk">*</span>
                            </label>
                            <input type="text" id="users-pob" name="pob" class="text-field" placeholder="Place of Birth">
                            <p id="emerCon-pob"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label >Employment/Source of Fund
                                <span class="astk">*</span>
                            </label>
                            <input type="mobile" id="users-sof" name="sof" class="text-field" placeholder="Job Position">
                            <p id="emerCon-sof"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label >Company Name
                                <span class="astk">*</span>
                            </label>
                            <input type="mobile" id="users-compname" name="comp_name" class="text-field" placeholder="Company Name">
                            <p id="emerCon-comp_name"></p>
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