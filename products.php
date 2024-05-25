<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Products</title>
    <?php require './partials/head.php'; ?>

    <style>
        /* nav pills */
        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: var(--bs-nav-pills-link-active-color);
            background-color: #fe72a7;
        }

        .nav-pills .nav-link {
            color: black;
        }

        /* nav pills */

        #bg-img {
            background: url('./assets/images/gb_logo-transparent.png');
            background-repeat: no-repeat;
            background-position: center center;

            position: absolute;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100%;
            z-index: -1;

            filter: blur(2px);
        }

        /* card */
        .card {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Hide the up and down arrows for number inputs */
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
            /* Firefox */
        }
    </style>
</head>

<body>
    <?php require './partials/header.php'; ?>

    <div id="customMessage" class="custom-message d-flex align-items-center justify-content-between gap-2 ">
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-normal text-center"></p>
        <span id="closeButton"></span>
    </div>

    <div id="bg-img"></div>

    <div class="products mt-5">
        <div class="container">
            <ul class="nav nav-pills mb-3 text-center d-flex justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Milktea</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Hot Coffee</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Other</button>
                </li>
            </ul>

            <hr>

            <div class="tab-content mt-5" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                    <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills me-5 w-50" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Classic Milktea</button>
                            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Special Milktea</button>
                            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Premium Milktea</button>
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                                <div class="classic_milktea_container">
                                    <div>
                                        <div class="row" id="classic_milktea"></div>
                                    </div>
                                    <hr>
                                    <div>
                                        <h1>Special Milktea</h1>
                                    </div>
                                    <div>
                                        <h1>Premium Milktea</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">...</div>
                            <div class="tab-pane fade" id="v-pills-disabled" role="tabpanel" aria-labelledby="v-pills-disabled-tab" tabindex="0">...</div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0"></div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">...</div>
            </div>
        </div>
    </div>

    <script>
        function fetch_classic_milktea() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/products/fetch_classic_milktea.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const classic_milktea = document.getElementById('classic_milktea');
                classic_milktea.innerHTML = '';

                const data = JSON.parse(xhr.responseText);
                data.forEach(product => {
                    const product_card = `
                    <div class="col-12 col-md-6 col-xl-4 mb-3">
                        <div class="card" role="button">
                            <img src="./assets/images/milktea/classic/${product.prod_img}" class="card-img-top" alt="${product.prod_img}" style="height: 250px;">
                            <div class="card-body">
                                <h5 class="card-title fw-semibold">${product.prod_name}</h5>
                                <p class="card-text smaller">${product.prod_desc}</p>
                                <form onsubmit="add_cart(event, '${product.prod_id}', this)" method="POST" data-prod-img="${product.prod_img}">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label for="size-${product.prod_id}" class="form-label smaller">Select size</label>
                                                <select id="size-${product.prod_id}" name="size" class="form-select shadow-none smaller" role="button" onchange="updatePrice('${product.prod_id}')">
                                                    <option role="button" value="16">16oz</option>
                                                    <option role="button" value="20">20oz</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 my-2">
                                            <p class="card-text fw-medium" id="price-${product.prod_id}">${product.prod_price == 0 ? '39' : product.prod_price} Pesos</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <button type="button" class="btn btn-outline-pink" onclick="decrease_quantity(this)">-</button>
                                        <input readonly type="number" name="quantity" class="form-control mx-2 shadow-none" value="1" min="1" style="width: 60px; text-align: center; border-color: #ff70a6; -moz-appearance: textfield;">
                                        <button type="button" class="btn btn-outline-pink" onclick="increase_quantity(this)">+</button>
                                    </div>
                                    <button type="submit" class="btn btn-pink mt-2">Add to cart</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    `;
                    classic_milktea.innerHTML += product_card;
                });
            };
            xhr.send();
        }

        function add_cart(event, prod_id, form) {
            event.preventDefault();

            const user_id = <?= json_encode($_SESSION['user_id']); ?>;
            const prod_name = form.closest('.card-body').querySelector('.card-title').textContent;
            const size = form.querySelector('select[name="size"]').value;
            const quantity = form.querySelector('input[name="quantity"]').value;
            const price = size === '16' ? 39 : 49;
            const prod_total = price * quantity;
            const prod_img = form.getAttribute('data-prod-img'); 

            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/cart/add_to_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.responseText === '1') {
                    form.reset();
                    get_total_cart();
                    display_custom_toast('Added to Cart', 'success', 2000);
                }
            };
            xhr.send(JSON.stringify({
                prod_id,
                user_id,
                prod_name,
                prod_price: price,
                prod_size: size,
                prod_total,
                prod_qty: quantity,
                prod_img // Include the product image in the JSON payload
            }));
        }


        function decrease_quantity(button) {
            const input = button.nextElementSibling;
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function increase_quantity(button) {
            const input = button.previousElementSibling;
            input.value = parseInt(input.value) + 1;
        }

        function updatePrice(productId) {
            const sizeSelect = document.getElementById(`size-${productId}`);
            const priceElement = document.getElementById(`price-${productId}`);
            const selectedSize = sizeSelect.value;

            let newPrice;
            if (selectedSize === '16') {
                newPrice = 39;
            } else {
                newPrice = 49;
            }

            priceElement.textContent = `${newPrice} Pesos`;
        }

        addEventListener("DOMContentLoaded", () => {
            fetch_classic_milktea();
        });
    </script>
</body>

</html>