<?php
    //Extract data required and open db connection
    extract($_GET);     //[$mallId, $custId, $sTime, $eTime]
    extract($_COOKIE);
    include 'conn.php';
    
    //Get available parking slots in mall
    $query = "select id from parking where mallid=" . $mallId . " and id not in (select pid from booking) limit 1;";
    $result = $db->query($query);
    
    //Get the customer balance
    $query = "select * from customer where id=" . $custId;
    $balance = (int)$db->query($query)->fetch_assoc()["balance"];
    
    //If there is an availiable slot and sufficient balance book that slot
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
