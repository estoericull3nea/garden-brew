<?php
require '../../connection/connect.php';

session_start();

$user_id = $_SESSION['user_id'];
$sql = "
SELECT 
cart.user_id, 
cart.prod_id, 
cart.qty, 
cart.cart_id,
products.prod_name, 
products.prod_price, 
products.prod_img,
users.fname,
users.lname
FROM cart 
INNER JOIN products ON cart.prod_id = products.prod_id 
INNER JOIN users ON cart.user_id = users.user_id
WHERE cart.user_id = ?
";


$stmt = $conn->prepare($sql);

// Check if preparation was successful
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("i", $user_id);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch all rows
$cart = $result->fetch_all(MYSQLI_ASSOC);

// Close statement and connection
$stmt->close();
$conn->close();

// Set content type to JSON
header('Content-Type: application/json');

// Return JSON response
echo json_encode($cart);
