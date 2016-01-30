<?php
    extract($_GET);     //[$userId, $passWd]

    include 'conn.php';
    
    //Create the database entry for the new customer with an initial balance of 1000
	$query = "insert into customer(userid, password, balance) values('" . $userId . "', '" . $passWd . "', " . $balance . ");";
    if($db->query($query)) {
        print("s");
    } else {
        print("f");
    }
    
    //Close the connection
    $db->close();
 ?>
