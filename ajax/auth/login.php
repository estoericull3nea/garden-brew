<?php
require '../../connection/connect.php';

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';


// Validate the input
if (!empty($username) && !empty($password)) {
    // Check if the user exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // If user exists, check the password
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['password'] === $password) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user'] = $username;
            echo '1';
        } else {
            echo  'Incorrect password';
        }
    } else {
       echo 'User does not exist';
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();

// Return the response
header('Content-Type: application/json');
