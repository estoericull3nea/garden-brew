<?php

require '../../../connection/connect.php';

$sql = "SELECT * FROM products";

// Execute the query
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    $products = [];

    // Fetch all rows and store in an array
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    // Return the results in JSON format
    echo json_encode($products);
} else {
    // Return an empty array if no products are found
    echo json_encode([]);
}

// Close the database connection
$conn->close();
