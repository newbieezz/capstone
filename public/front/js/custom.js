$(document).ready(function(){
    $("#getPrice").change(function(){
        var size = $(this).val();
        var product_id = $(this).attr("product-id"); //pass the id via ajax and route
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/get-product-price',
            data:{size:size,product_id:product_id},
            type: 'post',
            success:function(resp){
                // alert(resp['final_price']);
                if(resp['discount']>0){
                    $(".getAttributePrice").html("<div class='price'><h4>₱"+resp['final_price']+"</h4></div><div class='original-price'><span>Original Price:</span><span>₱"+resp['product_price']+"</span></div>");
                } else {
                    $(".getAttributePrice").html("<div class='price'><h4>₱"+resp['final_price']+"</h4></div>");
                }
            },error:function(){
                alert("Error");
            }
        });

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