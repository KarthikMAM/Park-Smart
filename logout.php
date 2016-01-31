<?php
    //delete cookies and goto login page
    setcookie("userId", "");
    setcookie("custId", "");
    
    header("Location: login.php");
 ?>