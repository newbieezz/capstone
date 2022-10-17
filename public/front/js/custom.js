$(document).ready(function(){

    $("#sort").on("change",function(){
        //change if user select any option
        // this.form.submit();
        var sort = $("#sort").val();
        var url = $("#url").val();

        //pass the ajax to the function
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:url,
            method:'Post',
            data:{sort:sort,url:url},
            success:function(data){
                $('.filter_product').html(data);
            },error:function(){
                alert("Error");
            }
        });
    });

});