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
            <div class="text-end me-2">
                <button class="btn btn-pink my-3" data-toggle="modal" data-target="#addProductModal">Add Product</button>
            </div>
            <div class="table-responsive w-100 p-3">
                <table id="show_users_table" class="caption-top border-0 my-5" style="width:100%; font-size: .7rem;">
                    <caption>List of Products</caption>
                    <thead class="text-center">
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
            <form id="addProductForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Add Product Form Fields -->
                        <div class="form-group">
                            <label for="prod_name">Product Name</label>
                            <input type="text" class="form-control" id="prod_name" name="prod_name" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_price">Product Price</label>
                            <input type="number" class="form-control" id="prod_price" name="prod_price" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_img">Product Image</label>
                            <input type="file" class="form-control" id="prod_img" name="prod_img" required onchange="previewImage(event, 'imagePreview')">
                        </div>
                        <div class="form-group text-center">
                            <img id="imagePreview" class="img-fluid" style="max-height: 200px;">
                        </div>
                        <div class="form-group">
                            <label for="prod_size">Product Size</label>
                            <input type="text" class="form-control" id="prod_size" name="prod_size" required>
                        </div>
                        <div class="form-group">
                            <label for="is_available">Product Available</label>
                            <select class="form-control" id="is_available" name="is_available" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category">Product Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="Classic">Classic</option>
                                <option value="Premium">Premium</option>
                                <option value="Special">Special</option>
                                <option value="Hot">Hot</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="prod_desc">Product Description</label>
                            <textarea class="form-control" id="prod_desc" name="prod_desc" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editProductForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Edit Product Form Fields (same as add but with hidden id field) -->
                        <input type="hidden" id="edit_prod_id" name="prod_id">
                        <div class="form-group">
                            <label for="edit_prod_name">Product Name</label>
                            <input type="text" class="form-control" id="edit_prod_name" name="prod_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_prod_price">Product Price</label>
                            <input type="number" class="form-control" id="edit_prod_price" name="prod_price" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_prod_img">Product Image</label>
                            <input type="file" class="form-control" id="edit_prod_img" name="prod_img" onchange="previewImage(event, 'editImagePreview')">
                        </div>
                        <div class="form-group text-center">
                            <img id="editImagePreview" class="img-fluid" style="max-height: 200px;">
                        </div>
                        <div class="form-group">
                            <label for="edit_prod_size">Product Size</label>
                            <input type="text" class="form-control" id="edit_prod_size" name="prod_size" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_is_available">Product Available</label>
                            <select class="form-control" id="edit_is_available" name="is_available" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_category">Product Category</label>
                            <select class="form-control" id="edit_category" name="category" required>
                                <option value="Classic">Classic</option>
                                <option value="Premium">Premium</option>
                                <option value="Special">Special</option>
                                <option value="Hot">Hot</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_prod_desc">Product Description</label>
                            <textarea class="form-control" id="edit_prod_desc" name="prod_desc" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event, previewId) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById(previewId);
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        document.addEventListener("DOMContentLoaded", function() {
            show_all_prods();

            // Add Product
            document.getElementById('addProductForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const xhr = new XMLHttpRequest();
                xhr.open('POST', './ajax/products/add_prod.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        hideModal('addProductModal')
                        display_custom_toast('Added', 'success', 2000)
                        show_all_prods();
                        document.getElementById('addProductForm').reset();
                    } else {
                        console.error('Error adding product');
                    }
                    console.log(xhr.responseText);
                };
                xhr.send(formData);
            });

            // Edit Product
            document.getElementById('editProductForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const xhr = new XMLHttpRequest();
                xhr.open('POST', './ajax/products/edit_prod.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        $('#editProductModal').modal('hide');
                        display_custom_toast('Updated', 'success', 2000)
                        show_all_prods();
                    } else {
                        console.error('Error editing product');
                    }
                };
                xhr.send(formData);
            });

            // Populate Edit Modal
            document.getElementById('show_users_table_body').addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('edit-btn')) {
                    const prodId = e.target.getAttribute('data-id');
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', './ajax/products/get_prod.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            const product = JSON.parse(xhr.responseText);
                            document.getElementById('edit_prod_id').value = product.prod_id;
                            document.getElementById('edit_prod_name').value = product.prod_name;
                            document.getElementById('edit_prod_price').value = product.prod_price;
                            document.getElementById('edit_prod_size').value = product.prod_size;
                            document.getElementById('edit_is_available').value = product.is_available;
                            document.getElementById('edit_category').value = product.category;
                            document.getElementById('edit_prod_desc').value = product.prod_desc;

                            // Set image preview
                            const editImagePreview = document.getElementById('editImagePreview');
                            const prod_img_path = product.category === 'Classic' ? 'classic' :
                                product.category === 'Special' ? 'special' :
                                product.category === 'Premium' ? 'premium' :
                                product.category === 'Hot' ? 'hot' : 'other';
                            editImagePreview.src = `../assets/images/milktea/${prod_img_path}/${product.prod_img}`;
                        }
                    };
                    xhr.send('prod_id=' + prodId);
                }
            });

            // Delete Product
            document.getElementById('show_users_table_body').addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('delete-btn')) {
                    const prodId = e.target.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this product?')) {
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', './ajax/products/delete_prod.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                show_all_prods();
                                display_custom_toast('Deleted', 'success', 2000)
                            } else {
                                console.error('Error deleting product');
                            }
                        };
                        xhr.send('prod_id=' + prodId);
                    }
                }
            });
        });

        function show_all_prods() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/products/fetch_prods.php', true);
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText);
                if (data) {
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
                            <td class="d-flex align-item gap-1">
                                <button class="btn btn-outline-dark btn-sm edit-btn smallest rounded-5" data-id="${row.prod_id}" data-toggle="modal" data-target="#editProductModal">Edit</button>
                                <button class="btn btn-outline-dark btn-sm delete-btn smallest rounded-5" data-id="${row.prod_id}">Delete</button>
                            </td>
                        `;

                        tbody.appendChild(tr);
                    });

                    var dataTable = new DataTable(table, {
                        stateSave: true,
                    });
                }
            }
            xhr.send();
        }
    </script>
</body>

</html>