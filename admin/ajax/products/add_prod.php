<?php
session_start();
require '../../../connection/connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prod_name = $_POST['prod_name'];
    $prod_price = $_POST['prod_price'];
    $prod_size = $_POST['prod_size'];
    $is_available = $_POST['is_available'];
    $category = $_POST['category'];
    $prod_desc = $_POST['prod_desc'];

    $prod_img = $_FILES['prod_img']['name'];
    $target_dir = "../../../assets/images/milktea/$category/";
    $target_file = $target_dir . basename($prod_img);

    if (move_uploaded_file($_FILES['prod_img']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO products (prod_name, prod_price, prod_img, prod_size, is_available, category, prod_desc)
                VALUES ('$prod_name', '$prod_price', '$prod_img', '$prod_size', '$is_available', '$category', '$prod_desc')";
        if ($conn->query($sql) === TRUE) {
            echo "Product added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading image";
    }
}
