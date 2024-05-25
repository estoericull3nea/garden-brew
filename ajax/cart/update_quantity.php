<?php
require '../../connection/connect.php';
session_start();

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Extract data
$cart_id = $data['cart_id'];
$new_qty = $data['qty'];

// Get the current product details
$sql_get = "SELECT prod_price FROM cart WHERE cart_id = ?";
$stmt_get = $conn->prepare($sql_get);
$stmt_get->bind_param("i", $cart_id);
$stmt_get->execute();
$result_get = $stmt_get->get_result();

if ($result_get->num_rows > 0) {
    $row = $result_get->fetch_assoc();
    $prod_price = $row['prod_price'];
    $new_total = $new_qty * $prod_price;

    // Update the quantity and total price
    $sql_update = "UPDATE cart SET prod_qty = ?, prod_total = ? WHERE cart_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iii", $new_qty, $new_total, $cart_id);

    if ($stmt_update->execute()) {
        echo '1';
    } else {
        echo '0';
    }

    $stmt_update->close();
} else {
    echo '0';
}

$stmt_get->close();
$conn->close();
?>
