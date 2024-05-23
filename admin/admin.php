<?php
// session_start();
// if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
//     header("Location: http://localhost/garden-brew/");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Item Inventory</title>
    <?php require './partials/head.php'; ?>
    <style>
        .middle {
            height: 100vh;

            display: grid;
            place-content: center;
        }
    </style>
</head>

<body>


    <div id="customMessage" class="custom-message d-flex align-items-center justify-content-between gap-2 ">
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-normal text-center"></p>
        <span id="closeButton"></span>
    </div>


    <main class="d-flex flex-nowrap ">

        <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px;">
            <a href="http://localhost/garden-brew/admin/admin.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <span class="fs-4 fw-bold text-pink">Garden Brew</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="http://localhost/garden-brew/admin/admin.php" class="nav-link text-pink" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16">
                            <use xlink:href="#home" />
                        </svg>
                        Item Inventory
                    </a>
                </li>
                <li>
                    <a href="http://localhost/garden-brew/admin/customer.php" class="nav-link text-pink">
                        <svg class="bi pe-none me-2" width="16" height="16">
                            <use xlink:href="#speedometer2" />
                        </svg>
                        Customer Info
                    </a>
                </li>
            </ul>
            <hr>

        </div>

        <div class="w-100 container">
            <table class="table text-center align-middle">
                <thead>
                    <tr>
                        <th scope="col">Product ID</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Stocks</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="all_prods">

                </tbody>
            </table>
        </div>



    </main>

    <!-- Modal add stock -->
    <div class="modal fade" id="modal_add_stock" tabindex="-1" aria-labelledby="modal_add_stockLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_add_stockLabel">Adding stock</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_change_stock" method="POST">
                        <input type="hidden" id="product_id" name="prod_id">
                        <div class="mb-3">
                            <label class="form-label">Input number of stock to be add</label>
                            <input type="number" class="form-control form-control-sm shadow-none" id="stock_quantity" name="stock">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-pink">Add</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



    <script>
        function fetch_products() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/products/fetch_products.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {

                const all_prods = document.getElementById('all_prods')
                all_prods.innerHTML = ``

                const data = JSON.parse(xhr.responseText)
                data.forEach(product => {
                    const product_card = `
                        <tr>
                            <td>${product.prod_id}</td>
                            <td>${product.prod_name}</td>
                            <td>${product.prod_price}</td>
                            <td>${product.stocks}</td>
                            <td>
                                <button class="btn btn-sm btn-pink" data-bs-toggle="modal" data-bs-target="#modal_add_stock" onclick="setProductId(${product.prod_id})">Add Stock</button>
                            </td>
                        </tr>
                   `
                    all_prods.innerHTML += product_card;
                })
            }
            xhr.send()
        }

        function setProductId(productId) {
            document.getElementById('product_id').value = productId;
        }


        const form_change_stock = document.getElementById('form_change_stock');
        form_change_stock.addEventListener('submit', e => {
            e.preventDefault();
            const form_data = new FormData(form_change_stock);
            const json_data = {};
            for (const [key, value] of form_data.entries()) {
                json_data[key] = value;
            }
            const json_string = JSON.stringify(json_data);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/products/add_stock.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    fetch_products();
                    form_change_stock.reset();
                    document.getElementById('closeButton').click();
                    hideModal('modal_add_stock')
                } else {
                    alert(response.error);
                }
            };
            xhr.send(json_string);
        });

        addEventListener("DOMContentLoaded", () => {
            fetch_products()
        });
    </script>
</body>

</html>