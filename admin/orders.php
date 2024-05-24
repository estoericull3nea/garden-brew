<!DOCTYPE html>
<html lang="en">

<head>
    <title>Orders</title>
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
                    <a href="http://localhost/garden-brew/admin/orders.php" class="nav-link text-pink" aria-current="page">
                        <svg class="bi pe-none me-2" width="16" height="16">
                            <use xlink:href="#home" />
                        </svg>
                        Orders
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <div class="w-100 container">
            <div class="text-end mt-3">
                <button class="btn btn-sm btn-pink mb-3" data-bs-toggle="modal" data-bs-target="#modal_add_product">Add Product</button>
            </div>
            <table class="table text-center align-middle">
                <thead>
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Customer Fullname</th>
                        <th scope="col">Customer Phone Number</th>
                        <th scope="col">Payment Mode</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date Checkout</th>
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody id="all_prods">

                </tbody>
            </table>
        </div>
    </main>

  

  

    <script>
        function fetch_orders() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/orders/fetch_orders.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const all_prods = document.getElementById('all_prods');
                all_prods.innerHTML = ``;
                const data = JSON.parse(xhr.responseText);
                console.log(data);return
                data.forEach(product => {
                    const product_card = `
                        <tr>
                            <td>${product.order_id}</td>
                            <td>${product.customer_fullname}</td>
                            <td>${product.prod_price}</td>
                            <td>${product.stocks}</td>
                            <td>
                                <button class="btn btn-sm btn-pink" data-bs-toggle="modal" data-bs-target="#modal_update_product" onclick="setProductDetails(${product.prod_id}, '${product.prod_name}', ${product.prod_price}, ${product.stocks})">Update</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteProduct(${product.prod_id})">Delete</button>
                            </td>
                        </tr>
                    `;
                    all_prods.innerHTML += product_card;
                });
            };
            xhr.send();
        }
    

        addEventListener("DOMContentLoaded", () => {
            fetch_orders();
        });
    </script>
</body>

</html>