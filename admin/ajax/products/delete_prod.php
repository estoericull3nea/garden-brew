<?php
session_start();
require '../../../connection/connect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prod_id = $_POST['prod_id'];

    $query = "DELETE FROM products WHERE prod_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $prod_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }

    $stmt->close();
}
?>
