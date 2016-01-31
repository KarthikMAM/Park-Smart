<?php
    //Extract data required and open db connection
    extract($_GET);     //[$userId, $passWd]
    include 'conn.php';
    
    //Try logging in and print the result and set cookies accordingly
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
