<?php
session_start();
require '../../../connection/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prod_id = $_POST['prod_id'];
    $sql = "DELETE FROM products WHERE prod_id='$prod_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>