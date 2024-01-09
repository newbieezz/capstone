<?php use App\Models\Product; 
      use App\Models\ProductsFilter; 
      use App\Models\PaylaterApplication;
?>
@extends('front.layout.layout')
@section('content')
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
            console.log('guarantors', guarantors);
            console.log(guarantorId);
            const index = guarantors.findIndex((element) => element.id == guarantorId)
            $('#guarantor_name').val(guarantors[index].name)

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
    <!-- Page Introduction Wrapper /- -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Cart</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="javascript:;">Checkout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Checkout-Page -->
    <div class="page-checkout u-s-p-t-80">
        <div class="container">
                @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error: </strong> {{ Session::get('error_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <!-- Second Accordion /- -->
                            <div class="row">
                                <!-- Delivery Address-Details -->
                                <div class="col-lg-6" id="deliveryAddresses"> <!-- use the id to refresh the addresses -->
                                    @include('front.products.delivery_addresses')
                                </div>
                             <!-- Checkout - -->
                        <div class="col-lg-6">
                            <form name="checkoutForm" id="checkoutForm" action="{{ url('checkout/') }}" method="post" enctype="multipart/form-data"> @csrf
                                <!-- Delivery Address-Details /- -->
                                {{--check if the array comes --}}
                                    @if(count($deliveryAddresses)>0) 
                                      <h4 class="section-h4">Additional Delivery Information</h4>
                                        @foreach($deliveryAddresses as $address)
                                            <div class="control-group" style="float:left; margin-right:8px;"><input type="radio" name="address_id" id="address{{ $address['id'] }}" value="{{ $address['id'] }}" /></div>
                                            <div>
                                                <label class="control-label">
                                                    {{ $address['name'] }} , {{ $address['address'] }} , ( {{ $address['mobile'] }} )
                                                </label>
                                                <a style="float:right; margin-left:10px" href="javascript:;" data-addressid="{{ $address['id'] }}"
                                                    class="removeAddress">Remove</a>
                                                <a style="float:right;" href="javascript:;" data-addressid="{{ $address['id'] }}"
                                                    class="editAddress">Edit</a> 
                                            </div>
                                            <br />
                                        @endforeach <br />
                                     @endif
                                    <h4 class="section-h4">Your Order</h4> <br><br>
                                    <div class="order-table" id="udcartItems" >
                                        <table class="u-s-m-b-13">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $total_price = 0 @endphp
                                                @foreach($selectedVendorItems as $item)
                                                    <?php 
                                                        $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                                                    ?> 
                                                        <tr>
                                                            <td>
                                                                <a href="{{ url('product/'.$item['product_id']) }}"> 
                                                                <img width="30" src="{{ asset('front/images/product_images/small/'.$item['product']['product_image']) }}" alt="Product">
                                                                <h6 class="order-h6">{{ $item['product']['product_name'] }}</h6>
                                                                <span class="order-span-quantity">  {{ $item['size'] }}  (x{{ $item['quantity'] }})</span>
                                                            </td>
                                                            <td>
                                                                <h6 class="order-h6">₱ {{ $getDiscountAttributePrice['final_price'] * $item['quantity']}}</h6>
                                                            </td>
                                                        </tr> 
                                                    {{-- Calculate the subtotal for each produuct by its desired quantity --}}
                                                    @php $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp
                                                @endforeach
                                                <tr>
                                                    <td>
                                                        <h6 class="order-h6">Delivery Fee</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="order-h6">To be followed . . .</h6>
                                                    </td>
                                                </tr>
                                                {{-- <tr>  T  A  X
                                                    <td>
                                                        <h3 class="order-h3">Tax</h3>
                                                    </td>
                                                    <td>
                                                        <h3 class="order-h3">₱ 0.00</h3>
                                                    </td>
                                                </tr> --}}
                                                <tr>
                                                    <td>
                                                        <h3 class="order-h3">Total</h3>
                                                    </td>
                                                    <td>
                                                        <h3 class="order-h3">₱ {{ $total_price }}</h3>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="u-s-m-b-13">
                                            <input type="radio" class="radio-box" name="payment_gateway" id="cash-on-delivery" value="COD">
                                            <label class="label-text" for="cash-on-delivery">Cash on Delivery</label>
                                        </div>
                                        <div class="u-s-m-b-13">
                                            <input type="radio" class="radio-box" name="payment_gateway" id="gcash" value="Gcash">
                                            <label class="label-text" for="gcash">Gcash</label>
                                        </div>
                                        <div class="u-s-m-b-13">
                                            <input type="radio" class="radio-box" name="payment_gateway" id="paylater" value="Paylater">
                                            <label class="label-text" for="paylater">Paylater</label>
                                        </div>

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
                                                                <th scope="col">Credit Score</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="guarantor_table_body">
                                                            </tbody>
                                                            <tbody id="guarantor_no_data">
                                                                <tr class="text-center">
                                                                    <td colspan="3"> No Data </td>
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
                                        <div class="u-s-m-b-13" id="paylater_details">
                                            <div class="u-s-m-b-13">
                                                <label for="guarantor_name"> Guarantor
                                                    <span class="astk">*</span>
                                                </label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control-plaintext" readonly aria-describedby="button-addon2" name="guarantor_name" id="guarantor_name">
                                                    <div class="input-group-append">
                                                        <button class="button button-outline-secondary" type="button" id="show_guarantor_modal" data-toggle="modal" data-target="#exampleModalCenter">Click Here</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="u-s-m-b-13">
                                                <label for="valid_id"> Government Valid ID
                                                    <span class="astk">*</span>
                                                </label>
                                                <input name="valid_id" id="valid_id" type="file" class="form-control w-50">
                                            </div>
                                            <div class="u-s-m-b-13">
                                                <label for="work"> Work Type
                                                    <span class="astk">*</span>
                                                </label>
                                                <input type="text" name="work" id="work" class="text-field" />
                                            </div>
                                            <div class="u-s-m-b-13">
                                                <label for="salary"> Salary
                                                    <span class="astk">*</span>
                                                </label>
                                                <input type="number" name="salary" id="salary" class="text-field" />
                                            </div>
                                        </div>
                                        {{-- <div class="u-s-m-b-13">
                                            <input type="radio" class="radio-box" name="payment_gateway" id="paypal" value="Paypal">
                                            <label class="label-text" for="paypal">Paypal</label>
                                        </div> --}}
                                        {{-- FOR BUY NOW PAY LATER --}}
                                       {{-- @if($userpl['bnpl_status']=="Approved")
                                            <div class="u-s-m-b-13">
                                                <label class="label-text" for="paylater">Buy Now, Pay Later</label>
                                                
                                                {{-- INSTALLMENTS --}}
                                            {{-- @foreach($installments as $installment)
                                                <div style="margin-left:25px" class="u-s-m-b-13">php 
                                                    <input type="radio" class="radio-box" name="{{$installment['installment_id']}}" id="{{$installment['installment_id']}}" value="{{$installment['installment_id']}}">
                                                    <label class="label-text" for="{{$installment['installment_id']}}">{{ $installment['description'] }}</label>
                                                    <br>
                                                    <span>For {{ round(($total_price + ($total_price * ($installment['interest_rate']/100))) / $installment['number_of_months'] , 2) }} Php/Month</span>
                                                </div>
                                                @endforeach --}}
                                            {{--</div>
                                                <div class="u-s-m-b-13">
                                                    @foreach($installments as $key => $installment)
                                                    <div style="margin-left:25px" class="u-s-m-b-13">
                                                        <input type="radio" class="radio-box" name="payment_gateway" id="paylater{{$key}}" value="paylater-{{ $installment['id'] }}">
                                                        <label class="label-text" for="paylater{{$key}}">{{ $installment['description'] }} For {{ round(($total_price + ($total_price * ($installment['interest_rate']/100))) / $installment['number_of_weeks'] , 2) }} Php/week</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            
                                        @endif --}}
                                        <div class="u-s-m-b-13">
                                            <input type="checkbox" required="" class="check-box" id="accept"  name="accept" value="Yes" title="Please agree to T&C" >
                                            <label class="label-text no-color" for="accept">I’ve read and accept the
                                                <a href="terms-and-conditions.html" class="u-c-brand">terms & conditions</a>
                                            </label>
                                        </div>
                                        <button type="submit" class="button button-outline-secondary">Place Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout-Page /- -->

@endsection