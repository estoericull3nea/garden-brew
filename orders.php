<?php
session_start();
if (!(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true)) {
    header("Location: http://localhost/garden-brew/login.php?login=false");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Track Order</title>
    <?php require './partials/head.php'; ?>
</head>

<body>
    <?php require './partials/header.php'; ?>

    <div id="customMessage" class="custom-message d-flex align-items-center justify-content-between gap-2">
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-semibold text-center"></p>
        <span id="closeButton"></span>
    </div>

    <!-- Modal view items -->
    <div class="modal fade" id="modal_view_items" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_view_itemsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <table class="table text-center align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Price</th>
                                <th scope="col">Product Quantity</th>
                                <th scope="col">Product Size</th>
                                <th scope="col">Product Total</th>
                            </tr>
                        </thead>
                        <tbody id="modal_table_body_view_items">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="mt-5">
            <nav class="d-flex justify-content-center">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active position-relative" id="nav-pending-tab" data-bs-toggle="tab" data-bs-target="#nav-pending" type="button" role="tab" aria-controls="nav-pending" aria-selected="true">
                        Pending
                    </button>
                    <button class="nav-link" id="nav-approved-tab" data-bs-toggle="tab" data-bs-target="#nav-approved" type="button" role="tab" aria-controls="nav-approved" aria-selected="true">Approved</button>
                    <button class="nav-link" id="nav-going-tab" data-bs-toggle="tab" data-bs-target="#nav-going" type="button" role="tab" aria-controls="nav-going" aria-selected="false">On Going</button>
                    <button class="nav-link" id="nav-delivered-tab" data-bs-toggle="tab" data-bs-target="#nav-delivered" type="button" role="tab" aria-controls="nav-delivered" aria-selected="false">Delivered</button>
                    <button class="nav-link" id="nav-canceled-tab" data-bs-toggle="tab" data-bs-target="#nav-canceled" type="button" role="tab" aria-controls="nav-canceled" aria-selected="false">Canceled</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab" tabindex="0">
                    <div class="mt-5 text-center row" id="pending_card_container">
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab" tabindex="0">
                    <div class="mt-5 text-center row" id="approved_card_container">
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-going" role="tabpanel" aria-labelledby="nav-going-tab" tabindex="0">
                    <div class="mt-5 text-center row" id="ongoing_card_container">
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-delivered" role="tabpanel" aria-labelledby="nav-delivered-tab" tabindex="0">...</div>
                <div class="tab-pane fade" id="nav-canceled" role="tabpanel" aria-labelledby="nav-canceled-tab" tabindex="0">
                    <div class="mt-5 text-center row" id="canceled_card_container">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fetch_pending_orders() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/order/get_pending_orders.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText);

                const pending_card_container = document.getElementById('pending_card_container');
                pending_card_container.innerHTML = '';

                data.forEach(product => {
                    const order_card = `
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Order ID: ${product.order_id}</h5>
                                    <h5 class="card-title">Status: ${product.status}</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><span class="fw-semibold">Customer Name:</span> ${product.fname} ${product.lname}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Address:</span> ${product.address}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Phone Number:</span> ${product.phone_number}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Order Date:</span> ${formatDateTime(product.order_date)}</li>
                                </ul>
                                <div class="card-body">
                                    <a href="#" class="btn btn-sm btn-pink card-link" data-bs-toggle="modal" data-bs-target="#modal_view_items" onclick="show_single_order(${product.order_id})">View Items</a>
                                    <a href="#" class="btn btn-sm btn-danger card-link" onclick="mark_as_cancel(${product.order_id})">Cancel Order</a>
                                </div>
                            </div>
                        </div>
                    `;
                    pending_card_container.innerHTML += order_card;
                });
            };
            xhr.send();
        }

        function show_single_order(order_id) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/order/fetch_single_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText);

                let total_sum = 0;

                const modal_table_body_view_items = document.getElementById('modal_table_body_view_items');
                modal_table_body_view_items.innerHTML = '';

                data.forEach(prod => {
                    const order_cart = `
                        <tr>
                            <td>${prod.prod_name}</td>
                            <td>${prod.prod_price}</td>
                            <td>${prod.prod_qty}</td>
                            <td>${prod.prod_size}</td>
                            <td>${prod.prod_total}</td>
                        </tr>
                    `;
                    modal_table_body_view_items.innerHTML += order_cart;
                    total_sum += parseFloat(prod.prod_total);
                });
                const total_row = `
                            <tr>
                                <td colspan="4" style="text-align: right; font-weight: bold;">Total:</td>
                                <td style="font-weight: bold;">${total_sum.toFixed(2)}</td>
                            </tr>
                        `;
                modal_table_body_view_items.innerHTML += total_row;
            };
            xhr.send(JSON.stringify({
                order_id
            }));
        }

        function mark_as_cancel(order_id) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/order/mark_as_cancel.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.responseText === '1') {
                    fetch_pending_orders();
                    fetch_canceled_orders();
                    get_pending_status();
                    display_custom_toast('Canceled Successfully', 'success', 2000);
                }
            };
            xhr.send(JSON.stringify({
                order_id
            }));
        }

        function fetch_canceled_orders() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/order/fetch_canceled_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText);

                const canceled_card_container = document.getElementById('canceled_card_container');
                canceled_card_container.innerHTML = '';

                data.forEach(product => {
                    const order_card = `
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Order ID: ${product.order_id}</h5>
                                    <h5 class="card-title">Status: ${product.status}</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><span class="fw-semibold">Customer Name:</span> ${product.fname} ${product.lname}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Address:</span> ${product.address}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Phone Number:</span> ${product.phone_number}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Ordered:</span> ${formatDateTime(product.order_date)}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Canceled:</span> ${formatDateTime(product.canceled_at)}</li>
                                </ul>
                                <div class="card-body">
                                    <a href="#" class="btn btn-sm btn-pink card-link" data-bs-toggle="modal" data-bs-target="#modal_view_items" onclick="show_single_order(${product.order_id})">View Items</a>
                                </div>
                            </div>
                        </div>
                    `;
                    canceled_card_container.innerHTML += order_card;
                });
            };
            xhr.send();
        }

        function fetch_approved_order() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/order/fetch_approved_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText);

                const approved_card_container = document.getElementById('approved_card_container');
                approved_card_container.innerHTML = '';

                data.forEach(product => {
                    const order_card = `
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Order ID: ${product.order_id}</h5>
                                    <h5 class="card-title">Status: ${product.status}</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><span class="fw-semibold">Customer Name:</span> ${product.fname} ${product.lname}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Address:</span> ${product.address}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Phone Number:</span> ${product.phone_number}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Order Date:</span> ${formatDateTime(product.order_date)}</li>
                                </ul>
                                <div class="card-body">
                                    <a href="#" class="btn btn-sm btn-pink card-link" data-bs-toggle="modal" data-bs-target="#modal_view_items" onclick="show_single_order(${product.order_id})">View Items</a>
                                    <a href="#" class="btn btn-sm btn-danger card-link" onclick="mark_as_cancel(${product.order_id})">Cancel Order</a>
                                </div>
                            </div>
                        </div>
                    `;
                    approved_card_container.innerHTML += order_card;
                });
            };
            xhr.send();
        }

        function fetch_ongoing_order() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/order/fetch_ongoing_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText);

                const ongoing_card_container = document.getElementById('ongoing_card_container');
                ongoing_card_container.innerHTML = '';

                data.forEach(product => {
                    const order_card = `
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Order ID: ${product.order_id}</h5>
                                    <h5 class="card-title">Status: ${product.status}</h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><span class="fw-semibold">Customer Name:</span> ${product.fname} ${product.lname}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Address:</span> ${product.address}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Phone Number:</span> ${product.phone_number}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Order Date:</span> ${formatDateTime(product.order_date)}</li>
                                </ul>
                                <div class="card-body">
                                    <a href="#" class="btn btn-sm btn-pink card-link" data-bs-toggle="modal" data-bs-target="#modal_view_items" onclick="show_single_order(${product.order_id})">View Items</a>
                                    <a href="#" class="btn btn-sm btn-danger card-link" onclick="mark_as_cancel(${product.order_id})">Cancel Order</a>
                                </div>
                            </div>
                        </div>
                    `;
                    ongoing_card_container.innerHTML += order_card;
                });
            };
            xhr.send();
        }

        document.addEventListener("DOMContentLoaded", () => {
            fetch_pending_orders();
            fetch_canceled_orders();
            fetch_approved_order()
            fetch_ongoing_order()
        });
    </script>
</body>

</html>