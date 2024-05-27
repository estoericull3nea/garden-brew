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

    <div id="customMessage" class="custom-message d-flex align-items-center justify-content-between gap-2 ">
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-semibold text-center"></p>
        <span id="closeButton"></span>
    </div>

    <main class="d-flex flex-nowrap">
        <?php require './partials/aside.php'; ?>
        <div class="w-100">
            <!-- show table -->
            <!-- <h1 id="display_no_students" class="mb-0 text-center">No Registered Students</h1> -->
            <div class="table-responsive w-100 p-3 ">
                <div class="text-end m-3">
                    <button class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#modal_add_customer">Add Customer Account</button>
                </div>
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
                            <th class="border-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="show_users_table_body" class="text-center">
                    </tbody>
                </table>
            </div>
            <!-- show table -->

        </div>
    </main>


    <!-- Modal add customer account -->
    <div class="modal fade" id="modal_add_customer" tabindex="-1" aria-labelledby="modal_add_customerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <form id="form_register" method="POST">

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label ">First Name</label>
                                    <input type="text" class="form-control  shadow-none" required name="fname" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label ">Last Name</label>
                                    <input type="text" class="form-control  shadow-none" required name="lname" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label ">Username</label>
                            <input type="text" class="form-control  shadow-none" required name="username" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label " for="form3Example4">Password</label>
                            <input type="password" id="form3Example4" class="form-control  shadow-none" required name="password" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label ">Phone Number</label>
                            <input type="text" class="form-control  shadow-none" required name="phone_number" placeholder="09** *** ****" pattern="\d{11}" title="Please enter exactly 11 digits" maxlength="11" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label ">Address</label>
                            <input type="text" class="form-control  shadow-none" required name="address" placeholder="Full Address" />
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-outline-dark" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-pink">Add</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>



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
                          <td>
                            <button class="btn btn-sm btn-outline-dark rounded-5 smallest">Edit</button>
                            <button class="btn btn-sm btn-outline-dark rounded-5 smallest">Delete</button>
                          </td>
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

        const form_register = document.getElementById('form_register');
        form_register.addEventListener('submit', e => {
            e.preventDefault();
            const phoneInput = form_register.querySelector('input[name="phone_number"]');
            const phonePattern = /^\d{11}$/;
            if (!phonePattern.test(phoneInput.value)) {
                display_custom_toast('Please enter a valid phone number with exactly 11 digits', 'danger', 3000);
                return;
            }

            const passwordInput = form_register.querySelector('input[name="password"]');
            if (passwordInput.value.length < 8) {
                display_custom_toast('Password must be at least 8 characters long', 'danger', 3000);
                return;
            }

            const form_data = new FormData(form_register);
            const json_data = {};
            for (const [key, value] of form_data.entries()) {
                json_data[key] = value;
            }
            const json_string = JSON.stringify(json_data);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/customers/add_customer.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = xhr.responseText;
                console.log(data);
                if (data === 'Username already registered') {
                    display_custom_toast('Username already registered', 'danger', 3000);
                } else if (data === '1') {
                    form_register.reset();
                    display_custom_toast('Successfully Added', 'success', 1000);
                    hideModal('modal_add_customer')
                    fetch_all()

                }
            }
            xhr.send(json_string);
        });

        document.addEventListener("DOMContentLoaded", () => {
            fetch_all()

            const phoneInput = document.querySelector('input[name="phone_number"]');
            phoneInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^0-9]/g, '');
                if (e.target.value.length > 11) {
                    e.target.value = e.target.value.slice(0, 11);
                }
            });
        });
    </script>
</body>

</html>