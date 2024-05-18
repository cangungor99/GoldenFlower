<?php
include 'db.php';
global $con;
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM user_data WHERE id=$id";
    if ($con->query($sql) === TRUE) {
        echo "<script>alert('Record deleted successfully');</script>";
        header("Location: cus_management.php");
    } else {
        echo "Error deleting record: " . $con->error;
    }
}

?>