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

        /* card */
    </style>
</head>

<body>
    <?php
    require './partials/header.php';
    ?>

    <div id="customMessage" class="custom-message d-flex align-items-center justify-content-between gap-2 ">
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-normal text-center"></p>
        <span id="closeButton"></span>
    </div>


    <div id="bg-img"></div>

    <div class="products mt-5">

        <div class="container">

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
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

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                    <div class="mt-5">
                        <div>
                            <h1 class="mb-3">Classic Milktea</h1>
                            <div class="row" id="classic_milktea">

                            </div>
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
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">...</div>
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

                const classic_milktea = document.getElementById('classic_milktea')
                classic_milktea.innerHTML = ``

                const data = JSON.parse(xhr.responseText)
                data.forEach(product => {
                    const product_card = `
                        <div class="col-12 col-md-6 col-xl-3 mb-3">
                            <div class="card" role="button">
                                <img src="./assets/images/milktea/classic/${product.prod_img}" class="card-img-top" alt="${product.prod_img}" style="height: 300px;">
                                <div class="card-body">
                                    <h5 class="card-title fw-semibold">${product.prod_name}</h5>
                                    <p class="card-text fw-medium">${product.prod_price} Pesos</p>

                                    <form onsubmit="add_cart(event, '${product.prod_id}', this)" method="POST">
                                        <div class="d-flex align-items-center mb-2">
                                            <button type="button" class="btn btn-outline-secondary" onclick="decrease_quantity(this)">-</button>
                                            <input type="number" name="quantity" class="form-control mx-2" value="1" min="1" style="width: 60px; text-align: center;">
                                            <button type="button" class="btn btn-outline-secondary" onclick="increase_quantity(this)">+</button>
                                        </div>
                                        <button type="submit" class="btn btn-pink">Add to cart</button>
                                    </form>

                                    

                                </div>
                            </div>
                        </div>
                   `
                    classic_milktea.innerHTML += product_card;
                })
            }
            xhr.send()
        }

        function add_cart(event, prod_id, form) {
            event.preventDefault()

            const user_id = <?= json_encode($_SESSION['user_id']); ?>;
            const quantity = form.querySelector('input[name="quantity"]').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/products/add_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.responseText === '1') {
                    form.reset()
                    get_total_cart()
                    display_custom_toast('Added to Cart', 'success', 2000)
                }
            }
            xhr.send(JSON.stringify({
                prod_id,
                user_id,
                quantity
            }))

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

        function fetch_cart() {

        }

        function remove_cart() {

        }

        function clear_cart() {

        }

        function decrease_quantity() {

        }


    

        addEventListener("DOMContentLoaded", () => {
            fetch_classic_milktea()

        });
    </script>
</body>

</html>