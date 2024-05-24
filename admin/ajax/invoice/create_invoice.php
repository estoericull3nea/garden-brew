<?php

require '../../../connection/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $date = $_POST['date'];
    $total = $_POST['total'];
    $items = $_POST['items']; // This will be a JSON string

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO invoices (customer_id, date, total) VALUES ('$customer_id', '$date', '$total')";

    if ($conn->query($sql) === TRUE) {
        $invoice_id = $conn->insert_id;
        $items = json_decode($items, true);

        foreach ($items as $item) {
            $product_name = $item['product_name'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $item_sql = "INSERT INTO invoice_items (invoice_id, product_name, quantity, price) VALUES ('$invoice_id', '$product_name', '$quantity', '$price')";
            $conn->query($item_sql);
        }

        echo "Invoice created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
