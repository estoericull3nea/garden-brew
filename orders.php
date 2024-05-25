<?php
session_start();
if (!(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true)) {
    header("Location: http://localhost/garden-brew/login.php");
    exit(); // Always call exit after header to stop further execution
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

    <!-- Modal view items-->
    <div class="modal fade" id="modal_view_items" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_view_itemsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="container ">
        <div class="mt-5 ">
            <nav class="d-flex justify-content-center ">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Pending</button>
                    <button class="nav-link " id="nav-approved-tab" data-bs-toggle="tab" data-bs-target="#nav-approved" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Approved</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">On Going</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Delivered</button>

                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                    <div class="mt-5 text-center row" id="card_container">

                    </div>
                </div>
                <div class="tab-pane fade " id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab" tabindex="0">...</div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">...</div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">...</div>
            </div>
        </div>
    </div>

    <script>
        function fetch_pending_orders() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/order/get_pending_orders.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText)

                const card_container = document.getElementById('card_container')
                card_container.innerHTML = ''

                data.forEach(product => {
                    console.log(product);
                    const order_card = `
                        <div class="col-3">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">Order ID: ${product.order_id}</h5>
                                    <h5 class="card-title">Status: ${product.status}</h5>
                                    <!-- <p class="card-text">
                                        <span class="fw-semibold">Notes:</span> <br>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum rem enim officiis voluptate natus asperiores qui, suscipit voluptates? Temporibus cupiditate deleniti, soluta laborum corrupti hic! Quisquam hic ea deserunt veniam.
                                    </p> -->
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><span class="fw-semibold">Customer Name:</span> ${product.fname} ${product.lname}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Address:</span> ${product.address}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Customer Phone Number:</span> ${product.phone_number}</li>
                                    <li class="list-group-item"><span class="fw-semibold">Orde Date:</span> ${formatDateTime(product.order_date)}</li>
                                </ul>
                                <div class="card-body">
                                    <a href="#" class="btn btn-sm btn-pink card-link" data-bs-toggle="modal" data-bs-target="#modal_view_items">View Items</a>
                                    <a href="#" class="btn btn-sm btn-danger card-link">Cancel Order</a>
                                </div>
                            </div>
                        </div>

                    `;
                    card_container.innerHTML += order_card;
                });
            }
            xhr.send()

        }

        addEventListener("DOMContentLoaded", () => {
            fetch_pending_orders()
        })
    </script>
</body>

</html>