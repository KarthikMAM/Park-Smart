<?php
    header('Access-Control-Allow-Origin: *');
    extract($_GET);     //[$custId]
    extract($_COOKIE);

    include 'conn.php';
    
    //Set that the arrived is true so that the cron job 
    //will remove this and charge the user if necessary
	$query = "update booking set arrived=true where custid=" . $custId . ";";
    $db->query($query);
    print('s');
    
    //Close the connection
    $db->close();
 ?>