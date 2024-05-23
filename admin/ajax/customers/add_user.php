<?php

require '../../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(array("error" => "Connection failed: " . $conn->connect_error)));
}

$fname = $data['fname'];
$lname = $data['lname'];
$username = $data['username'];
$password = password_hash($data['password'], PASSWORD_BCRYPT);
$phone_number = $data['phone_number'];
$address = $data['address'];

$sql = "INSERT INTO users (fname, lname, username, password, phone_number, address) VALUES ('$fname', '$lname', '$username', '$password', '$phone_number', '$address')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("message" => "New record created successfully"));
} else {
    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
}

$conn->close();

?>
