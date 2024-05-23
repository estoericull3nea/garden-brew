<?php
require '../../../connection/connect.php';

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);

$prod_id = $data['prod_id'];

// Validate input
if (empty($prod_id)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit();
}

// Delete the product from the database
$stmt = $conn->prepare("DELETE FROM products WHERE prod_id = ?");
$stmt->bind_param("i", $prod_id);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Product deleted successfully']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to delete product']);
}

$stmt->close();
$conn->close();
