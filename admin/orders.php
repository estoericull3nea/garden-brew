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

    <!-- Modal view single order -->
    <div class="modal fade" id="modal_view_single_order" tabindex="-1" aria-labelledby="modal_view_single_orderLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <table class="table text-center align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Price</th>
                                <th scope="col">Product Size</th>
                                <th scope="col">Product Quantity</th>
                                <th scope="col">Product Total</th>
                            </tr>
                        </thead>
                        <tbody id="table_modal_showing_items">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        function show_all_pending_orders() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/orders/fetch_orders.php', true);
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
                          <td class="${row.status === 'pending' ? `text-warning fw-bold` : row.status === 'approved' ? `text-primary fw-bold` : row.status === 'delivered' ? `text-success fw-bold` : row.status === 'canceled' ? `text-danger fw-bold` : `text-secondary fw-bold`}" >${row.status}</td>
                          <td>${formatDateTime(row.order_date)}</td>
                          <td class="d-flex align-items-center justify-content-center gap-1">
                                ${row.status === 'pending' ? `<button onclick="mark_as_approved('${row.order_id}', ${row.user_id})" class="btn btn-sm btn-outline-dark smallest rounded-5">Approved</button>` : row.status === 'approved' ? `<button onclick="mark_as_ongoing('${row.order_id}', ${row.user_id})" class="btn btn-sm btn-outline-dark smallest rounded-5">Go</button>` : row.status === 'ongoing' ? `<button onclick="mark_as_complete('${row.order_id}', ${row.user_id})" class="btn btn-sm btn-outline-dark smallest rounded-5">Mark as Delivered</button>` : ``}
                                <button class="btn btn-sm btn-outline-dark smallest rounded-5" onclick="view_single_order('${row.order_id}','${row.user_id}')" data-bs-toggle="modal" data-bs-target="#modal_view_single_order">View Items</button>
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

        function view_single_order(order_id, user_id) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/orders/view_single_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText);
                const table_modal_showing_items = document.getElementById('table_modal_showing_items');
                table_modal_showing_items.innerHTML = '';

                let total_price = 0;

                data.forEach(item => {
                    const card = `
                <tr>
                    <td>${item.prod_name}</td>
                    <td>${item.prod_price}</td>
                    <td>${item.prod_size}</td>
                    <td>${item.prod_qty}</td>
                    <td>${item.prod_total}</td>
                </tr>
            `;
                    table_modal_showing_items.innerHTML += card;
                    total_price += parseFloat(item.prod_total); // Accumulate the total price
                });

                // Add a row for the total price
                const totalRow = `
                    <tr class="text-end">
                        <td colspan="5"><strong>Total Price: ${total_price.toFixed(2)}</strong></td>
                    </tr>
                `;
                table_modal_showing_items.innerHTML += totalRow;
            };
            xhr.send(JSON.stringify({
                order_id,
                user_id
            }));
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

        function mark_as_ongoing(order_id, user_id) {

            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/orders/mark_as_ongoing.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.responseText === '1') {
                    show_all_pending_orders()
                    display_custom_toast('On Going', 'success', 2000)
                }
            }
            xhr.send(JSON.stringify({
                order_id,
                user_id
            }))

        }

        function mark_as_complete(order_id, user_id) {

            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/orders/mark_as_complete.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.responseText === '1') {
                    show_all_pending_orders()
                    display_custom_toast('Completed', 'success', 2000)
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