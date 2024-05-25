<?php
require '../../connection/connect.php';

session_start();

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$order_id = $data['order_id'];

$sql = "
SELECT order_items.*
FROM orders
JOIN order_items ON order_items.order_id = orders.order_id
WHERE orders.user_id = ? AND order_items.order_id = ?;
";

// Create a prepared statement
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die(json_encode(["error" => "Error preparing statement: " . $conn->error]));
}

// Bind the user_id and order_id parameters
$stmt->bind_param("ii", $user_id, $order_id);

// Execute the statement
if ($stmt->execute() === false) {
    die(json_encode(["error" => "Error executing statement: " . $stmt->error]));
}

// Get the result
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order_items = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($order_items);
} else {
    echo json_encode([]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
