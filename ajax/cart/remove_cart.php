<?php
require '../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$cart_id = (int) $data['cart_id'];
$sql = "DELETE FROM cart WHERE cart_id = ?";

$stmt = $conn->prepare($sql);

// Check if preparation was successful
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("i", $cart_id);

// Execute the statement
$response = array();
if ($stmt->execute()) {
    echo '1';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to delete cart item: ' . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();

// Set content type to JSON
header('Content-Type: application/json');


