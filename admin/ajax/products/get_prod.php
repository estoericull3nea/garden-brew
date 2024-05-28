<?php
session_start();
require '../../../connection/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prod_id = $_POST['prod_id'];
    $sql = "SELECT * FROM products WHERE prod_id='$prod_id'";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
    echo json_encode($product);
}
?>