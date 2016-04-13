<?php
    //Get the domain name
    $domain = $_SERVER["SERVER_NAME"];
    $SMART_PARK = "smartpark.hol.es";

    //Database config variables
    $server = "localhost";
	$user = $domain == $SMART_PARK ? "u699426187_spark" : "u696377022_park";
	$password = "hello1234";
	$database = $domain == $SMART_PARK ? "u699426187_spark" : "u696377022_park";
    
	//Sql connection establishment
	$db = new mysqli($server, $user, $password, $database) or die();
    
    //Update database with cron jobs
    if( $_SERVER["REQUEST_URI"] != "/cron.php" ) { 
        file_get_contents('http://' . $domain  . '/cron.php');
    }
 ?>