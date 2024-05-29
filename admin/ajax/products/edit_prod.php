<?php
session_start();
require '../../../connection/connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prod_id = $_POST['prod_id'];
    $prod_name = $_POST['prod_name'];
    $prod_price = $_POST['prod_price'];
    $prod_size = $_POST['prod_size'];
    $is_available = $_POST['is_available'];
    $prod_desc = $_POST['prod_desc'];

    if (isset($_FILES['prod_img']) && $_FILES['prod_img']['name'] != "") {
        $prod_img = $_FILES['prod_img']['name'];
        $target_file = $target_dir . basename($prod_img);
        if (move_uploaded_file($_FILES['prod_img']['tmp_name'], $target_file)) {
            $sql = "UPDATE products SET prod_name='$prod_name', prod_price='$prod_price', prod_img='$prod_img', prod_size='$prod_size', is_available='$is_available', prod_desc='$prod_desc' WHERE prod_id='$prod_id'";
        }
    } else {
        $sql = "UPDATE products SET prod_name='$prod_name', prod_price='$prod_price', prod_size='$prod_size', is_available='$is_available', prod_desc='$prod_desc' WHERE prod_id='$prod_id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
