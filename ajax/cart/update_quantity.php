<?php
require '../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$cart_id = (int) $data['cart_id'];
$new_qty = (int) $data['qty'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to update quantity
$sql = "UPDATE cart SET qty = ? WHERE cart_id = ?";
$stmt = $conn->prepare($sql);

// Check if preparation was successful
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("ii", $new_qty, $cart_id);

// Execute the statement
$response = array();
if ($stmt->execute()) {
    $response['status'] = 'success';
    echo '1';
} else {
    $response['status'] = 'error';
    echo '0';
}

// Close statement and connection
$stmt->close();
$conn->close();
