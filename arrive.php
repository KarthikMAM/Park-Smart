<?php
    //Extract data required and open db connection
    extract($_GET);     //[$pid]
    include 'conn.php';
    
    //Update customer arrival
	$query1 = "update parking set occupied=true where id=" . $pid . ";";
    $query2 = "update booking set arrived=true where pid=" . $pid . ";";
    $db->query($query1);
    $db->query($query2);
    
    //Confirmation message
    print('s');
    
    //Close the connection
    $db->close();
 ?>