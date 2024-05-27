<?php
require '../../connection/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT COUNT(*) FROM cart WHERE user_id = ? ";

    // Prepare the SQL statement
    $sql = "SELECT COUNT(*) as count FROM cart WHERE user_id = ?";
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
    $row = $result->fetch_assoc();

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Set content type to JSON
    header('Content-Type: application/json');

    // Return JSON response
    echo $row['count'];
} else {
    echo 0;
}
