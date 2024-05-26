<?php
session_start();
require '../../../connection/connect.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result) {
    $products = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($products);
} else {
    echo json_encode(['error' => $conn->error]);
}

// Close the connection
$conn->close();
?>
