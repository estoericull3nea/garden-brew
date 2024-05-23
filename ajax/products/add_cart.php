<?php
require '../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);


$prod_id = (int) $data['prod_id'];
$user_id = (int) $data['user_id'];
$quantity = (int) $data['quantity'];


// Prepare an SQL statement
$stmt = $conn->prepare("INSERT INTO cart (prod_id, user_id, qty) VALUES (?, ?, ?)");

// Check if preparation was successful
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("iii", $prod_id, $user_id, $quantity);

// Execute the statement
if ($stmt->execute()) {
    echo "1";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
