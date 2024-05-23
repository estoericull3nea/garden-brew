<?php

require '../../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['user_id'])) {
    $user_id = $data['user_id'];

    // Prepare the SQL statement to delete a user
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $stmt->bind_param('i', $user_id);

    // Execute the statement
    if ($stmt->execute() === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    } else {
        echo 'User deleted successfully.';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo 'User ID not provided.';
}
