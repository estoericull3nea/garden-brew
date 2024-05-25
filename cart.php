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
    <title>Cart</title>
    <?php require './partials/head.php'; ?>
</head>

<body>
    <?php require './partials/header.php'; ?>

    <div id="customMessage" class="custom-message d-flex align-items-center justify-content-between gap-2 ">
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-normal text-center"></p>
        <span id="closeButton"></span>
    </div>

    <div class="cart mt-5">
        <div class="container">
            <h1 class="mb-5">Your Cart</h1>
            <table class="table text-center align-middle">
                <thead>
                    <tr>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Quantity</th>
                        <th scope="col">Product Size</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Product Image</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="table_show_cart">

                </tbody>
            </table>

            <!-- <div class="text-end mt-4">
                <button class="btn btn-pink">Order it now!</button>
            </div> -->

            <div class="d-flex flex-column align-items-end gap-3 mt-4 mb-5">
                <div>
                    <label for="paymentMode" class="fw-medium">Select Mode of Payment:</label>
                    <select id="paymentMode" class="form-select shadow-none" role="button" style="border-color: #ff70a6;">
                        <option value="cod">Cash on Delivery</option>
                        <option value="gcash">GCash</option>
                    </select>
                </div>
                <button id="orderButton" class="btn btn-pink"  data-bs-toggle="modal" data-bs-target="#order_now_modal">Order It Now</button>
            </div>

        </div>
    </div>


    <!-- Modal Confirmation-->
    <div class="modal fade" id="order_now_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="order_now_modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Are you sure to order now?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-pink" id="order_now" onclick="order_now()">Order Now</button>
                </div>
            </div>
        </div>
    </div>



    <script>
        function fetch_cart() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/cart/fetch_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText)
                const table_show_cart = document.getElementById('table_show_cart')
                table_show_cart.innerHTML = ''

                let totalPrice = 0;

                if (data.length === 0) {
                    paymentMode.disabled = true;
                    orderButton.disabled = true;
                } else {
                    paymentMode.disabled = false;
                    orderButton.disabled = false;
                }

                data.forEach(cart => {
                    const prod_img_path = cart.category === 'Classic' ? 'classic' : cart.category === 'Special' ? 'special' : cart.category === 'Premium' ? 'premium' : cart.category === 'Hot' ? 'hot' : 'other';
                    const cart_item = `
                        <tr>
                            <td>${cart.prod_name}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <button class="qty btn btn-outline-secondary btn-sm" onclick="update_quantity(${cart.cart_id}, ${cart.prod_qty - 1})">-</button>
                                    <input type="number" value="${cart.prod_qty}" min="1" class="qty form-control mx-2" style="width: 60px; text-align: center;" disabled>
                                    <button class="qty btn btn-outline-secondary btn-sm" onclick="update_quantity(${cart.cart_id}, ${cart.prod_qty + 1})">+</button>
                                </div>
                            </td>
                            <td>${cart.prod_size}</td>
                            <td>${cart.prod_price}</td>
                            <td><img src="./assets/images/milktea/${prod_img_path}/${cart.prod_img}" style="height: 90px; width: 90px;"></td>
                            <td>${cart.prod_total}</td>
                            <td>
                                <button class="btn btn-sm btn-pink" onclick="remove_cart(${cart.cart_id})">Remove</button>
                            </td>
                        </tr>
                    `
                    table_show_cart.innerHTML += cart_item
                    totalPrice += parseFloat(cart.prod_total);
                })
                // Add the total price row
                const total_row = `
                                <tr>
                                    <td colspan="6" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold">${totalPrice.toFixed(2)}</td>
                                    <td></td>
                                </tr>
                            `;
                table_show_cart.innerHTML += total_row;
            }
            xhr.send()
        }

        function remove_cart(cart_id) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/cart/remove_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.responseText === '1') {
                    fetch_cart()
                    display_custom_toast('Successfully Removed Cart', 'success', 2000)
                    get_total_cart()
                }

            }
            xhr.send(JSON.stringify({
                cart_id
            }))
        }

        function update_quantity(cart_id, new_quantity) {
            if (new_quantity < 1) return;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/cart/update_quantity.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.responseText === '1') {
                    fetch_cart();
                }
            };
            xhr.send(JSON.stringify({
                cart_id,
                qty: new_quantity
            }));
        }

        function order_now() {
            const paymentMode = document.getElementById('paymentMode').value;
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/cart/order_now.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    display_custom_toast('Order placed successfully', 'success', 3000);
                    fetch_cart();
                } else {
                    display_custom_toast('Failed to place order', 'error', 2000);
                }
            };
            xhr.send(JSON.stringify({
                paymentMode
            }));
        }

      

        addEventListener("DOMContentLoaded", () => {
            fetch_cart()
        });
    </script>
</body>

</html>