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
            <div class="text-end mt-3">
                <button class="btn btn-sm btn-pink mb-3" data-bs-toggle="modal" data-bs-target="#modal_add_product">Add Product</button>
            </div>
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

    <!-- Modal update product -->
    <div class="modal fade" id="modal_update_product" tabindex="-1" aria-labelledby="modal_update_productLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_update_productLabel">Update Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_update_product" method="POST">
                        <input type="hidden" id="product_id" name="prod_id">
                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control form-control-sm shadow-none" id="product_name" name="prod_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Price</label>
                            <input type="number" step="0.01" class="form-control form-control-sm shadow-none" id="product_price" name="prod_price">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control form-control-sm shadow-none" id="stock_quantity" name="stock">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-pink">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal add product -->
    <div class="modal fade" id="modal_add_product" tabindex="-1" aria-labelledby="modal_add_productLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_add_productLabel">Add Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_add_product" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control form-control-sm shadow-none" id="new_product_name" name="prod_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Price</label>
                            <input type="number" step="0.01" class="form-control form-control-sm shadow-none" id="new_product_price" name="prod_price">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control form-control-sm shadow-none" id="new_stock_quantity" name="stock">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-pink">Add Product</button>
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
                const all_prods = document.getElementById('all_prods');
                all_prods.innerHTML = ``;
                const data = JSON.parse(xhr.responseText);
                data.forEach(product => {
                    const product_card = `
                        <tr>
                            <td>${product.prod_id}</td>
                            <td>${product.prod_name}</td>
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

        function setProductDetails(prodId, prodName, prodPrice, stock) {
            document.getElementById('product_id').value = prodId;
            document.getElementById('product_name').value = prodName;
            document.getElementById('product_price').value = prodPrice;
            document.getElementById('stock_quantity').value = stock;
        }

        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', './ajax/products/delete_product.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onload = function() {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        fetch_products();
                    } else {
                        alert(response.error);
                    }
                };
                const json_data = JSON.stringify({
                    prod_id: productId
                });
                xhr.send(json_data);
            }
        }

        const form_update_product = document.getElementById('form_update_product');
        form_update_product.addEventListener('submit', e => {
            e.preventDefault();
            const form_data = new FormData(form_update_product);
            const json_data = {};
            for (const [key, value] of form_data.entries()) {
                json_data[key] = value;
            }
            const json_string = JSON.stringify(json_data);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/products/update_product.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    fetch_products();
                    form_update_product.reset();
                    document.getElementById('closeButton').click();
                } else {
                    alert(response.error);
                }
            };
            xhr.send(json_string);
        });

        const form_add_product = document.getElementById('form_add_product');
        form_add_product.addEventListener('submit', e => {
            e.preventDefault();
            const form_data = new FormData(form_add_product);
            const json_data = {};
            for (const [key, value] of form_data.entries()) {
                json_data[key] = value;
            }
            const json_string = JSON.stringify(json_data);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/products/add_product.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    fetch_products();
                    form_add_product.reset();
                    document.getElementById('closeButton').click();
                } else {
                    alert(response.error);
                }
            };
            xhr.send(json_string);
        });

        addEventListener("DOMContentLoaded", () => {
            fetch_products();
        });
    </script>
</body>

</html>