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
                        <th scope="col">Customer Name</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Product Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="table_show_cart">

                </tbody>
            </table>
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

                data.forEach(cart => {
                    const cart_item = `
                        <tr>
                            <td>${cart.fname} ${cart.lname}</td>
                            <td>${cart.prod_name}</td>
                            <td>${cart.qty}</td>
                            <td>${cart.prod_price}</td>
                            <td><img src="./assets/images/milktea/classic/${cart.prod_img}" style="height: 90px; width: 90px;"></td>
                            <td>
                                <button class="btn btn-sm btn-pink" onclick="remove_cart(${cart.cart_id})">Remove</button>
                            </td>
                        </tr>
                    `
                    table_show_cart.innerHTML += cart_item
                })
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

        addEventListener("DOMContentLoaded", () => {
            fetch_cart()
        });
    </script>
</body>

</html>