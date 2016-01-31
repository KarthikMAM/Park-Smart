<?php
    //Extract data required and open db connection
    extract($_GET);     //[$userId, $passWd]
    include 'conn.php';
    
    //Create new account if not already present
	$query = "insert into customer(userid, password, balance) values('" . $userId . "', '" . $passWd . "', " . $balance . ");";
    if($db->query($query)) {
        print("s");
    } else {
        print("f");
    }
    
    //Close the connection
    $db->close();
 ?>
