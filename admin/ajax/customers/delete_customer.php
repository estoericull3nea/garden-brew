<?php
session_start();
require '../../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data['user_id'];

$query = "DELETE FROM users WHERE user_id = $user_id";
if ($conn->query($query) === TRUE) {
    echo '1';
} else {
    echo 'Error: ' . $conn->error;
}

$conn->close();
