<?php
session_start();
if (!(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true)) {
    header("Location: http://localhost/garden-brew/admin/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin</title>
    <?php require './partials/head.php'; ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

</head>

<body>

    <main class="d-flex flex-nowrap">
        <?php require './partials/aside.php'; ?>
        <div>
            <!-- show table -->
            <!-- <h1 id="display_no_students" class="mb-0 text-center">No Registered Students</h1> -->
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
                        </tr>
                    </thead>
                    <tbody id="show_users_table_body" class="text-center">
                    </tbody>
                </table>
            </div>
            <!-- show table -->
        </div>
    </main>


    <script>
        function show_all_prods() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/products/fetch_prods.php', true);
            xhr.onload = function() {
                const data = JSON.parse(xhr.responseText)
                if (data) {
                    document.getElementById('show_users_table').style.display = 'table'
                    // document.getElementById('display_no_students').style.display = 'none'


                    const tbody = document.getElementById('show_users_table_body');
                    const table = document.getElementById('show_users_table');


                    // Check if DataTable instance exists and destroy it
                    if ($.fn.DataTable.isDataTable(table)) {
                        $(table).DataTable().destroy();
                        tbody.innerHTML = '';
                    }


                    data.forEach(function(row) {
                        const tr = document.createElement('tr');
                        console.log(row.category);

                        const prod_img_path = row.category === 'Classic' ? 'classic' :
                            row.category === 'Special' ? 'special' :
                            row.category === 'Premium' ? 'premium' :
                            row.category === 'Hot' ? 'hot' : 'other';


                        // <img src="../assets/images/milktea/classic/cookies_and_cream.png" alt="">


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
                        `;


                        tbody.appendChild(tr);
                    });


                    // Reinitialize DataTables after adding rows
                    var dataTable = new DataTable(table, {
                        stateSave: true,
                    });
                }
            }
            xhr.send()
        }


        addEventListener("DOMContentLoaded", () => {
            show_all_prods()
        });
    </script>
</body>

</html>