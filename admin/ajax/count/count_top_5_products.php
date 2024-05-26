<?php
session_start();
require '../../../connection/connect.php';

// Check if the user is logged in
if (!(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true)) {
    header("Location: http://localhost/garden-brew/login.php");
    exit();
}

// SQL query to count all occurrences of each prod_name, ordered by count in descending order and limited to top 5
$sql = "SELECT prod_id, prod_name, prod_size, COUNT(*) as count FROM order_items GROUP BY prod_name ORDER BY count DESC LIMIT 5";

// Execute the query
$result = $conn->query($sql);

$response = [];

if ($result->num_rows > 0) {
    // Fetch data and store in response array
    while ($row = $result->fetch_assoc()) {
        $response[] = [
            'prod_id' => $row['prod_id'],
            'prod_name' => $row['prod_name'],
            'prod_size' => $row['prod_size'],
            'count' => $row['count']
        ];
    }
} else {
    $response['error'] = "No results found.";
}

// Close the connection
$conn->close();

// Set the content type to JSON
header('Content-Type: application/json');

// Output the JSON response
echo json_encode($response);
