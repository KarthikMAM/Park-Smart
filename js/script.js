//Toggle update status from server
function toggleButton(button, url, success, failure) {
    //Disable button to prevent duplicated requests
    button.attr("disabled", true);
    
    //Send server the request
    $.get(url, function(data){
        if(data.indexOf("s") != -1) {
            //Actions for the success senario
            button.attr("class", "btn btn-success");
            button.attr("html", "Success!");
            
            setTimeout(success, 2000);
        } else {
            //Actions for the failed senario
            button.attr("class", "btn btn-danger");
            button.attr("html", "Failure!");
            button.attr("disabled", false);
            
            setTimeout(failure, 2000);
        }
    });
}   