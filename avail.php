<?php
    //Extract data required and open db connection
    extract($_GET);
    include 'conn.php';
    
    //Check parking slot availability
    $query = "select * from parking where id=" . $pid;
    $result = $db->query($query);
    
    //Print status
    print($result->fetch_assoc()['occupied']);
 ?>