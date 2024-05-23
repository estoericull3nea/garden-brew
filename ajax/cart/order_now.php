<?php
session_start();
require '../../connection/connect.php';

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$payment_mode = $data['paymentMode'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Here you can add the logic to create an order, for example, saving the order details to an `orders` table
// For simplicity, we assume an orders table with fields: user_id, payment_mode, order_date
$order_date = date('Y-m-d H:i:s');

// Prepare the SQL statement to insert a new order
$sql = "INSERT INTO orders (user_id, payment_mode, order_date) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("iss", $user_id, $payment_mode, $order_date);

// Execute the statement
$response = array();
if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Order placed successfully';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to place order: ' . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();

// Set content type to JSON
header('Content-Type: application/json');

// Return JSON response
echo json_encode($response);
