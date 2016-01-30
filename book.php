<?php
    header('Access-Control-Allow-Origin: *');
    extract($_GET);     //[$mallId, $custId, $sTime, $eTime]
    extract($_COOKIE);

    include 'conn.php';
    
    //Select the id of the parking slot which is to be alloted to the user
    $query = "select id from parking where mallid=" . $mallId . " and id not in (select pid from booking) limit 1;";
    $result = $db->query($query);
    
    $query = "select * from customer where id=" . $custId;
    $balance = (int)$db->query($query)->fetch_assoc()["balance"];
    
    //If there is a slot available create a new entry into the booking table
    if($result->num_rows > 0 && $balance > ($eTime - $sTime)) {
        $pId = $result->fetch_assoc()['id'];
        $query = "insert into booking(custid, pid, parkfrom, parkend) values(" . $custId . "," . $pId . "," . $sTime . "," . $eTime . ");";
        if($db->query($query)) {
            print("s");
        } else {
            print("f");
        }
    } else {
        print("f");
    }
    
    //Close the connection
    $db->close();
 ?>
