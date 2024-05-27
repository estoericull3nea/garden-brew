<?php
session_start();
require '../../../connection/connect.php';


$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';
$phone_number = $data['phone_number'] ?? '';
$address = $data['address'] ?? '';
$fname = $data['fname'] ?? '';
$lname = $data['lname'] ?? '';

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        'status' => 'error',
        'message' => 'Connection failed: ' . $conn->connect_error
    ]));
}

// Check if the username already exists
$sql = "SELECT COUNT(*) as count FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die(json_encode([
        'status' => 'error',
        'message' => 'Prepare failed: ' . $conn->error
    ]));
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if ($row['count'] > 0) {
    echo 'Username already registered';
    exit();
}

// Insert new user into the database
$sql = "INSERT INTO users (fname, lname, username, password, phone_number, address) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die(json_encode([
        'status' => 'error',
        'message' => 'Prepare failed: ' . $conn->error
    ]));
}

// Hash the password before storing it
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt->bind_param("ssssss", $fname, $lname, $username, $hashed_password, $phone_number, $address);
if ($stmt->execute()) {
    echo '1';
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to register user: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
