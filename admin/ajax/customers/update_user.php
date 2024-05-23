<?php

require '../../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data['user_id'];
$fname = $data['fname'];
$lname = $data['lname'];
$phone_number = $data['phone_number'];
$address = $data['address'];
$username = $data['username'];
$password = $data['password'] ? password_hash($data['password'], PASSWORD_DEFAULT) : null;

if ($password) {
    $sql = "UPDATE users SET fname = ?, lname = ?, phone_number = ?, address = ?, username = ?, password = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $fname, $lname, $phone_number, $address, $username, $password, $user_id);
} else {
    $sql = "UPDATE users SET fname = ?, lname = ?, phone_number = ?, address = ?, username = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $fname, $lname, $phone_number, $address, $username, $user_id);
}

if ($stmt->execute()) {
    echo 'User updated successfully.';
} else {
    echo 'Error updating user.';
}

$stmt->close();
$conn->close();
?>
