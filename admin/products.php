<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin</title>
    <?php require './partials/head.php'; ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>


    <div id="customMessage" class="custom-message d-flex align-items-center justify-content-between gap-2 ">
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-normal text-center"></p>
        <span id="closeButton"></span>
    </div>

    <main class="d-flex flex-nowrap">
        <?php require './partials/aside.php'; ?>
        <div>
            <button class="btn btn-primary my-3" data-toggle="modal" data-target="#addProductModal">Add Product</button>
            <div class="table-responsive w-100 p-3 ">
                <table id="show_users_table" class="caption-top border-0 my-5" style="width:100%; font-size: .7rem;">
                    <caption>List of Products</caption>
                    <thead class="text-center ">
                        <tr>
                            <th class="border-0">Product ID</th>
                            <th class="border-0">Product Name</th>
                            <th class="border-0">Product Price</th>
                            <th class="border-0">Product Image</th>
                            <th class="border-0">Product Size</th>
                            <th class="border-0">Product Available</th>
                            <th class="border-0">Product Category</th>
                            <th class="border-0">Product Description</th>
                            <th class="border-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="show_users_table_body" class="text-center"></tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addProductForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form fields for adding product -->
                        <div class="form-group">
                            <label for="prod_name">Product Name</label>
                            <input type="text" class="form-control" id="prod_name" name="prod_name" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_price">Product Price</label>
                            <input type="text" class="form-control" id="prod_price" name="prod_price" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_img">Product Image</label>
                            <input type="file" class="form-control" id="prod_img" name="prod_img" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_size">Product Size</label>
                            <input type="text" class="form-control" id="prod_size" name="prod_size" required>
                        </div>
                        <div class="form-group">
                            <label for="is_available">Product Available (1 for Yes, 0 for No)</label>
                            <input type="number" class="form-control" id="is_available" name="is_available" min="0" max="1" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Product Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="Classic">Classic</option>
                                <option value="Special">Special</option>
                                <option value="Premium">Premium</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="prod_desc">Product Description</label>
                            <textarea class="form-control" id="prod_desc" name="prod_desc" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editProductForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form fields for editing product -->
                        <input type="hidden" id="edit_prod_id" name="prod_id">
                        <div class="form-group">
                            <label for="edit_prod_name">Product Name</label>
                            <input type="text" class="form-control" id="edit_prod_name" name="prod_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_prod_price">Product Price</label>
                            <input type="text" class="form-control" id="edit_prod_price" name="prod_price" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_prod_img">Product Image</label>
                            <input type="file" class="form-control" id="edit_prod_img" name="prod_img" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="edit_prod_size">Product Size</label>
                            <input type="text" class="form-control" id="edit_prod_size" name="prod_size" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_is_available">Product Available (1 for Yes, 0 for No)</label>
                            <input type="number" class="form-control" id="edit_is_available" name="is_available" min="0" max="1" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_category">Product Category</label>
                            <select class="form-control" id="edit_category" name="category" required>
                                <option value="Classic">Classic</option>
                                <option value="Special">Special</option>
                                <option value="Premium">Premium</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_prod_desc">Product Description</label>
                            <textarea class="form-control" id="edit_prod_desc" name="prod_desc" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function show_all_prods() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/products/fetch_prods.php', true);
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText);
                if (data) {
                    document.getElementById('show_users_table').style.display = 'table';

                    const tbody = document.getElementById('show_users_table_body');
                    const table = document.getElementById('show_users_table');

                    if ($.fn.DataTable.isDataTable(table)) {
                        $(table).DataTable().destroy();
                        tbody.innerHTML = '';
                    }

                    data.forEach(function(row) {
                        const tr = document.createElement('tr');

                        const prod_img_path = row.category === 'Classic' ? 'classic' :
                            row.category === 'Special' ? 'special' :
                            row.category === 'Premium' ? 'premium' :
                            row.category === 'Hot' ? 'hot' : 'other';

                        tr.innerHTML = `
                        <td>${row.prod_id}</td>
                        <td>${row.prod_name}</td>
                        <td>${row.prod_price}</td>
                        <td>
                            <img src="../assets/images/milktea/${prod_img_path}/${row.prod_img}" class="img-fluid" style="height: 60px; width: 60px;">
                        </td>
                        <td>${row.prod_size}</td>
                        <td>${row.is_available}</td>
                        <td>${row.category}</td>
                        <td>${row.prod_desc}</td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-btn" data-id="${row.prod_id}" data-toggle="modal" data-target="#editProductModal">Edit</button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${row.prod_id}">Delete</button>
                        </td>
                    `;

                        tbody.appendChild(tr);
                    });

                    var dataTable = new DataTable(table, {
                        stateSave: true,
                    });

                    document.querySelectorAll('.edit-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const prod_id = this.getAttribute('data-id');
                            const product = data.find(prod => prod.prod_id == prod_id);

                            document.getElementById('edit_prod_id').value = product.prod_id;
                            document.getElementById('edit_prod_name').value = product.prod_name;
                            document.getElementById('edit_prod_price').value = product.prod_price;
                            document.getElementById('edit_prod_img').value = product.prod_img;
                            document.getElementById('edit_prod_size').value = product.prod_size;
                            document.getElementById('edit_is_available').value = product.is_available;
                            document.getElementById('edit_category').value = product.category;
                            document.getElementById('edit_prod_desc').value = product.prod_desc;
                        });
                    });

                    document.querySelectorAll('.delete-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const prod_id = this.getAttribute('data-id');
                            if (confirm('Are you sure you want to delete this product?')) {
                                deleteProduct(prod_id);
                            }
                        });
                    });
                }
            }
            xhr.send();
        }

        function deleteProduct(prod_id) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/products/delete_prod.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    display_custom_toast('Product deleted successfully', 'success', 2000);
                    show_all_prods()
                } else {
                    display_custom_toast('Failed to delete product', 'danger', 2000);
                }
            }
            xhr.send('prod_id=' + prod_id);
        }

        document.getElementById('addProductForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/products/create_prod.php', true);
            xhr.onload = function() {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    alert('Product added successfully.');
                    $('#addProductModal').modal('hide');
                    show_all_prods();
                } else {
                    alert('Failed to add product.');
                }

            }
            xhr.send(formData);
        });

        document.getElementById('editProductForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/products/update_prod.php', true);
            xhr.onload = function() {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    alert('Product updated successfully.');
                    $('#editProductModal').modal('hide');
                    show_all_prods();
                } else {
                    alert('Failed to update product.');
                }
            }
            xhr.send(formData);
        });

        document.addEventListener("DOMContentLoaded", show_all_prods);
    </script>
</body>

</html>