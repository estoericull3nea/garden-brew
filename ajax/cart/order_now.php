<?php
session_start();
require '../../connection/connect.php';

$user_id = $_SESSION['user_id'];

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Extract payment mode
$payment_mode = $data['paymentMode'];

// Fetch all cart items for the user
$sql_fetch_cart = "SELECT * FROM cart WHERE user_id = ?";
$stmt_fetch_cart = $conn->prepare($sql_fetch_cart);
$stmt_fetch_cart->bind_param("i", $user_id);
$stmt_fetch_cart->execute();
$result_fetch_cart = $stmt_fetch_cart->get_result();

if ($result_fetch_cart->num_rows > 0) {
    // Begin transaction
    $conn->begin_transaction();

    try {
        // Insert order details into orders table
        $sql_insert_order = "INSERT INTO orders (user_id, payment_mode) VALUES (?, ?)";
        $stmt_insert_order = $conn->prepare($sql_insert_order);
        $stmt_insert_order->bind_param("is", $user_id, $payment_mode);
        $stmt_insert_order->execute();
        
        // Get the last inserted order_id
        $order_id = $stmt_insert_order->insert_id;

        // Insert each cart item into order_items table
        $sql_insert_order_items = "INSERT INTO order_items (order_id, prod_id, prod_name, prod_price, prod_size, prod_qty, prod_total, prod_img, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_order_items = $conn->prepare($sql_insert_order_items);

        while ($row = $result_fetch_cart->fetch_assoc()) {
            $stmt_insert_order_items->bind_param("iisisiisi", $order_id, $row['prod_id'], $row['prod_name'], $row['prod_price'], $row['prod_size'], $row['prod_qty'], $row['prod_total'], $row['prod_img'], $user_id);
            $stmt_insert_order_items->execute();
        }

        // Clear the cart
        $sql_clear_cart = "DELETE FROM cart WHERE user_id = ?";
        $stmt_clear_cart = $conn->prepare($sql_clear_cart);
        $stmt_clear_cart->bind_param("i", $user_id);
        $stmt_clear_cart->execute();

        // Commit transaction
        $conn->commit();

        // Return success response
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    // Close statements
    $stmt_insert_order->close();
    $stmt_insert_order_items->close();
    $stmt_clear_cart->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No items in the cart']);
}

// Close connections
$stmt_fetch_cart->close();
$conn->close();
?>
