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
            $query = "select * from booking where custid=" . $custId . ";";
            
            $result = $db->query($query);
            if($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                
                $pid = $row["pid"];
                $sTime = $row["parkfrom"];
                $eTime = $row["parkend"];
                
                print($pid);
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
            var cTime = Date().split(" ")[4].split(":");
            cTime = parseInt(cTime[0]) * 60 + parseInt(cTime[1]);
            
            var sTime = parseInt($("#sTime").html());
            var eTime = parseInt($("#eTime").html());
            
            $("#sTime").html(parseInt(sTime / 60 ) + " : " + (sTime % 60) + " hrs");
            $("#eTime").html(parseInt(eTime / 60 ) + " : " + (eTime % 60) + " hrs");
            
            $("#timer").attr("data-percent", (cTime - sTime) * 100 / (eTime - sTime));
            $("#timer").pieChart({
                barColor: sTime > cTime || eTime < cTime ? '#f00' : '#0f0',
                lineWidth: 10,
                animate: {
                    duration: (eTime - cTime) * 60 * 1000,
                    enabled: true
                }
            });        
            
            $("#extendOk").click(function(){            
                var cTime = Date().split(" ")[4].split(":");
                cTime = parseInt(cTime[0]) * 60 + parseInt(cTime[1]);
                var url = "extend.php?eTime=" + $("#extendAmt").val() + "&cTime=" + cTime;
                function success() {
                    window.location = "ticket.php"; 
                }
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
                toggleButton($(this), url, success, fail);
            });
            
            $("#cancel").click(function(){
            var url = "cancel.php";
            function success() {
                var cTime = Date().split(" ")[4].split(":");
                cTime = parseInt(cTime[0]) * 60 + parseInt(cTime[1]);
                $.get("cron.php?cTime=" + cTime, function(data){
                        window.location = "account.php"; 
                });
            }
            function fail() {
                    $("#extendOk").attr("class", "btn btn-default");
                    $("#extendOk").attr("html", "Ok!");
            }
            
            toggleButton($(this), url, success, fail);
            });
            
            $("#ticketLink").attr("class", "active");
        </script>
    </body>

</html>