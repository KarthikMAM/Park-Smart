<!doctype html>
<html>

    <head>
        <title>SmartPark | Ticket</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body>
        
        <?php include 'menu.php'; ?>
        <?php extract($_COOKIE); ?>
        <?php include 'conn.php'; ?>
        <?php
            //Get the booked ticket details
            $query = "select * from booking where custid=" . $custId . ";";
            
            $result = $db->query($query);
            if($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                
                $pid = $row["pid"];
                $sTime = $row["parkfrom"];
                $eTime = $row["parkend"];
            }
        ?>
        
        <div class="container container-default">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center>
                        <h3>Booked Parking Ticket</h3>
                    </center>
                </div>
                <div class="panel-body">
                    <center>
                        <div id="timer" data-percent="100"></div>
                    </center>
                </div>
                <table class="table table-stripped table-responsive">
                    <tr>
                        <td class="col-sm-6"><h4>User Name : </h4></td>
                        <td class="col-sm-6"><?php print($userId); ?></td>
                    </tr>
                    <tr>
                        <td class="col-sm-6"><h4>Customer Id : </h4></td>
                        <td class="col-sm-6"><?php print($custId); ?></td>
                    </tr>
                    <tr>
                        <td class="col-sm-6"><h4>Slot Booked : </h4></td>
                        <td class="col-sm-6"><?php print($pid); ?></td>
                    </tr>
                    <tr>
                        <td class="col-sm-6"><h4>From Time : </h4></td>
                        <td class="col-sm-6" id="sTime"><?php print($sTime); ?></td>
                    </tr>
                    <tr>
                        <td class="col-sm-6"><h4>To Time : </h4></td>
                        <td class="col-sm-6" id="eTime"><?php print($eTime); ?></td>
                    </tr>
                    <tr>
                        <td class="col-sm-6"><h4>Total : </h4></td>
                        <td class="col-sm-6" id="eTime"><?php print("&#8377; " . ($eTime - $sTime)); ?></td>
                    </tr>
                </table>
                <div class="panel-footer">
                    <center>
                        <button class="btn btn-default" id="cancel">Cancel</button>
                        <button class="btn btn-default" data-toggle="modal" data-target="#extend">Extend</button>
                        
                        <div class="modal fade" id="extend" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <center><h3 class="modal-title">Extend by</h3></center>
                                    </div>
                                    <div class="modal-body">
                                        <form action="form form-horizontal">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label for="extend" class="control-label col-sm-4" style="vertical-align:center !important;">Extend Time By: </label>
                                                    <div class="col-sm-8">
                                                        <select name="extend" id="extendAmt" class="form-control">
                                                            <option value="30"> 0 Hr 30 Min</option>
                                                            <option value="60">1 Hr 00 Min</option>
                                                            <option value="90">1 Hr 30 Min</option>
                                                            <option value="120">2 Hr 00 Min</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-default" id="extendOk">
                                            Ok!
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
        <?php include 'error.php' ?>

        <?php include 'links.php' ?>
        <script type="text/javascript">
            //Get the current time as hh:mm
            //Convert it to hh * 60 + mm 
            var cTime = Date().split(" ")[4].split(":");
            cTime = parseInt(cTime[0]) * 60 + parseInt(cTime[1]);
            
            //Get the raw time sent by server
            var sTime = parseInt($("#sTime").html());
            var eTime = parseInt($("#eTime").html());
            
            //Convert raw time to standard hh:ss format
            var sTimeHr = parseInt(sTime / 60 );
            var eTimeHr = parseInt(eTime / 60 );
            $("#sTime").html((sTimeHr > 12 ? sTimeHr - 12 : sTimeHr) + " : " + (sTime % 60) + (sTime < 720 ? " AM" : " PM"));
            $("#eTime").html((eTimeHr > 12 ? eTimeHr - 12 : eTimeHr) + " : " + (eTime % 60) + (eTime < 720 ? " AM" : " PM"));
            
            //Start the timer with the following parameters
            $("#timer").attr("data-percent", (cTime - sTime) * 100 / (eTime - sTime));
            $("#timer").pieChart({
                barColor: sTime > cTime || eTime < cTime ? '#f00' : '#0f0',
                lineWidth: 10,
                animate: {
                    duration: (eTime - cTime) * 60 * 1000,
                    enabled: true
                }
            });        
            
            //Extend ticket action
            $("#extendOk").click(function(){
                //Prepare the url          
                var cTime = Date().split(" ")[4].split(":");
                cTime = parseInt(cTime[0]) * 60 + parseInt(cTime[1]);
                var url = "extend.php?eTime=" + $("#extendAmt").val() + "&cTime=" + cTime;
                
                //Success scenario
                function success() {
                    window.location = "ticket.php"; 
                }
                
                //Failure scenario
                function fail(){
                    $("#extendOk").attr("class", "btn btn-default");
                    $("#extendOk").attr("html", "Ok!");
                    
                    var reasons =  "<li>" + " Insufficient Funds " + "</li>" +
                        "<li>" + " Not booked a ticket yet " + "</li>" +
                        "<li>" + " User not logged in " + "</li>"; 
                    $("#reasons").html(reasons);
                    setTimeout(function() { $("#extend").modal('hide'); }, 100);
                    $("#errorMsg").modal('show');
                }
                
                //Toggle update status from server
                toggleButton($(this), url, success, fail);
            });
            
            //Cancel ticket action
            $("#cancel").click(function(){
                //Prepare the url
                var url = "cancel.php";
                
                //Success scenario
                function success() {
                    var cTime = Date().split(" ")[4].split(":");
                    cTime = parseInt(cTime[0]) * 60 + parseInt(cTime[1]);
                    $.get("cron.php?cTime=" + cTime, function(data){
                            window.location = "account.php"; 
                    });
                }
                
                //Failure scenario
                function fail() {
                        $("#extendOk").attr("class", "btn btn-default");
                        $("#extendOk").attr("html", "Ok!");
                }
                
                //Toggle update status from server
                toggleButton($(this), url, success, fail);
            });
            
            //Page highlighted on the menu bar
            $("#ticketLink").attr("class", "active");
        </script>
    </body>

</html>