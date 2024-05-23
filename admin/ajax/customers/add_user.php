<?php

require '../../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);

$fname = $data['fname'];
$lname = $data['lname'];
$phone_number = $data['phone_number'];
$address = $data['address'];
$username = $data['username'];
$password = password_hash($data['password'], PASSWORD_BCRYPT); // Hash the password

// Check if username already exists
$check_stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
if ($check_stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$check_stmt->bind_param('s', $username);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    echo 'Username already exists. Please choose a different username.';
    $check_stmt->close();
    $conn->close();
    exit();
}
$check_stmt->close();

// Prepare the SQL statement to insert a new user
$stmt = $conn->prepare("INSERT INTO users (fname, lname, phone_number, address, username, password) VALUES (?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

// Bind parameters
$stmt->bind_param('ssssss', $fname, $lname, $phone_number, $address, $username, $password);

// Execute the statement
if ($stmt->execute() === false) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
} else {
    echo 'New user added successfully.';
}

// Close the statement and connection
$stmt->close();
$conn->close();

?>
