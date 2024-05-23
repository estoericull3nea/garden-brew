<?php
require '../../../connection/connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'];

$sql = "SELECT user_id, fname, lname, phone_number, address, username FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode($user);
} else {
    echo json_encode(["message" => "User not found."]);
}

$stmt->close();
$conn->close();
?>
