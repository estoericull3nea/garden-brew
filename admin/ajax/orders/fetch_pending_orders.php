<?php
session_start();
require '../../../connection/connect.php';


// SQL query to join orders and users and fetch all orders with status 'pending'
$sql = "
    SELECT o.*, u.*
    FROM orders AS o
    JOIN users AS u ON o.user_id = u.user_id
    WHERE o.status = 'pending'
";

// Execute the query
$result = $conn->query($sql);

$response = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = [
            'order_id' => $row['order_id'],
            'user_id' => $row['user_id'],
            'payment_mode' => $row['payment_mode'],
            'status' => $row['status'],
            'order_date' => $row['order_date'],
            'fname' => $row['fname'],
            'lname' => $row['lname'],
            'email' => $row['email'],
            'phone_number' => $row['phone_number'],
            'address' => $row['address']
        ];
    }
} else {
    $response['error'] = "No results found.";
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
