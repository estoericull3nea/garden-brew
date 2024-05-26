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


    <div id="customMessage" class="custom-message d-flex align-items-center justify-content-between gap-2 ">
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-normal text-center"></p>
        <span id="closeButton"></span>
    </div>


    <main class="d-flex flex-nowrap">
        <?php require './partials/aside.php'; ?>
        <div class="w-100 mt-5">
            <!-- show table -->
            <!-- <h1 id="display_no_students" class="mb-0 text-center">No Registered Students</h1> -->
            <div class="table-responsive w-100 p-3 ">
                <table id="show_pending_table" class="caption-top border-0 my-5" style="width:100%; font-size: .7rem;">
                    <caption>List of Pending Orders</caption>
                    <thead class="text-center ">
                        <tr>
                            <th class="border-0">Order ID</th>
                            <th class="border-0">Customer FullName</th>
                            <th class="border-0">Customer Phone Number</th>
                            <th class="border-0">Customer Address</th>
                            <th class="border-0">Payment Mode</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Ordered At</th>
                            <th class="border-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="show_pending_orders" class="text-center">
                    </tbody>
                </table>
            </div>
            <!-- show table -->
        </div>
    </main>


    <script>
        function show_all_pending_orders() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/orders/fetch_pending_orders.php', true);
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText)
                if (data) {
                    document.getElementById('show_pending_table').style.display = 'table'
                    // document.getElementById('display_no_students').style.display = 'none'


                    const tbody = document.getElementById('show_pending_orders');
                    const table = document.getElementById('show_pending_table');


                    // Check if DataTable instance exists and destroy it
                    if ($.fn.DataTable.isDataTable(table)) {
                        $(table).DataTable().destroy();
                        tbody.innerHTML = '';
                    }


                    data.forEach(function(row) {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                          <td>${row.order_id}</td>
                          <td>${row.fname} ${row.lname}</td>
                          <td>${row.phone_number}</td>
                          <td>${row.address}</td>
                          <td>${row.payment_mode}</td>
                          <td>${row.status}</td>
                          <td>${formatDateTime(row.order_date)}</td>
                          <td>
                                ${row.status === 'pending' ? `<button onclick="mark_as_approved('${row.order_id}', ${row.user_id})" class="btn btn-sm btn-outline-dark smallest rounded-5">Approved</button>` : ``}
                          </td>

                        `;


                        tbody.appendChild(tr);
                    });


                    // Reinitialize DataTables after adding rows
                    var dataTable = new DataTable(table, {
                        stateSave: true,
                    });
                }
            }
            xhr.send()
        }

        function mark_as_approved(order_id, user_id) {

            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/orders/mark_as_approved.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.responseText === '1') {
                    show_all_pending_orders()
                    display_custom_toast('Approved', 'success', 2000)
                }
            }
            xhr.send(JSON.stringify({
                order_id,
                user_id
            }))

        }

        document.addEventListener("DOMContentLoaded", () => {
            show_all_pending_orders()
        });
    </script>

</body>

</html>