//Toggle button template function
function toggleButton(button, url, success, failure) {
    button.attr("disabled", true);
    
    $.get(url, function(data){
        if(data == "s") {
            button.attr("class", "btn btn-success");
            button.attr("html", "Success!");
            
            setTimeout(success, 2000);
        } else {
            button.attr("class", "btn btn-danger");
            button.attr("html", "Failure!");
            button.attr("disabled", false);
            
            setTimeout(failure, 2000);
        }
    });
}   