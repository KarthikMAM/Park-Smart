<!doctype html>
<html>
    <head>
        <title>Smart Park | Parking Space</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <?php include 'menu.php'; ?>
        
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center> 
                        <h3 style="clear:both">Book Your Parking Tickets Here!</h3>
                    </center>
                </div>
                <div class="padding-body row" style="margin:0px;padding:0px">
                    <div class="col-sm-4" style="margin:0px;padding:0px">
                        <div class="list-group" style="margin:0px;padding:0px">
                            <a href="#" class="list-group-item" id="1">Mall 1</a>
                            <a href="#" class="list-group-item" id="2">Mall 2</a>
                            <a href="#" class="list-group-item" id="3">Mall 3</a>
                            <a href="#" class="list-group-item" id="4">Mall 4</a>
                            <a href="#" class="list-group-item" id="5">Mall 5</a>
                            <a href="#" class="list-group-item" id="6">Mall 6</a>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <center>
                            <h3 id="info"> Mall </h3>
                            <div style="height:50px;"></div>
                            <form role="form" class="form">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <input type="time" class="form-control" name="parkStart" id="parkStart" placeholder="Enter Start Time">    
                                    </div>
                                    <div class="col-xs-6">
                                        <input type="time" class="form-control" name="parkEnd" id="parkEnd" placeholder="Enter End Time">
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-default" id="book">Book!</button>
                                <br>
                            </form>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
        <?php include 'error.php' ?>
        
        <?php include 'links.php'; ?>
        <script type="text/javascript">
            
            //Set active mall action
            $(".list-group .list-group-item").click(function(e) {
                $("#book").attr("class", "btn btn-default");
                $(".list-group .active").attr("class", "list-group-item");
                $("#book").attr("disabled", true);
                $(this).attr("class", "list-group-item active");
                
                //Get the number of available slots in the mall and display them
                var query = "check.php?mallId=" + $(".list-group .active").attr("id");
                $.get(query, function(data)  {
                    $("#info").html($(".list-group .active").html() + " : " + data + " Slots"); 
                    if(data == "0") {
                        $("#book").attr("disabled", true);
                    } else {
                        $("#book").attr("disabled", false);
                        
                    } 
                });
                
                //Prevent default click action
                e.preventDefault();
            });
            
            //Book a ticket action
            $("#book").click(function(e) {
                e.preventDefault();
                
                //Set the time data
                var sTime = $("#parkStart").val().split(":");
                var eTime = $("#parkEnd").val().split(":");
                var cTime = Date().split(" ")[4].split(":");
                
                sTime = parseInt(sTime[0]) * 60 + parseInt(sTime[1]);
                eTime = parseInt(eTime[0]) * 60 + parseInt(eTime[1])
                cTime = parseInt(cTime[0]) * 60 + parseInt(cTime[1]);
                
                //If conditions are met book a ticket   cTime <= sTime <= cTime + 30 <= eTime 
                //Else display error message
                if(cTime > sTime || sTime > cTime + 30 || sTime > eTime) {
                    var reasons = 
                        "<li>" + " Slot booking guidelines not followed " 
                            + "<ul>"
                                +"<li>" + "Start Time < End Time"
                                +"<li>" + "Parking tickets can be booked only 30 minutes prior to occupying"
                                +"<li>" + "Current Time < Start Time"
                            + "</ul>"
                        + "</li>";
                    $("#reasons").html(reasons);
                    $("#errorMsg").modal({show: 'true'});
                    return;
                }
                
                //Prepare url
                var url = "book.php?"
                            + "mallId=" + $(".list-group .active").attr("id")
                            + "&sTime=" + sTime
                            + "&eTime=" + eTime
                
                //Success scenario
                function success() { 
                    window.location = "ticket.php"; 
                }
                
                //Failure scenario
                function fail() { 
                    $("#book").html("Book!"); 
                    
                    var reasons = 
                        "<li>" + " Insufficient Funds " + "</li>" + 
                        "<li>" + " Slot lost in waiting pool " + "</li>"
                        "<li>" + " Already booked another ticket " + "</li>"
                    $("#reasons").html(reasons);
                    $("#errorMsg").modal({show: 'true'});
                }
                
                //Toggle update status from server
                toggleButton($(this), url, success, fail)
            });
        
            //Highlight the page in the navbar
            $("#reserveLink").attr("class", "active");
        </script>
    </body>
</html> 