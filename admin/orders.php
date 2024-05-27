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

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-section,
            #print-section * {
                visibility: visible;
            }

            #print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            @page {
                margin: 0;
                size: auto;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div id="customMessage" class="custom-message d-flex align-items-center justify-content-between gap-2 ">
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-semibold text-center"></p>
        <span id="closeButton"></span>
    </div>

    <main class="d-flex flex-nowrap">
        <?php require './partials/aside.php'; ?>
        <div class="w-100 mt-5">
            <div class="table-responsive w-100 p-3 ">
                <table id="show_pending_table" class="caption-top border-0 my-5" style="width:100%; font-size: .7rem;">
                    <caption>List of All Orders</caption>
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
        </div>
    </main>

    <div class="modal fade" id="modal_view_single_order" tabindex="-1" aria-labelledby="modal_view_single_orderLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="print-section">
                        <table class="table text-center align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Customer FullName</th>
                                    <th scope="col">Customer Phone Number</th>
                                    <th scope="col">Customer Address</th>
                                    <th scope="col">Customer Feedback</th>
                                    <th scope="col">Payment Mode</th>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-dark" data-bs-dismiss="modal">Close</button>
                    <button id="printButton" type="button" class="btn btn-sm btn-dark" onclick="printReceipt()">Print Receipt</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal notes deny -->
    <div class="modal fade" id="modal_mark_as_denied" tabindex="-1" aria-labelledby="modal_mark_as_deniedLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Why Deny? <span class="text-danger">*</span> </label>
                        <textarea class="form-control shadow-none" id="message_deny" rows="3" name="message_deny" placeholder="Spamming..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="submitDeny()">Deny</button>
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

                    const tbody = document.getElementById('show_pending_orders');
                    const table = document.getElementById('show_pending_table');

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
                          <td class="${row.status === 'pending' ? `text-warning fw-bold` : row.status === 'approved' ? `text-primary fw-bold` : row.status === 'delivered' ? `text-success fw-bold` : row.status === 'canceled' ? `text-danger fw-bold` : row.status === 'denied' ? `text-danger fw-bold` : `text-secondary fw-bold`}" >${capitalizeFirstLetter(row.status)}</td>
                          <td>${formatDateTime(row.order_date)}</td>
                          <td class="d-flex align-items-center justify-content-center gap-1">
                                ${row.status === 'pending' ? `<button onclick="mark_as_approved('${row.order_id}', ${row.user_id})" class="btn btn-sm btn-outline-dark smallest rounded-5">Approved</button>` : row.status === 'approved' ? `<button onclick="mark_as_ongoing('${row.order_id}', ${row.user_id})" class="btn btn-sm btn-outline-dark smallest rounded-5">Go</button>` : row.status === 'ongoing' ? `<button onclick="mark_as_complete('${row.order_id}', ${row.user_id})" class="btn btn-sm btn-outline-dark smallest rounded-5">Mark as Delivered</button>` : ``}
                                ${row.status === 'pending' ? `<button onclick="openDenyModal('${row.order_id}', ${row.user_id})" class="btn btn-sm btn-outline-dark smallest rounded-5" data-bs-toggle="modal" data-bs-target="#modal_mark_as_denied">Deny</button>` : ``}
                                <button class="btn btn-sm btn-outline-dark smallest rounded-5" onclick="view_single_order('${row.order_id}','${row.user_id}','${row.status}')" data-bs-toggle="modal" data-bs-target="#modal_view_single_order">View Items</button>
                          </td>
                        `;
                        tbody.appendChild(tr);
                    });
                    var dataTable = new DataTable(table, {
                        stateSave: true,
                    });
                }
            }
            xhr.send()
        }

        function view_single_order(order_id, user_id, status) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/orders/view_single_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText);
                const table_modal_showing_items = document.getElementById('table_modal_showing_items');
                table_modal_showing_items.innerHTML = '';

                let total_price = 0;
                let customer_info = '';

                data.forEach((item, index) => {
                    if (index === 0) {
                        customer_info = `
                            <tr>
                                <td>${item.fname} ${item.lname}</td>
                                <td>${item.phone_number}</td>
                                <td>${item.address}</td>
                                <td>${item.user_feedback ? item.user_feedback : 'No Feedback Provided'}</td>
                                <td>${item.payment_mode}</td>
                                <td>${item.prod_name}</td>
                                <td>${item.prod_price}</td>
                                <td>${item.prod_size}</td>
                                <td>${item.prod_qty}</td>
                                <td>${item.prod_total}</td>
                            </tr>
                        `;
                    } else {
                        customer_info += `
                            <tr>
                                <td colspan="5"></td>
                                <td>${item.prod_name}</td>
                                <td>${item.prod_price}</td>
                                <td>${item.prod_size}</td>
                                <td>${item.prod_qty}</td>
                                <td>${item.prod_total}</td>
                            </tr>
                        `;
                    }
                    total_price += parseFloat(item.prod_total);
                });

                const totalRow = `
                    <tr>
                        <td colspan="9" class="text-end"><strong>Total Price:</strong></td>
                        <td><strong>${total_price.toFixed(2)}</strong></td>
                    </tr>
                `;
                table_modal_showing_items.innerHTML = customer_info + totalRow;

                // Disable the print button if the status is pending
                const printButton = document.getElementById('printButton');
                if (status === 'pending' || status === 'denied') {
                    printButton.disabled = true;
                } else {
                    printButton.disabled = false;
                }
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


        function printReceipt() {
            const printContents = document.getElementById('print-section').innerHTML;
            const originalContents = document.body.innerHTML;
            const printWindow = window.open('', '', 'height=600,width=800');

            printWindow.document.write('<html><head><title>Print Receipt</title>');
            printWindow.document.write(`
                    <style>
                        @media print {
                            body { font-size: 0.7rem; }
                            table { width: 100%; border-collapse: collapse; }
                            th, td { border: 1px solid black; padding: 8px; text-align: center; }
                            .shop-name { text-align: center; font-size: 1.2rem; font-weight: bold; margin-bottom: 20px; }
                            .total-row { text-align: right; }
                            @page { margin: 0; }
                            body { margin: 0; }
                            header, footer { display: none; }
                        }
                    </style>
                `);
            printWindow.document.write('</head><body>');
            printWindow.document.write('<div class="shop-name">Garden Brew</div>');
            printWindow.document.write(printContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        let currentOrderId;
        let currentUserId;

        function openDenyModal(orderId, userId) {
            currentOrderId = orderId;
            currentUserId = userId;
        }


        function submitDeny() {
            const message = document.getElementById('message_deny').value;

            if (message.trim().length === 0) {
                display_custom_toast('Message is required', 'danger', 2000);
                return
            }


            mark_as_deny(currentOrderId, currentUserId, message);
        }

        function mark_as_deny(order_id, user_id, message) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/orders/mark_as_denied.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.responseText === '1') {
                    show_all_pending_orders();
                    display_custom_toast('Denied', 'success', 2000);
                    hideModal('modal_mark_as_denied')
                }
                console.log(xhr.responseText);
            };
            xhr.send(JSON.stringify({
                order_id,
                user_id,
                message
            }));
        }


        document.addEventListener("DOMContentLoaded", () => {
            show_all_pending_orders()


            // Add event listener to the textarea to submit on Enter key press
            const messageDenyTextarea = document.getElementById('message_deny');
            messageDenyTextarea.addEventListener('keydown', function(event) {

                if (event.key === 'Enter') {

                    if (messageDenyTextarea.value.trim().length === 0) {
                        display_custom_toast('Message is required', 'danger', 2000);
                        return
                    }



                    event.preventDefault(); // Prevent the default action of Enter key
                    submitDeny();
                }
            });
        });
    </script>
</body>

</html>
