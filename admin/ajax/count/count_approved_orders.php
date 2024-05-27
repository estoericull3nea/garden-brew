<?php
session_start();
require '../../../connection/connect.php';


$sql = "SELECT COUNT(*) AS pending_count FROM orders WHERE status = 'approved'";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    echo $row['pending_count'];
} else {
    echo json_encode(['pending_count' => 0]);
}
