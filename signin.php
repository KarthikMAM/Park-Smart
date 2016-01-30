<?php
    header('Access-Control-Allow-Origin: *');
    extract($_GET);     //[$userId, $passWd]

    include 'conn.php';
    
    //Try to login if the server returns exactly one row then it is a success
    //Else it is a failure
	$query = "select * from customer where password='" . $passWd . "' and userid='" . $userId . "';";
    $result = $db->query($query); 
    if($result->num_rows == 1) {
        setcookie("userId", $userId);
        setcookie("custId", $result->fetch_assoc()['id']);
        print("s");
    } else {
        print("f");
    }
    
    //Close the connection
    $db->close();
 ?>
