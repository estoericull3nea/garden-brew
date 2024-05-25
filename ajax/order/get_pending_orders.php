<?php
require '../../connection/connect.php';

session_start();

$user_id = $_SESSION['user_id'];

// Prepare the SQL statement to fetch orders
$sql = "
SELECT orders.*, users.*
FROM orders
JOIN users ON orders.user_id = users.user_id
WHERE orders.status = 'pending' AND orders.user_id = ?;

";
$stmt = $conn->prepare($sql);


// Bind the parameters
$stmt->bind_param("i", $user_id);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch all rows
$data = $result->fetch_all(MYSQLI_ASSOC);

// Close the statement and connection
$stmt->close();
$conn->close();

// Return the result in JSON format
header('Content-Type: application/json');
echo json_encode($data);
