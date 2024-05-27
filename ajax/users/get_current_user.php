<?php
require '../../connection/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Query to select user data based on user_id
    $sql = "SELECT * FROM users WHERE user_id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the user_id parameter
    $stmt->bind_param('i', $user_id); // 'i' indicates integer type

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if user data is found
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo '1';
    } else {
        // User not found
        // Redirect to another page
        echo '0';
        exit(); // Make sure to exit after redirection to prevent further execution
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // User ID not set in session
    echo '0';
}
