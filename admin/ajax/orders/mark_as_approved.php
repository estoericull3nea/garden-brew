<?php
session_start();
require '../../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data['user_id'];
$order_id = $data['order_id'];

// Prepare and bind
$stmt = $conn->prepare("UPDATE orders SET status = 'approved', date_approved = NOW() WHERE order_id = ? AND user_id = ?");

$stmt->bind_param("ii", $order_id, $user_id);

// Execute the statement
if ($stmt->execute()) {
    echo '1';
} else {
    echo json_encode(["error" => "Error updating record: " . $stmt->error]);
}

// Close statement and connection
$stmt->close();
$conn->close();
