<?php
    extract($_GET);     //[$pid]

    //Database config variables
    $server = "localhost";
	$user = "u699426187_spark";
	$password = "hello1234";
	$database = "u699426187_spark";
	
	//Sql connection and query
	$db = new mysqli($server, $user, $password, $database) or die();
    
    //Update that the customer has left the parking slot
	$query = "update parking set occupied=false where id=" . $pid . ";";
    $db->query($query);
    print('s');
    
    //Close the connection
    $db->close();
 ?>