<?php
require '../../connection/connect.php';

session_start();

$user_id = $_SESSION['user_id'];

$sql = "
SELECT COUNT(*) AS pending_count
FROM orders
WHERE status = 'pending' AND user_id = ?
";

// Create a prepared statement
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind the user_id parameter
$stmt->bind_param("i", $user_id);

// Execute the statement
if ($stmt->execute() === false) {
    die("Error executing statement: " . $stmt->error);
}

// Bind the result variable
$stmt->bind_result($pending_count);

// Fetch the result
$stmt->fetch();

// Output the count of pending orders
echo $pending_count;

// Close the statement and connection
$stmt->close();
$conn->close();
