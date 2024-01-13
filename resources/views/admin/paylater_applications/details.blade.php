@extends('admin.layout.layout') 
@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="{{ url('front/js/jquery.min.js') }}"></script>
<script >
  $(function () {
    $("#approve").click(function () {
      $id = $('#paylater_application_id').val();
      console.log('approve', $id);
      $.ajax({
        contentType: "application/json",
        headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:'/admin/paylater/pending/'+$id+'/approved', //route(web.php)
        type:"post",
        success:function(resp){
          console.log('resp', resp)
          alert(resp.message);
          window.location=document.referrer;
        }, error:function(error){
          alert("Error");
        }
      });
    })
    $("#decline").click(function () {
      $id = $('#paylater_application_id').val();
      console.log('approve', $id);
      $.ajax({
        contentType: "application/json",
        headers:{
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:'/admin/paylater/pending/'+$id+'/declined', //route(web.php)
        type:"post",
        success:function(resp){
          console.log('resp', resp)
          alert(resp.message);
          window.location=document.referrer;
        }, error:function(error){
          alert("Error");
        }
      });
    }) 
  })
</script>
<div class="main-panel">
  <div class="content-wrapper">
      <div class="row">
          <div class="col-md-12 grid-margin">
              <div class="row">
                  <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                      <h3 class="font-weight-bold">Update Vendor Details</h3>
                  </div>
              </div>
          </div>
      </div>
      <!--Conditional statements -->
      <div class="row">
          <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Paylater Application </h4>
              
                <!--Validation Error Message -->
                  @if ($errors->any())
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
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
                @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success: </strong> {{ Session::get('success_message')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                @endif
                <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}"
                      method="post"enctype="multipart/form-data"> @csrf
                  <input type="hidden" id="paylater_application_id" class="form-control" readonly="" value="{{ $details['id'] }}"> 
                  <div class="form-group">
                    <label>Firstname</label>
                    <input class="form-control" readonly="" value="{{ $details['users']['name'] }}"> 
                  </div>
                  <div class="form-group">
                    <label>Firstname</label>
                    <input class="form-control" readonly="" value="{{ $details['users']['lastname'] }}"> 
                  </div>
                  <div class="form-group">
                    <label>Salary</label>
                    <input class="form-control" readonly="" value="{{ $details['salary'] }}"> 
                  </div>
                  <div class="form-group">
                    <label>Work</label>
                    <input class="form-control" readonly="" value="{{ $details['work'] }}"> 
                  </div>
                  <div class="form-group">
                    <a target="_blank" href="{{ url('front/images/users/validid/'.$details['valid_id']) }}"> View Government ID</a>
                    <input type="hidden" name="current_address_proof" @if(isset($details['valid_id'])) value="{{ $details['valid_id']}}" @endif>
                  </div>
                  <div class="form-group">
                    <a target="_blank" href="{{ url('front/images/users/selfie/'.$details['selfie']) }}"> View Selfie With ID</a>
                    <input type="hidden" name="current_address_proof" @if(isset($details['selfie'])) value="{{ $details['selfie']}}" @endif>
                  </div>
                  <div class="form-group">
                    <label>Guarantor Firstname</label>
                    <input class="form-control" readonly="" value="{{ $details['garantor']['name'] }}"> 
                  </div>
                  <div class="form-group">
                    <label>Guarantor Lastname</label>
                    <input class="form-control" readonly="" value="{{ $details['garantor']['lastname'] }}"> 
                  </div>
                  <div class="form-group">
                    <label>Credit Score</label>
                    <input class="form-control" readonly="" value="{{ $details['garantor']['credit_score'] }}"> 
                  </div>
                  <button type="button" id="approve" class="btn btn-primary mr-2">Approve</button>
                  <button type="button" id="decline" class="btn btn-danger mr-2">Decline</button>
                  <a href="{{ url()->previous() }}" target="_parent" id="back" class="btn btn-light">Back</a>
                </form>
              </div>
            </div>
          </div>
      </div>         
  </div> 
  </div> 
  <!-- content-wrapper ends -->
  <!-- partial:partials/_footer.html -->
  @include('admin.layout.footer')
  <!-- partial -->
</div>

@endsection