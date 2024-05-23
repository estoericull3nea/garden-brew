<?php
require '../../../connection/connect.php';

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);

$prod_id = $data['prod_id'];
$new_stock = $data['stock'];

// Validate input
if (empty($prod_id) || !is_numeric($new_stock) || $new_stock < 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit();
}

// Update the stock in the database
$stmt = $conn->prepare("UPDATE products SET stocks = ? WHERE prod_id = ?");
$stmt->bind_param("ii", $new_stock, $prod_id);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Stock updated successfully']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update stock']);
}

$stmt->close();
$conn->close();
?>
