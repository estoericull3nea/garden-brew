<?php
require '../../../connection/connect.php';

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);

$prod_id = $data['prod_id'];
$prod_name = $data['prod_name'];
$prod_price = $data['prod_price'];
$new_stock = $data['stock'];


// Update the product in the database
$stmt = $conn->prepare("UPDATE products SET prod_name = ?, prod_price = ?, stocks = ? WHERE prod_id = ?");
$stmt->bind_param("sdii", $prod_name, $prod_price, $new_stock, $prod_id);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Product updated successfully']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update product']);
}

$stmt->close();
$conn->close();
?>
