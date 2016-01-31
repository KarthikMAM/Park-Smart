<?php
    //Database config variables
    $server = "localhost";
	$user = "u699426187_spark";
	$password = "hello1234";
	$database = "u699426187_spark";
    
	//Sql connection establishment
	$db = new mysqli($server, $user, $password, $database) or die();
    
    //Update database with cron jobs
    if( $_SERVER["REQUEST_URI"] != "/cron.php" ) { 
        file_get_contents('http://smartpark.hol.es/cron.php');
    }
 ?>