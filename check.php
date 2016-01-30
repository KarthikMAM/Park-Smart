<?php
    header('Access-Control-Allow-Origin: *');
    extract($_GET);     //[$mallId]

    include 'conn.php';
    
    //Get the number empty slots available from the server in the given mall
	$query = "select id from parking where mallid=" . $mallId . " and id not in (select pid from booking);";
    print($db->query($query)->num_rows);
    
    //Close the connection
    $db->close();
 ?>
