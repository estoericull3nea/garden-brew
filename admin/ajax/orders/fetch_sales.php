<?php
session_start();
require '../../../connection/connect.php';

// Get the current day
$current_day = date('d');

// SQL query to fetch all delivered orders for the current day of the month
$sql = "
    SELECT oi.*, o.*, u.*
    FROM order_items AS oi
    JOIN orders AS o ON o.order_id = oi.order_id
    JOIN users AS u ON u.user_id = o.user_id
    WHERE o.status = 'delivered' AND DAY(o.date_delivered) = $current_day
";

$result = $conn->query($sql);

if ($result) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'order_id' => $row['order_id'],
            'prod_name' => $row['prod_name'],
            'prod_price' => $row['prod_price'],
            'prod_qty' => $row['prod_qty'],
            'prod_total' => $row['prod_total'],
            'status' => $row['status'],
            'date_delivered' => $row['date_delivered'],
            'fname' => $row['fname'],
            'lname' => $row['lname'],
            'username' => $row['username'],
            'phone_number' => $row['phone_number'],
            'address' => $row['address']
        ];
    }
    echo json_encode($data);
} else {
    echo json_encode(['error' => $conn->error]);
}

$conn->close();
