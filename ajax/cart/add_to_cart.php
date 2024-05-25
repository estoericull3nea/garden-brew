<?php
require '../../connection/connect.php';
session_start();

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Extract data
$user_id = $data['user_id'];
$prod_id = $data['prod_id'];
$prod_name = $data['prod_name'];
$prod_price = $data['prod_price'];
$prod_size = $data['prod_size'] === '16' ? '16oz' : '22oz';
$prod_total = $data['prod_total'];
$prod_qty = $data['prod_qty'];

// Insert into cart table
$sql = "INSERT INTO cart (user_id, prod_id, prod_name, prod_price, prod_size, prod_total, prod_qty) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisssii", $user_id, $prod_id, $prod_name, $prod_price, $prod_size, $prod_total, $prod_qty);

if ($stmt->execute()) {
    echo '1';
} else {
    echo '0';
}

$stmt->close();
$conn->close();
