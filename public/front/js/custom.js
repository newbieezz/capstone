
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