<?php
require '../../connection/connect.php';

session_start();

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$order_id = $data['order_id'];

// Prepare the SQL statement to update orders
$sql = "
UPDATE orders
SET status = 'canceled',
    canceled_at = NOW()
WHERE status = 'pending' OR status = 'approved' AND user_id = ? AND order_id = ?;
";

// Create a prepared statement
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind the user_id and order_id parameters
$stmt->bind_param("ii", $user_id, $order_id);

// Execute the statement
if ($stmt->execute() === false) {
    die("Error executing statement: " . $stmt->error);
} else {
    echo "1";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
