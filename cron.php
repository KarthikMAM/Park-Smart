<?php
    //Extract data required and open db connection
    extract($_GET);     //[$cTime]
    include 'conn.php';
    
    //Set current time
    $cTime = (int)date('H') * 60 + (int)date('i') + 330; 
    
    //Use tansactions here to produce atomic updates
    try {
        $db->autocommit(FALSE);
        
        /*
         *  Select all the rows from the booking table where the 
         *      1. The alloted time has expired
         *      2. The user has vacated the spot
         *      3. Cancelled the spot which is treated as vacating the spot
         */
        $query = "select * from booking where parkend + 1 < " . $cTime . " or (arrived = 1 and pid in (select id from parking where occupied = 0));";
        $result = $db->query($query);
        print($result->num_rows);
        while($row = $result->fetch_assoc()) {
            //Compute the cost for this booking
            $cost = ($row['parkend'] - $row['parkfrom']);
            
            //If the cost is less than 0 then the user has cancelled before his slot starts, so don't charge him
            if ($cost > 0) {
                $query = "update customer set balance=balance-" . $cost . " where id=" . $row['custid'] . ";";
                $db->query($query); 
            }
        }
        
        //Perform Garbage collection and log maintenence
        $query1 = "insert into logs ( select * from booking where parkend + 1 < " . $cTime . " or (arrived = 1 and pid in (select id from parking where occupied = 0)));";
        $query2 = "delete from booking where parkend + 1 < " . $cTime . "  or (arrived = 1 and pid in (select id from parking where occupied = 0));";
        $query3 = "update parking set occupied = 0 where id not in (select pid from booking);";
        $db->query($query1);
        $db->query($query2);
        $db->query($query3);
         
        //Commit updates
        $db->commit();
    } catch (Exception $e) {
        //Rollback changes and print error
        print($e);
        $db->rollback();
    }
    
    //Close the connection
    $db->close();
 ?>