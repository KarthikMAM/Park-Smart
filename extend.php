<?php
    header('Access-Control-Allow-Origin: *');
    extract($_GET);     //[$custId, $eTime, $cTime]
    extract($_COOKIE);

    include 'conn.php';
    
    //Check whether there is a registration under the customer
    $query = "select * from booking where custid=" . $custId . ";";
    $result = $db->query($query);
        
    //If there is a registration extend the time by the given time
    if($result->num_rows > 0) {
    
        $query = "select * from customer where id=" . $custId;
        $balance = (int)$db->query($query)->fetch_assoc()["balance"];
        $row = $result->fetch_assoc();
        $sTime  = (int)$row["parkfrom"];
        $eTime = (int)$row["parkend"] + $eTime;
        
        if($balance > $eTime - $sTime && (int)$row["parkend"] < cTime) {
            //Update the query
            $query = "update booking set parkend=" . $eTime . " where custid = " . $custId . ";";
            $db->query($query);
            
            //If the number updated rows is equal to 0
            if($db->affected_rows == 1) {
                print("s");
            } else {
                print("f");
            }    
        } else {
            print("f");
        }
    } else {
        print("f");
    }
    
    //Close the connection
    $db->close();
 ?>
