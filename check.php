<?php
    //Extract data required and open db connection
    extract($_GET);     //[$mallId]
    include 'conn.php';
    
    //Get no. of empty slots in mall
	$query = "select id from parking where mallid=" . $mallId . " and id not in (select pid from booking);";
    print($db->query($query)->num_rows);
    
    //Close the connection
    $db->close();
 ?>
