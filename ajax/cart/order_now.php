<?php
session_start();
require '../../connection/connect.php';

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$payment_mode = $data['paymentMode'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    // Start transaction
    $conn->begin_transaction();

    // Fetch the user's first name
    $sql = "SELECT fname, lname, phone_number, address FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to fetch user details: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $fname = $user['fname'];
    $lname = $user['lname'];
    $phone_number = $user['phone_number'];
    $address = $user['address'];
    $stmt->close();

    // Insert the order with the user's first name
    $sql = "INSERT INTO orders (user_id, customer_fullname, customer_phonenumber, customer_address, payment_mode) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $fullname = $fname . ' ' . $lname;

    $stmt->bind_param("issss", $user_id, $fullname, $phone_number, $address, $payment_mode);
    if (!$stmt->execute()) {
        throw new Exception("Failed to place order: " . $stmt->error);
    }

    // Get the last inserted order ID
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Fetch cart items
    $sql = "SELECT prod_id, qty FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to fetch cart items: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $cart_items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Update product stock and clear the cart
    foreach ($cart_items as $item) {
        $prod_id = $item['prod_id'];
        $qty = $item['qty'];

        // Decrease the stock in the products table
        $sql = "UPDATE products SET stocks = stocks - ? WHERE prod_id = ? AND stocks >= ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("iii", $qty, $prod_id, $qty);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update product stock: " . $stmt->error);
        }

        if ($stmt->affected_rows === 0) {
            throw new Exception("Not enough stock for product ID: " . $prod_id);
        }

        $stmt->close();

        // Insert order details into order_items table
        $sql = "INSERT INTO order_items (order_id, prod_id, qty) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("iii", $order_id, $prod_id, $qty);
        if (!$stmt->execute()) {
            throw new Exception("Failed to insert order item: " . $stmt->error);
        }
        $stmt->close();
    }

    // Clear the user's cart
    $sql = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to clear cart: " . $stmt->error);
    }
    $stmt->close();

    // Commit transaction
    $conn->commit();

    $response['status'] = 'success';
    $response['message'] = 'Order placed successfully';
} catch (Exception $e) {
    // Rollback transaction
    $conn->rollback();
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

// Close connection
$conn->close();

// Set content type to JSON
header('Content-Type: application/json');

// Return JSON response
echo json_encode($response);
