<?php
session_start();
if(!isset($_SESSION["aloggedin"]) && $_SESSION["aloggedin"] !== true){
  header("location: admin_login.php");
  exit;
}

?>