<?php
    function connectDB(){
        $con = new mysqli("localhost","root","","user");
    if ($con->connect_error) {
        die("Connection Error: ". $con->connect_error);
    }
    return $con;
    }

?>