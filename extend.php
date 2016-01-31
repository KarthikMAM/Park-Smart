<?php
    //Extract data required and open db connection
    extract($_GET);     //[$custId, $eTime, $cTime]
    extract($_COOKIE);
    include 'conn.php';
    
    //Get customer's booked ticket details
    $query = "select * from booking where custid=" . $custId . ";";
    $result = $db->query($query);
        
    //Active tickets are extended by the given time
    if($result->num_rows > 0) {
    
        //Get customer's account details
        $query = "select * from customer where id=" . $custId;
        $balance = (int)$db->query($query)->fetch_assoc()["balance"];
        $row = $result->fetch_assoc();
        $sTime  = (int)$row["parkfrom"];
        $eTime = (int)$row["parkend"] + $eTime;
        
        //If conditions met update and print result
        if($balance > $eTime - $sTime && (int)$row["parkend"] > cTime) {
            $query = "update booking set parkend=" . $eTime . " where custid = " . $custId . ";";
            $db->query($query);
            
            //Response message
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
