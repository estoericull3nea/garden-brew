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
                }
            }
            xhr.send();
        }
        document.addEventListener("DOMContentLoaded", show_all_prods);
    </script>
</body>

</html>