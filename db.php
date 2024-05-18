<?php
    
    
    global $con;
    $con = new mysqli("localhost", "root", "", "user");
    if($con->error){
        die("Database connection error".$con->error);
    }




?>