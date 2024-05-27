<?php
session_start();
require '../../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'];
$fname = $data['fname'];
$lname = $data['lname'];
$phone_number = $data['phone_number'];
$address = $data['address'];

$query = "UPDATE users SET fname = '$fname', lname = '$lname', phone_number = '$phone_number', address = '$address'";

if (!empty($data['password'])) {
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $query .= ", password = '$password'";
}

$query .= " WHERE user_id = $user_id";

if ($conn->query($query) === TRUE) {
    echo '1';
} else {
    echo 'Error: ' . $conn->error;
}

$conn->close();
?>
