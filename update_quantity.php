<?php
include 'db.php';

header('Content-Type: application/json');

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['quantity']) || !is_numeric($_POST['quantity'])) {
    error_log("Invalid input: ID or Quantity is not set or not numeric. ID: " . $_POST['id'] . ", Quantity: " . $_POST['quantity']);
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

$id = $_POST['id'];
$quantity = $_POST['quantity'];

error_log("Received ID: $id, Quantity: $quantity");

$stmt = $con->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
$stmt->bind_param("ii", $quantity, $id);

if ($stmt->execute()) {
    error_log("Quantity updated successfully for ID: $id");
    echo json_encode(["status" => "success", "message" => "Quantity updated successfully!"]);
} else {
    error_log("Error updating record: " . $stmt->error);
    echo json_encode(["status" => "error", "message" => "Error updating record: " . $stmt->error]);
}

$stmt->close();
$con->close();
?>
