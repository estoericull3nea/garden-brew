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
        <div class="w-100">
            <!-- show table -->
            <!-- <h1 id="display_no_students" class="mb-0 text-center">No Registered Students</h1> -->
            <div class="table-responsive w-100 p-3 ">
                <table id="show_users_table" class="caption-top border-0 my-5" style="width:100%; font-size: .7rem;">
                    <caption>List of Appointments</caption>
                    <thead class="text-center ">
                        <tr>
                            <th class="border-0">User ID</th>
                            <th class="border-0">First Name</th>
                            <th class="border-0">Last Name</th>
                            <th class="border-0">Phone Number</th>
                            <th class="border-0">Address</th>
                            <th class="border-0">Registered At</th>
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
        function fetch_all() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/customers/fetch_all.php', true);
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

                    // <th class="border-0">User ID</th>
                    //         <th class="border-0">First Name</th>
                    //         <th class="border-0">Last Name</th>
                    //         <th class="border-0">Phone Number</th>
                    //         <th class="border-0">Address</th>
                    //         <th class="border-0">Registered At</th>

                    data.forEach(function(row) {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                          <td>${row.user_id}</td>
                          <td>${row.fname}</td>
                          <td>${row.lname}</td>
                          <td>${row.phone_number}</td>
                          <td>${row.address}</td>
                          <td>${formatDateTime(row.created_at)}</td>
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

        document.addEventListener("DOMContentLoaded", () => {
            fetch_all()
        });
    </script>
</body>

</html>