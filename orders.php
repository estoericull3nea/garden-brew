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


    <!-- Feedback Modal -->
    <div class="modal fade" id="modal_provide_feedback" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_provide_feedbackLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_provide_feedbackLabel">Provide Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea id="feedback_textarea" class="form-control" rows="4" placeholder="Enter your feedback here..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submit_feedback()">Send Feedback</button>
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
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning z-1">
                            <span class="smallest" id="count_pending"></span>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
                    <button class="nav-link position-relative" id="nav-approved-tab" data-bs-toggle="tab" data-bs-target="#nav-approved" type="button" role="tab" aria-controls="nav-approved" aria-selected="true">
                        Approved
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary z-1">
                            <span class="smallest" id="count_approved"></span>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
                    <button class="nav-link position-relative" id="nav-going-tab" data-bs-toggle="tab" data-bs-target="#nav-going" type="button" role="tab" aria-controls="nav-going" aria-selected="false">
                        On Going
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary z-1">
                            <span class="smallest" id="count_ongoing"></span>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
                    <button class="nav-link position-relative" id="nav-canceled-tab" data-bs-toggle="tab" data-bs-target="#nav-canceled" type="button" role="tab" aria-controls="nav-canceled" aria-selected="false">

                        Canceled
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger z-1">
                            <span class="smallest" id="count_canceled"></span>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
                    <button class="nav-link position-relative" id="nav-denied-tab" data-bs-toggle="tab" data-bs-target="#nav-denied" type="button" role="tab" aria-controls="nav-denied" aria-selected="false">

                        Denied
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger z-1">
                            <span class="smallest" id="count_denied"></span>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
                    <button class="nav-link position-relative" id="nav-delivered-tab" data-bs-toggle="tab" data-bs-target="#nav-delivered" type="button" role="tab" aria-controls="nav-delivered" aria-selected="false">
                        Delivered
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success z-1">
                            <span class="smallest" id="count_delivered"></span>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
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
                <div class="tab-pane fade" id="nav-delivered" role="tabpanel" aria-labelledby="nav-delivered-tab" tabindex="0">
                    <div class="mt-5 text-center row" id="fetch_delivered_order">
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-canceled" role="tabpanel" aria-labelledby="nav-canceled-tab" tabindex="0">
                    <div class="mt-5 text-center row" id="canceled_card_container">
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-denied" role="tabpanel" aria-labelledby="nav-denied-tab" tabindex="0">
                    <div class="mt-5 text-center row" id="denied_card_container">
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script>
        let currentOrderID;

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
                                    <h5 class="card-title">Status: <span class="text-warning fs-5 fw-bold"> ${capitalizeFirstLetter(product.status)}</span></h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><span class="fw-semibold">Customer Name:</span> ${product.fname} ${product.lname}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Address:</span> ${product.address}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Phone Number:</span> ${product.phone_number}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Ordered:</span> ${formatDateTime(product.order_date)}</li>
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-sm btn-pink card-link" data-bs-toggle="modal" data-bs-target="#modal_view_items" onclick="show_single_order(${product.order_id})">View Items</button>
                                    <button class="btn btn-sm btn-danger card-link" onclick="mark_as_cancel(${product.order_id})">Cancel Order</button>
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
                                    <h5 class="card-title">Status: <span class="text-danger fs-5 fw-bold"> ${capitalizeFirstLetter(product.status)}</span></h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><span class="fw-semibold">Customer Name:</span> ${product.fname} ${product.lname}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Address:</span> ${product.address}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Phone Number:</span> ${product.phone_number}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Ordered:</span> ${formatDateTime(product.order_date)}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Canceled:</span> ${formatDateTime(product.canceled_at)}</li>
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-sm btn-pink card-link" data-bs-toggle="modal" data-bs-target="#modal_view_items" onclick="show_single_order(${product.order_id})">View Items</button>
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
                                    <h5 class="card-title">Status: <span class="text-primary fs-5 fw-bold"> ${capitalizeFirstLetter(product.status)}</span></h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><span class="fw-semibold">Customer Name:</span> ${product.fname} ${product.lname}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Address:</span> ${product.address}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Phone Number:</span> ${product.phone_number}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Ordered:</span> ${formatDateTime(product.order_date)}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Approved:</span> ${formatDateTime(product.date_approved)}</li>
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-sm btn-pink card-link" data-bs-toggle="modal" data-bs-target="#modal_view_items" onclick="show_single_order(${product.order_id})">View Items</button>
                                    <button class="btn btn-sm btn-danger card-link" onclick="mark_as_cancel(${product.order_id})">Cancel Order</button>
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
                                    <h5 class="card-title">Status: <span class="text-secondary fs-5 fw-bold"> ${capitalizeFirstLetter(product.status)}</span></h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><span class="fw-semibold">Customer Name:</span> ${product.fname} ${product.lname}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Address:</span> ${product.address}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Phone Number:</span> ${product.phone_number}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Ordered:</span> ${formatDateTime(product.order_date)}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Approved:</span> ${formatDateTime(product.date_approved)}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Ongoing Started:</span> ${formatDateTime(product.date_ongoing_started)}</li>
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-sm btn-pink card-link" data-bs-toggle="modal" data-bs-target="#modal_view_items" onclick="show_single_order(${product.order_id})">View Items</button>
                                </div>
                            </div>
                        </div>
                    `;
                    ongoing_card_container.innerHTML += order_card;
                });
            };
            xhr.send();
        }

        function fetch_delivered_order() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/order/fetch_delivered_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText);
                const fetch_delivered_order = document.getElementById('fetch_delivered_order');
                fetch_delivered_order.innerHTML = '';
                data.forEach(product => {
                    console.log(product);
                    const order_card = `
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Order ID: ${product.order_id}</h5>
                                    <h5 class="card-title">Status: <span class="text-success fs-5 fw-bold"> ${capitalizeFirstLetter(product.status)}</span></h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><span class="fw-semibold">Customer Name:</span> ${product.fname} ${product.lname}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Address:</span> ${product.address}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Phone Number:</span> ${product.phone_number}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Ordered:</span> ${formatDateTime(product.order_date)}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Approved:</span> ${formatDateTime(product.date_approved)}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Ongoing Started:</span> ${formatDateTime(product.date_ongoing_started)}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Delivered:</span> ${formatDateTime(product.date_delivered)}</li>
                                    ${product.user_feedback ? ` <li class="list-group-item"><span class="fw-semibold">Your Feedback:</span> ${product.user_feedback}</li>` : `<li class="list-group-item"><span class="fw-semibold">Your Feedback:</span> No Feedback Provided</li>`}
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-sm btn-pink card-link" data-bs-toggle="modal" data-bs-target="#modal_view_items" onclick="show_single_order(${product.order_id})">View Items</button>
                                    ${!product.user_feedback ? `<button class="btn btn-sm btn-outline-pink card-link" onclick="make_feedback(${product.order_id})" data-bs-toggle="modal" data-bs-target="#modal_provide_feedback">Provide Feedback</button>` : ``}
                                </div>
                            </div>
                        </div>
                    `;
                    fetch_delivered_order.innerHTML += order_card;
                });
            };
            xhr.send();
        }

        function make_feedback(order_id) {
            currentOrderID = order_id;
        }

        function submit_feedback() {
            const feedback = document.getElementById('feedback_textarea').value;
            if (!feedback) {
                alert('Please enter your feedback before submitting.');
                return;
            }
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/order/make_feedback.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.responseText === '1') {
                    display_custom_toast('Feedback submitted successfully', 'success', 2000);
                    document.getElementById('feedback_textarea').value = '';
                    hideModal('modal_provide_feedback')
                    fetch_delivered_order()
                } else {
                    alert('Failed to submit feedback. Please try again.');
                }
            };
            xhr.send(JSON.stringify({
                order_id: currentOrderID,
                feedback: feedback
            }));
        }

        function fetch_denied_order() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/order/fetch_denied_order.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText);
                const fetch_denied_order = document.getElementById('denied_card_container');
                fetch_denied_order.innerHTML = '';
                data.forEach(product => {
                    const order_card = `
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Order ID: ${product.order_id}</h5>
                                    <h5 class="card-title">Status: <span class="text-success fs-5 fw-bold"> ${capitalizeFirstLetter(product.status)}</span></h5>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><span class="fw-semibold">Customer Name:</span> ${product.fname} ${product.lname}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Address:</span> ${product.address}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Phone Number:</span> ${product.phone_number}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Ordered:</span> ${formatDateTime(product.order_date)}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Date Denied:</span> ${formatDateTime(product.date_denied)}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Feedback:</span> ${product.why_denied}</li>
                                </ul>
                                <div class="card-body">
                                    <button class="btn btn-sm btn-pink card-link" data-bs-toggle="modal" data-bs-target="#modal_view_items" onclick="show_single_order(${product.order_id})">View Items</button>
                                    ${(product.status !== 'delivered' && product.status !== 'denied' ) ? ` <button class="btn btn-sm btn-danger card-link" onclick="mark_as_cancel(${product.order_id})">Cancel Order</button>` : ``}
                                </div>
                            </div>
                        </div>
                    `;
                    fetch_denied_order.innerHTML += order_card;
                });
            };
            xhr.send();
        }

        function count_pending() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/count/count_pending_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                document.getElementById('count_pending').textContent = xhr.responseText
            };
            xhr.send()
        }

        function count_approved() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/count/count_approved_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                document.getElementById('count_approved').textContent = xhr.responseText
            };
            xhr.send()
        }

        function count_ongoing() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/count/count_ongoing_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                document.getElementById('count_ongoing').textContent = xhr.responseText
            };
            xhr.send()
        }

        function count_canceled() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/count/count_canceled_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                document.getElementById('count_canceled').textContent = xhr.responseText
            };
            xhr.send()
        }

        function count_delivered() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/count/count_delivered_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                document.getElementById('count_delivered').textContent = xhr.responseText
            };
            xhr.send()
        }

        function count_denied() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/count/count_denied_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                document.getElementById('count_denied').textContent = xhr.responseText
            };
            xhr.send()
        }

        document.addEventListener("DOMContentLoaded", () => {
            fetch_pending_orders();
            fetch_canceled_orders();
            fetch_approved_order();
            fetch_ongoing_order();
            fetch_delivered_order();
            count_pending();
            count_approved();
            count_ongoing();
            count_canceled();
            count_delivered();
            count_denied();
            fetch_denied_order();
        });
    </script>
</body>

</html>