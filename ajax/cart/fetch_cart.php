<?php
session_start();
require '../../connection/connect.php';

// Get the user_id from session
$user_id = $_SESSION['user_id'];



// Prepare the SQL statement
$sql = "
SELECT 
cart.*, 
users.fname, 
users.lname, 
users.phone_number, 
users.address 
FROM 
cart 
JOIN 
users 
ON 
cart.user_id = users.user_id 
WHERE 
cart.user_id = ?
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
?>
