<?php
session_start();
require '../../../connection/connect.php';

var_dump($_POST); exit();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prod_id = $_POST['prod_id'];
    $prod_name = $_POST['prod_name'];
    $prod_price = $_POST['prod_price'];
    $prod_size = $_POST['prod_size'];
    $is_available = $_POST['is_available'];
    $category = $_POST['category'];
    $prod_desc = $_POST['prod_desc'];

    // Check if a new image has been uploaded
    if ($_FILES['prod_img']['error'] == UPLOAD_ERR_NO_FILE) {
        $query = "UPDATE products SET prod_name = ?, prod_price = ?, prod_size = ?, is_available = ?, category = ?, prod_desc = ? WHERE prod_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssi", $prod_name, $prod_price, $prod_size, $is_available, $category, $prod_desc, $prod_id);
    } else {
        // Handle file upload
        $target_dir = "../../assets/images/milktea/$category/";
        $target_file = $target_dir . basename($_FILES["prod_img"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = 1;

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["prod_img"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo json_encode(["status" => "error", "message" => "File is not an image."]);
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["prod_img"]["size"] > 500000) { // 500KB
            echo json_encode(["status" => "error", "message" => "Sorry, your file is too large."]);
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo json_encode(["status" => "error", "message" => "Sorry, only JPG, JPEG, & PNG files are allowed."]);
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["prod_img"]["tmp_name"], $target_file)) {
                $query = "UPDATE products SET prod_name = ?, prod_price = ?, prod_img = ?, prod_size = ?, is_available = ?, category = ?, prod_desc = ? WHERE prod_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssssssi", $prod_name, $prod_price, $_FILES["prod_img"]["name"], $prod_size, $is_available, $category, $prod_desc, $prod_id);
            } else {
                echo json_encode(["status" => "error", "message" => "Sorry, there was an error uploading your file."]);
                exit();
            }
        } else {
            exit();
        }
    }

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database update failed."]);
    }

    $stmt->close();
}
