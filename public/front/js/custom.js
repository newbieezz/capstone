$(document).ready(function(){
   
    $("#getPrice").change(function(){
        var size = $(this).val();
        var product_id = $(this).attr("product-id");

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/get-product-price',
            data:{size:size,product_id:product_id},
            type:'post',
            success:function(resp){
                //alert(resp['final_price']);
                if(resp['discount']>0){
                    $(".getAttributePrice").html("<div class='price'><h4>₱ "+resp['final_price']+"</h4></div><div class='original-price'><span>Original Price:</span><span>₱ "+resp['product_price']+"</span></div>");
                } else {
                    $(".getAttributePrice").html("<div class='price'><h4>₱ "+resp['final_price']+"</h4></div>");
                }
            }, error:function(){
                alert("Error");
            }
        });
    });

    //update cart items qty
    $(document).on('click','.updateCartItem',function(){
        if($(this).hasClass('plus-a')){//will tell if the user click or not
            //get the qty
            var quantity = $(this).data('qty');
            //if clicked qty increase by 1
            new_qty = parseInt(quantity) + 1 ;
        }
        if($(this).hasClass('minus-a')){//will tell if the user click or not
            //get the qty
            var quantity = $(this).data('qty');
            //check qty is atleast 1
            if(quantity <= 1) {
                alert("Item quantity must be 1 or greater!");
                return false;
            }
            //if clicked qty subtract by 1
            new_qty = parseInt(quantity) - 1 ;
        }
        var cartid = $(this).data('cartid'); //get the cart id
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{cartid:cartid,qty:new_qty},
            url:'/cart/update',
            type:'post',
            success:function(resp){
                if(resp.status==false){
                    alert(resp.message);
                }
                $("#appendCartItems").html(resp.view);
            },error:function(){
                alert("Error");
            }

        })
    });

    //delete cart item
    $(document).on('click','.deleteCartItem',function(){
        var cartid = $(this).data('cartid');
        var result = confirm("Are you sure to delete this Cart Item?");
        if(result){ //if user clicks yes
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{cartid:cartid},
                url:'/cart/delete',
                type:'post',
                success:function(resp){
                    $("#appendCartItems").html(resp.view);
                },error:function(){
                    alert("Error");
                }
            })
        }
    });

    //jquery function for user register form validation
    $("#registerForm").submit(function(){
        var formdata = $(this).serialize();//get the complete data from the form
        // $(".loader").show(); //show the loader 
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"/user/register",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){ //validation fails
                        //display all the errors in array used eachloop
                        $.each(resp.errors,function(i,error){ //loop the error in an array
                            $("#register-"+i).attr('style','color:red');
                            $("#register-"+i).html(error);
                        setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                            $("#register-"+i).css({'display':'none'});
                        },3000);
                    });
                } else if(resp.type=="success"){ //if success in validation
                    $("#register-success").attr('style','color:green');
                    $("#register-success").html(resp.message);
                } 
            }, error:function(){
                alert("Error");
            }
        })
        
    })

    //jquery function for login form validation
    $("#loginForm").submit(function(){
        var formdata = $(this).serialize();//get the complete data from the form
        $.ajax({
            
            url:"/user/login",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){ //validation fails
                    //display all the errors in array used eachloop
                    $.each(resp.errors,function(i,error){ //loop the error in an array
                        $("#login-"+i).attr('style','color:red');
                        $("#login-"+i).html(error);
                    setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                        $("#login-"+i).css({'display':'none'});
                    },3000);
                 });
                } else if(resp.type=="success"){ //if success in validation move/redirerct to guard page
                    window.location.href = resp.url;
                } else if(resp.type=="incorrect"){ 
                    $("#login-error").attr('style','color:red');
                    $("#login-error").html(resp.message);
                }  else if(resp.type=="inactive"){ 
                    $("#login-error").attr('style','color:red');
                    $("#login-error").html(resp.message);
                }
            }, error:function(){
                alert("Error");
            }
        })
        
    });

    //jquery function for forgotpassword form validation
    $("#forgotpassForm").submit(function(){
        var formdata = $(this).serialize();//get the complete data from the form
        // $(".loader").show(); //show the loader 
        $.ajax({
            
            url:"/user/forgot-password",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){ //validation fails
                        //display all the errors in array used eachloop
                        $.each(resp.errors,function(i,error){ //loop the error in an array
                            $("#forgot-"+i).attr('style','color:red');
                            $("#forgot-"+i).html(error);
                        setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                            $("#forgot-"+i).css({'display':'none'});
                        },3000);
                    });
                } else if(resp.type=="success"){ //if success in validation
                    $(".loader").hide();
                    $("#forgot-success").attr('styel','color:green');
                    $("#forgot-success").html(resp.message);
                } 
            }, error:function(){
                alert("Error");
            }
        })
        
    });

    //jquery function for user Account form validation
    $("#accountForm").submit(function(){
        var formdata = $(this).serialize();//get the complete data from the form
        $(".loader").show(); //show the loader 
        $.ajax({
            url:"/user/account",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){ //validation fails
                    $(".loader").hide();
                        //display all the errors in array used eachloop
                        $.each(resp.errors,function(i,error){ //loop the error in an array
                            $("#account-"+i).attr('style','color:red');
                            $("#account-"+i).html(error);
                        setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                            $("#account-"+i).css({'display':'none'});
                        },3000);
                    });
                } else if(resp.type=="success"){ //if success in validation
                    $(".loader").hide();
                    $("#account-success").attr('styel','color:green');
                    $("#account-success").html(resp.message);
                    setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                        $("#account-success").css({'display':'none'});
                    },3000);
                } 
            }, error:function(){
                alert("Error");
            }
        })
        
    });

    //Update user password validation
    $("#passwordForm").submit(function(){
        var formdata = $(this).serialize();//get the complete data from the form
        $(".loader").show(); //show the loader 
        $.ajax({
            url:"/user/update-password",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){ //validation fails
                    $(".loader").hide();
                        //display all the errors in array used eachloop
                        $.each(resp.errors,function(i,error){ //loop the error in an array
                            $("#password-"+i).attr('style','color:red');
                            $("#password-"+i).html(error);
                        setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                            $("#password-"+i).css({'display':'none'});
                        },3000);
                    });
                } else if(resp.type=="incorrect"){ //validation fails
                    $(".loader").hide();
                        //display all the errors in array used eachloop
                            $("#password-error").attr('style','color:red');
                            $("#password-error").html(resp.message);
                        setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                            $("#password-error").css({'display':'none'});
                        },3000);
                }else if(resp.type=="success"){ //if success in validation
                    $(".loader").hide();
                    $("#password-success").attr('styel','color:green');
                    $("#password-success").html(resp.message);
                    setTimeout(function(){ //jquery function to set the time to disappear after 3 secs
                        $("#password-success").css({'display':'none'});
                    },3000);
                } 
            }, error:function(){
                alert("Error");
            }
        })
        
    }); 

    //Edit Delivery Addresses on Checkout Page
    $(document).on('click','.editAddress',function(){
        var addressid = $(this).data("addressid");
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //send the address id in the data
            data:{addressid:addressid},
            url:'/get-delivery-address', //route(web.php)
            type:"post",
            success:function(resp){
                $("#showdifferent").removeClass("collapse");
                $(".newAddress").hide();
                $(".deliveryText").text("Edit Delivery Address");
                $('[name=delivery_id]').val(resp.address['id']);
                $('[name=delivery_name]').val(resp.address['name']);
                $('[name=delivery_address]').val(resp.address['address']);
                $('[name=delivery_email]').val(resp.address['email']);
                $('[name=delivery_mobile]').val(resp.address['mobile']);
            }, error:function(){
                alert("Error");
            }
        });
    });

    //Save Delivery Address
    $(document).on('submit',"#addressAddEditForm",function(){
        var formdata = $("#addressAddEditForm").serialize();
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:formdata,
            url:'/save-address',
            type:'post',
            success:function(resp){
                if(resp.type=="error"){
                    $.each(resp.errors,function(i,error){
                        $("#delivery-"+i).attr('style','color:red');
                        $("#delivery-"+i).html(error);
                        setTimeout(function(){
                            $("delivery-"+i).css({
                                'display':'none'
                            });
                        },3000);
                    });
                } else {
                     $("#deliveryAddresses").html(resp.view);
                     window.location.href = "checkout/";
                }
            }, error:function(){
                alert("Error");
            }
        });
    });

    //Remove Delivery Address
    $(document).on('click',".removeAddress",function(){
        if(confirm("Are you sure to remove this address?")){
            var addressid = $(this).data("addressid"); //fetch the address id
            //after fetching the address id we will send it via ajax

            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'/remove-delivery-address',
                data:{addressid:addressid},
                type:'post',
                success:function(resp){
                    $("#deliveryAddresses").html(resp.view);
                    window.location.href = "checkout";
                }, error:function(){
                    alert("Error");
                }
            });
        }
    }); 



});

//required function to operate check box on the filter 
function get_filter(class_name){
    var filter = [];
    //check whenever the class name getchecked
    $('.'+class_name+':checked').each(function(){
        //push is to push the elements to the array
        filter.push($(this).val());
    });

    return filter;
} 