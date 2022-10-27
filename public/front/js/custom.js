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