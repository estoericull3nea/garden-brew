<?php

require '../../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(array("error" => "Connection failed: " . $conn->connect_error)));
}

$user_id = $data['user_id'];

$sql = "DELETE FROM users WHERE user_id='$user_id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("message" => "Record deleted successfully"));
} else {
    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
}

$conn->close();

?>
