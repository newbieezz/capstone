<?php 
    use App\Models\Paylater;
?>
@extends('front.layout.layout')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="{{ url('front/js/jquery.min.js') }}"></script>
    <script >
        $(function() {
            let guarantors = []
            var $selectAll = $( "input:radio[name=payment_gateway]" );
            var paylater_details = $( "#paylater_details" );
            paylater_details.hide()
            $selectAll.on( "change", function() {
                if ($(this).val() == 'Paylater') {
                    paylater_details.show()
                    $('#guarantor_name').prop('required',true)
                    $('#valid_id').prop('required',true)
                    $('#work').prop('required',true)
                    $('#salary').prop('required',true)
                } else {
                    paylater_details.hide()
                    $('#guarantor_name').prop('required',false)
                    $('#valid_id').prop('required',false)
                    $('#work').prop('required',false)
                    $('#salary').prop('required',false)
                }
                // // or
                // alert( "selectAll: " + $(this).val() );

            });

            // var $selected_guarantor = $( "input:radio[name=selected_guarantor]" );
            // $selected_guarantor.on( "change", function() {
            //     // // or
            //     alert( "selected_guarantor: " + $(this).val() );

            // });

            $('#show_guarantor_modal').click(function () {
                $('#guarantor_no_data').show()
            })

            $('#get_selected_guarantor').click(function () {
                const guarantorId = $('input[name="selected_guarantor"]:checked').val()
                const index = guarantors.findIndex((element) => element.id == guarantorId)
                $('#guarantor_fullname').val(guarantors[index].name + ' ' + guarantors[index].lastname + ' - ' + guarantors[index].credit_score)
                $('#garantor_lname').val(guarantors[index].lastname)
                $('#garantor_id').val(guarantors[index].id)
                $('#garantor_name').val(guarantors[index].name)
            })

            $('#search_guarantor').click(function () {
                const name = $('#search_guarantor_name').val()
                if (name) {
                    $.ajax({
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        //send the address id in the data
                        data:{name: name},
                        url:'/search-guarantor', //route(web.php)
                        type:"get",
                        success:function(resp){
                            console.log('resp', resp)
                            $('#guarantor_no_data').hide()
                            guarantors = resp.guarantors
                            if (!guarantors.length) {
                                $('#guarantor_table_body tr').remove()
                                $('#guarantor_no_data').show()
                            }
                            resp.guarantors.forEach(element => {
                                $('#guarantor_table_body').append(
                                    "<tr><td class='text-center'><input type='radio' name='selected_guarantor' id='selected_guarantor' value='"+ element.id +"'></td>" +
                                    "<td>" + element.name + "</td>" +
                                    "<td>" + element.lastname + "</td>" +
                                    "<td>" + element.credit_score + "</td><tr>"
                                )
                            });
                        }, error:function(){
                            alert("Error");
                        }
                    });
                }
            })
        });

    </script>
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
            <form action="{{url('pay-later-application/'.$vendorid)}}" method="post" enctype="multipart/form-data"> @csrf
                <input type="hidden" name="appstatus" value="Pending" id="appstatus">
                <input type="hidden" name="vendorid" value="{{$vendorid}}" id="vendorid">

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Search Guarantor</h5>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Input guarantor name" aria-label="Input guarantor name" id="search_guarantor_name" aria-describedby="button-addon2">
                                            <div class="input-group-append">
                                                <button class="button button-outline-secondary" type="button" id="search_guarantor">Search</button>
                                            </div>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                <th scope="col">Select</th>
                                                <th scope="col">Firstname</th>
                                                <th scope="col">Lastname</th>
                                                <th scope="col">Credit Score</th>
                                                </tr>
                                            </thead>
                                            <tbody id="guarantor_table_body">
                                            </tbody>
                                            <tbody id="guarantor_no_data">
                                                <tr class="text-center">
                                                    <td colspan="4"> No Data </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="get_selected_guarantor">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="u-s-m-b-30">
                            <label for="guarantor_name"> Guarantor
                                <span class="astk">*</span>
                            </label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control-plaintext" readonly aria-describedby="button-addon2" name="guarantor_fullname" id="guarantor_fullname">
                                <div class="input-group-append">
                                    <button class="button button-outline-secondary" type="button" id="show_guarantor_modal" data-toggle="modal" data-target="#exampleModalCenter">Click Here</button>
                                </div>
                            </div>
                            <input type="hidden" name="garantor_name" value=""    id="garantor_name">
                            <input type="hidden" name="garantor_lname" value=""   id="garantor_lname">
                            <input type="hidden" name="garantor_id" value=""  id="garantor_id">
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="valid_id"> Government Valid ID
                                <span class="astk">*</span>
                            </label>
                            <input name="valid_id" id="valid_id" type="file" class="form-control w-50">
                            <p id="valid_id"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="selfie"> Selfie with ID 
                                <span class="astk">*</span>
                            </label>
                                <input type="file" class="form-control w-50" id="selfie" name="selfie">
                                <p id="selfie"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label >Work
                                <span class="astk">*</span>
                            </label> <br>
                            <input type="text" id="work" name="work" class="text-field w-50" placeholder="Job Position">
                            <p id="work"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label >Monthly Salary/Income
                                <span class="astk">*</span>
                            </label> <br>
                            <input type="text" id="salary" name="salary" class="text-field w-50" placeholder="Monthly Salary/Income">
                            <p id="salary"></p>
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