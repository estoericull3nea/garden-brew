<?php
session_start();
require '../../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data['user_id'];
$order_id = $data['order_id'];


// Prepare and bind
$stmt = $conn->prepare("SELECT 
oi.order_items_id, 
oi.order_id, 
oi.user_id, 
oi.prod_id, 
oi.prod_name, 
oi.prod_price, 
oi.prod_size, 
oi.prod_qty, 
oi.prod_total, 
oi.prod_img,
o.*, u.*  -- Select all columns from orders table
FROM 
order_items AS oi
JOIN 
orders AS o ON oi.order_id = o.order_id
JOIN users AS u ON oi.user_id = u.user_id
WHERE 
oi.order_id = ? 
AND oi.user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);

// Execute the statement
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $order_items = [];

    while ($row = $result->fetch_assoc()) {
        $order_items[] = $row;
    }

    echo json_encode($order_items);
} else {
    echo json_encode(["error" => "Error fetching records: " . $stmt->error]);
}

// Close statement and connection
$stmt->close();
$conn->close();
