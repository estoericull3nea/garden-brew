<?php
require '../../connection/connect.php';
session_start();

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);

// var_dump($data); exit();


// Debugging: Log input data
file_put_contents('php://stderr', print_r($data, TRUE));

// Extract data
$user_id = $data['user_id'];
$prod_id = $data['prod_id'];
$prod_name = $data['prod_name'];
$prod_price = $data['prod_price'];
// $prod_size = $data['prod_size'] == '16' ? '16oz' : '22oz';
$prod_size = $data['prod_size'];
if ($prod_size == '8') {
    $prod_size = '8oz';
} else if ($prod_size == '16') {
    $prod_size = '16oz';
} else if ($prod_size == '12') {
    $prod_size = '12oz';
} else if ($prod_size == '22') {
    $prod_size = '22oz';
} else if ($prod_size === 'single') {
    $prod_size = 'Single';
} else if ($prod_size === 'double') {
    $prod_size = 'Double';
} else if ($prod_size === 'bff') {
    $prod_size = 'BFF';
} else if ($prod_size === 'solo') {
    $prod_size = 'Solo';
} else {
    $prod_size = '22oz';
}
$prod_total = $data['prod_total'];
$prod_catagory = $data['prod_category'];
$prod_qty = $data['prod_qty'];
$prod_img = $data['prod_img'];


// Check if the product already exists in the cart with the same size
$sql_check = "SELECT * FROM cart WHERE user_id = ? AND prod_id = ? AND prod_size = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("iis", $user_id, $prod_id, $prod_size);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Product with the same size exists, update the quantity and total price
    $row = $result_check->fetch_assoc();
    $new_qty = $row['prod_qty'] + $prod_qty;
    $new_total = $row['prod_total'] + $prod_total;

    $sql_update = "UPDATE cart SET prod_qty = ?, prod_total = ? WHERE user_id = ? AND prod_id = ? AND prod_size = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iiiis", $new_qty, $new_total, $user_id, $prod_id, $prod_size);

    if (!$stmt_update->execute()) {
        error_log("Update Error: " . $stmt_update->error);
        echo '0';
    } else {
        echo '1';
    }

    $stmt_update->close();
} else {
    // Product does not exist, insert a new row
    $sql_insert = "INSERT INTO cart (user_id, prod_id, prod_name, prod_price, prod_size, prod_total, prod_qty, prod_img, category) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iisssiiss", $user_id, $prod_id, $prod_name, $prod_price, $prod_size, $prod_total, $prod_qty, $prod_img, $prod_catagory);

    if (!$stmt_insert->execute()) {
        error_log("Insert Error: " . $stmt_insert->error);
        echo '0';
    } else {
        echo '1';
    }

    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
