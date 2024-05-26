<?php
session_start();
require '../../../connection/connect.php';

if (!(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true)) {
    header("Location: http://localhost/garden-brew/login.php");
    exit();
}

$sql = "SELECT COUNT(*) AS pending_count FROM orders WHERE status = 'approved'";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    echo $row['pending_count'];
} else {
    echo json_encode(['pending_count' => 0]);
}
