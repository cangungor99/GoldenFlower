<?php
include 'db.php';
$id = $_POST['id'];
$sql = "DELETE FROM product WHERE id = $id";
if($con->query($sql) === TRUE){
    echo "<script>alert('Record deleted successfully');</script>";
    header("Location: product_management.php");}
    else{
    echo "Error deleting record: " . $con->error;}
    $con->close();
?>