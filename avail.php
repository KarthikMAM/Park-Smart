<?php
    extract($_GET);
    include 'conn.php';
    
    $query = "select * from parking where id=" . $pid;
    $result = $db->query($query);
    
    print($result->fetch_assoc()['occupied']);
 ?>