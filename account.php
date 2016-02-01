<!doctype html>
<html>

<head>
    <title>SmartPark | Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    
    <?php include 'menu.php'; ?>
    <?php extract($_COOKIE); ?>
    <?php include 'conn.php'; ?>
    <?php
        //Get customer details
        $query = "select * from logs where custid=" . $custId . ";";
        $result = $db->query($query);
     ?>
    
    <div class="container container-default">
        <div class="panel panel-default">
            <div class="panel-heading">
                <center>
                    <h3>Account Details</h3>
                </center>
            </div>
            <?php if(isset($_COOKIE["custId"])) { ?>
                <div class="panel-body">
                    <?php
                        $query1 = "select * from customer where id=" . $custId . ";";
                        $result1 = $db->query($query1);
                        
                        if($result1->num_rows > 0) {
                            $row = $result1->fetch_assoc();
                            $userId = $row["userid"];
                            $custId = $row["id"];
                            $balance = $row["balance"];
                        }
                    ?>
                    <center>
                        <div>
                            <table class="table table-hover table-responsive">
                                <colgroup>
                                    <col style="width:50%;"/>
                                    <col style="width:50%;"/>
                                </colgroup>
                                <tr>
                                    <td><b>User Name : </b></td>
                                    <td><?php print($userId); ?></td>
                                </tr>   
                                <tr>
                                    <td><b>Customer Id : </b></td>
                                    <td><?php print($custId); ?></td>
                                </tr>   
                                <tr>
                                    <td><b>Balance : </b></td>
                                    <td>&#8377; <?php print($balance); ?></td>
                                </tr>   
                            </table>
                        </div>
                    </center>
                </div> 
                <?php $count = 0; $total = 0; ?>
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Slot</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Cost</th>
                        </tr>
                    </thead>
                    <?php if($result->num_rows > 0) { ?>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()) { ?>
                                <?php
                                    $count += 1; 
                                    $pid = $row["pid"];
                                    $sTime = (int)$row["parkfrom"];
                                    $eTime = (int)$row["parkend"];
                                    $cost = ($eTime - $sTime);
                                    $total += $cost;
                                    
                                    $sTimeHr = (int)($sTime / 60);
                                    $eTimeHr = (int)($eTime / 60);
                                ?>
                                <tr>
                                    <td><?php print($count);?></td>
                                    <td><?php print($pid); ?></td>
                                    <td><?php print(($sTimeHr > 12 ? $sTimeHr - 12 : $sTimeHr) . " : " . ($sTime % 60)) . ($sTime < 720 ? " AM" : " PM"); ?></td>
                                    <td><?php print(($eTimeHr > 12 ? $eTimeHr - 12 : $eTimeHr) . " : " . ($eTime % 60)) . ($sTime < 720 ? " AM" : " PM"); ?></td>
                                    <td><?php print("&#8377; " . $cost); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    <?php } ?>
                    <tfoot>
                        <tr>
                            <td colspan="4"><b style="float:right">Cost</b></td>
                            <td><?php print("&#8377; " . $total); ?></td>
                        </tr>
                    </tfoot>
                </table>
            <?php } else { ?>
                <?php header("Location: login.php");?>
            <?php } ?>
        </div>
    </div>
    <?php include 'footer.php' ?>

    <?php include 'links.php' ?>
    <script type="text/javascript">
        //Toggle update status from server
        $("#accountLink").attr("class", "active");
    </script>
</body>

</html>