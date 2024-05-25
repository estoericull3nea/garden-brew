<?php
require '../../connection/connect.php';

$sql = "SELECT * FROM products WHERE category = 'Special' AND is_available = 1";

$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
} else {
    $response['error'] = "No records found";
}

// Close connection
$conn->close();

// Set content type to JSON
header('Content-Type: application/json');

// Return JSON response
echo json_encode($response);
?>