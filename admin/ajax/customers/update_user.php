<?php

require '../../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(array("error" => "Connection failed: " . $conn->connect_error)));
}

$user_id = $data['user_id'];
$fname = $data['fname'];
$lname = $data['lname'];
$username = $data['username'];
$phone_number = $data['phone_number'];
$address = $data['address'];

$sql = "UPDATE users SET fname='$fname', lname='$lname', username='$username', phone_number='$phone_number', address='$address' WHERE user_id='$user_id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("message" => "Record updated successfully"));
} else {
    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
}

$conn->close();

?>
