<?php
session_start();
if (!(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true)) {
    header("Location: http://localhost/garden-brew/admin/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin</title>
    <?php require './partials/head.php'; ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</head>

<body>

    <main class="d-flex flex-nowrap">
        <?php require './partials/aside.php'; ?>
        <div class="w-100">
            <!-- show table -->
            <div class="table-responsive w-100 p-3">
                <table id="show_users_table" class="caption-top border-0 my-5" style="width:100%; font-size: .7rem; border: 1px solid #ddd;">
                    <caption>Daily Sales Report</caption>
                    <thead class="text-center">
                        <tr>
                            <th class="border-0">Order ID</th>
                            <th class="border-0">Product Name</th>
                            <th class="border-0">Product Price</th>
                            <th class="border-0">Product Quantity</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Customer FullName</th>
                            <th class="border-0">Customer Phone Number</th>
                            <th class="border-0">Customer Address</th>
                            <th class="border-0">Product Total</th>
                        </tr>
                    </thead>
                    <tbody id="show_users_table_body" class="text-center">
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-end" colspan="9"><strong id="total_sum">Total: 0.00</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- show table -->
            <div class="text-end me-4">
                <button id="generate_report" class="btn btn-pink mb-3">Generate Report</button>
            </div>
        </div>
    </main>

    <script>
        function fetch_sales() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/orders/fetch_sales.php', true);
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText);
                if (data) {
                    document.getElementById('show_users_table').style.display = 'table';
                    const tbody = document.getElementById('show_users_table_body');
                    let totalSum = 0;

                    data.forEach(function(row) {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                                <td>${row.order_id}</td>
                                <td>${row.prod_name}</td>
                                <td>${row.prod_price}</td>
                                <td>${row.prod_qty}</td>
                                <td>${row.status}</td>
                                <td>${row.fname} ${row.lname}</td>
                                <td>${row.phone_number}</td>
                                <td>${row.address}</td>
                                <td>${row.prod_total}</td>
                        `;
                        tbody.appendChild(tr);
                        totalSum += parseFloat(row.prod_total);
                    });

                    document.getElementById('total_sum').innerText = `Total: ${totalSum.toFixed(2)}`;

                    var dataTable = new DataTable('#show_users_table', {
                        stateSave: true,
                    });
                }
            };
            xhr.send();
        }

        function printReport() {
            const table = document.getElementById('show_users_table');
            const totalSum = document.getElementById('total_sum').innerText;

            // Clone the table to modify it for the print view
            const printTable = table.cloneNode(true);
            const tfoot = printTable.querySelector('tfoot');
            const totalRow = tfoot.querySelector('tr');
            totalRow.innerHTML = `<td colspan="8" class="text-end"><strong>Total:</strong></td><td><strong>${totalSum}</strong></td>`;

            const printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Daily Sales Report</title>');
            printWindow.document.write('<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">');
            printWindow.document.write('<style>');
            printWindow.document.write('body { font-family: Arial, sans-serif; text-align: center; }');
            printWindow.document.write('table { margin: 0 auto; width: 90%; border-collapse: collapse; text-align: center; border: 1px solid #ddd; }');
            printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; }');
            printWindow.document.write('th { background-color: #f2f2f2; }');
            printWindow.document.write('tfoot td { text-align: right; }');
            printWindow.document.write('caption { font-size: 1.5em; margin: 10px 0; }');
            printWindow.document.write('@page { margin: 0; }');
            printWindow.document.write('body { margin: 1.6cm; }');
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(printTable.outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        document.addEventListener("DOMContentLoaded", () => {
            fetch_sales();
            document.getElementById('generate_report').addEventListener('click', printReport);
        });
    </script>
</body>

</html>
