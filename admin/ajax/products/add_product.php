<?php
require '../../../connection/connect.php';

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);

$prod_name = $data['prod_name'];
$prod_price = $data['prod_price'];
$stock = $data['stock'];

// Validate input
if (empty($prod_name) || !is_numeric($prod_price) || !is_numeric($stock) || $stock < 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit();
}

// Insert the new product into the database
$stmt = $conn->prepare("INSERT INTO products (prod_name, prod_price, stocks) VALUES (?, ?, ?)");
$stmt->bind_param("sdi", $prod_name, $prod_price, $stock);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Product added successfully']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to add product']);
}

$stmt->close();
$conn->close();
