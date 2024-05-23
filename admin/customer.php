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
    <title>Customer</title>
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
            <div class="text-end m-3">
                <button class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#modal_add_customer">Add Customer</button>
            </div>
            <table class="table text-center align-middle">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Address</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="all_prods">

                </tbody>
            </table>
        </div>



    </main>


    <!-- Modal add user -->
    <div class="modal fade" id="modal_add_customer" tabindex="-1" aria-labelledby="modal_add_customerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_add_customerLabel">Adding Customer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="form_add_customer">
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control  shadow-none" required name="fname">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control  shadow-none" required name="lname">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="number" class="form-control  shadow-none" required name="phone_number">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control  shadow-none" required name="address">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control  shadow-none" required name="username">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control  shadow-none" required name="password">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-pink">Add</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- Modal edit user -->
    <div class="modal fade" id="modal_edit_customer" tabindex="-1" aria-labelledby="modal_edit_customerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_edit_customerLabel">Edit Customer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="form_edit_customer">
                        <input type="hidden" name="user_id" id="edit_user_id">
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control shadow-none" required name="fname" id="edit_fname">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control shadow-none" required name="lname" id="edit_lname">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="number" class="form-control shadow-none" required name="phone_number" id="edit_phone_number">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control shadow-none" required name="address" id="edit_address">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control shadow-none" required name="username" id="edit_username">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control shadow-none" name="password" id="edit_password">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-pink">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <script>
        function fetch_products() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/customers/fetch_all.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const all_prods = document.getElementById('all_prods');
                all_prods.innerHTML = ``;

                const data = JSON.parse(xhr.responseText);
                data.forEach(product => {
                    const product_card = `
                <tr>
                    <td>${product.user_id}</td>
                    <td>${product.fname}</td>
                    <td>${product.lname}</td>
                    <td>${product.username}</td>
                    <td>${product.phone_number}</td>
                    <td>${product.address}</td>
                    <td>
                        <button class="btn btn-warning" onclick="editCustomer(${product.user_id})">Edit</button>
                        <button class="btn btn-danger" onclick="deleteCustomer(${product.user_id})">Delete</button>
                    </td>
                </tr>
            `;
                    all_prods.innerHTML += product_card;
                });
            }
            xhr.send();
        }



        const form_add_customer = document.getElementById('form_add_customer')
        form_add_customer.addEventListener('submit', (e) => {
            e.preventDefault()

            const form_data = new FormData(form_add_customer)


            const json_data = {};
            for (const [key, value] of form_data.entries()) {
                json_data[key] = value;
            }
            const json_string = JSON.stringify(json_data);



            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/customers/add_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.responseText === 'Username already exists. Please choose a different username.') {
                    display_custom_toast('Username already exists. Please choose a different username.', 'danger', 2000)
                } else if (xhr.responseText === 'New user added successfully.') {
                    display_custom_toast('New user added successfully.', 'success', 2000)
                    fetch_products()
                    form_add_customer.reset()
                    hideModal('modal_add_customer')
                }
            }
            xhr.send(json_string)
        })

        function deleteCustomer(user_id) {
            if (confirm('Are you sure you want to delete this customer?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', './ajax/customers/delete_user.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onload = function() {
                    if (xhr.responseText === 'User deleted successfully.') {
                        display_custom_toast('User deleted successfully.', 'success', 2000);
                        fetch_products();
                    } else {
                        display_custom_toast('Error deleting user.', 'danger', 2000);
                    }
                }
                xhr.send(JSON.stringify({
                    user_id
                }));
            }
        }


        function editCustomer(user_id) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/customers/get_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const user = JSON.parse(xhr.responseText);

                document.getElementById('edit_user_id').value = user.user_id;
                document.getElementById('edit_fname').value = user.fname;
                document.getElementById('edit_lname').value = user.lname;
                document.getElementById('edit_phone_number').value = user.phone_number;
                document.getElementById('edit_address').value = user.address;
                document.getElementById('edit_username').value = user.username;

                $('#modal_edit_customer').modal('show');
            }
            xhr.send(JSON.stringify({
                user_id
            }));
        }

        const form_edit_customer = document.getElementById('form_edit_customer');
        form_edit_customer.addEventListener('submit', (e) => {
            e.preventDefault();

            const form_data = new FormData(form_edit_customer);

            const json_data = {};
            for (const [key, value] of form_data.entries()) {
                json_data[key] = value;
            }
            const json_string = JSON.stringify(json_data);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/customers/update_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.responseText === 'User updated successfully.') {
                    display_custom_toast('User updated successfully.', 'success', 2000);
                    fetch_products();
                    form_edit_customer.reset();
                    $('#modal_edit_customer').modal('hide');
                } else {
                    display_custom_toast('Error updating user.', 'danger', 2000);
                }

                console.log(xhr.responseText);
            }
            xhr.send(json_string);
        });


        addEventListener("DOMContentLoaded", () => {
            fetch_products()
        });
    </script>
</body>

</html>