<?php

require '../../../connection/connect.php';

if (isset($_GET['invoice_id'])) {
    $invoice_id = $_GET['invoice_id'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM invoices WHERE id = '$invoice_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $invoice = $result->fetch_assoc();
        $customer_id = $invoice['customer_id'];
        $date = $invoice['date'];
        $total = $invoice['total'];

        echo "<h1>Invoice</h1>";
        echo "Customer ID: $customer_id<br>";
        echo "Date: $date<br>";
        echo "Total: $total<br>";

        $item_sql = "SELECT * FROM invoice_items WHERE invoice_id = '$invoice_id'";
        $item_result = $conn->query($item_sql);

        if ($item_result->num_rows > 0) {
            echo "<h2>Items</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>";

            while ($item = $item_result->fetch_assoc()) {
                echo "<tr>
                        <td>{$item['product_name']}</td>
                        <td>{$item['quantity']}</td>
                        <td>{$item['price']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No items found";
        }
    } else {
        echo "Invoice not found";
    }

    $conn->close();
}
