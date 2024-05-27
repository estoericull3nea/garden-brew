<?php

require '../../../connection/connect.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'];
$password = $data['password'];

// Prepare and execute the query
$stmt = $conn->prepare("SELECT admin_password FROM admin WHERE admin_username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Verify the password
    if ($password == $hashed_password) {
        // Successful login
        echo '1';
        $_SESSION['admin_logged_in'] = true;
    } else {
        // Invalid password
        http_response_code(401);
        echo 'Invalid username or password';
    }
} else {
    // Invalid username
    http_response_code(401);
    echo 'Admin account does not exist';
}

$stmt->close();
$conn->close();
