<?php
    //Extract data required and open db connection
    extract($_GET);     //[$pid]
    include 'conn.php';
    
    //Update parking slot's status
	$query = "update parking set occupied=false where id=" . $pid . ";";
    $db->query($query);
    print('s');
    
    //Close the connection
    $db->close();
 ?>