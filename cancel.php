<?php
    //Extract data required and open db connection
    extract($_GET);     //[$custId]
    extract($_COOKIE);
    include 'conn.php';
    
    //Cancel the ticket
	$query = "update booking set arrived=true where custid=" . $custId . ";";
    $db->query($query);
    print('s');
    
    //Close the connection
    $db->close();
 ?>