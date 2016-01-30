<?php
    extract($_GET);     //[$pid]

    //Database config variables
    $server = "localhost";
	$user = "u699426187_spark";
	$password = "hello1234";
	$database = "u699426187_spark";
	
	//Sql connection and query
	$db = new mysqli($server, $user, $password, $database) or die();
    
    //Execute the query to update the table such that the 
    //customer has arrived at his designated spot
	$query1 = "update parking set occupied=true where id=" . $pid . ";";
    $query2 = "update booking set arrived=true where pid=" . $pid . ";";
    $db->query($query1);
    $db->query($query2);
    
    //Confirmation message
    print('s');
    
    //Close the connection
    $db->close();
 ?>