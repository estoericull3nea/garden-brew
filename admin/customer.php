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
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div id="customMessage" class="custom-message d-flex align-items-center justify-content-between gap-2 ">
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-normal text-center"></p>
        <span id="closeButton"></span>
    </div>

    <main class="d-flex flex-nowrap">
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
            <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Add User</button>
            <table class="table text-center align-middle">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Address</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="all_prods">
                </tbody>
            </table>
        </div>
    </main>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group">
                            <label for="addFirstName">First Name</label>
                            <input type="text" class="form-control" id="addFirstName" required>
                        </div>
                        <div class="form-group">
                            <label for="addLastName">Last Name</label>
                            <input type="text" class="form-control" id="addLastName" required>
                        </div>
                        <div class="form-group">
                            <label for="addUsername">Username</label>
                            <input type="text" class="form-control" id="addUsername" required>
                        </div>
                        <div class="form-group">
                            <label for="addPassword">Password</label>
                            <input type="password" class="form-control" id="addPassword" required>
                        </div>
                        <div class="form-group">
                            <label for="addPhoneNumber">Phone Number</label>
                            <input type="text" class="form-control" id="addPhoneNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="addAddress">Address</label>
                            <input type="text" class="form-control" id="addAddress" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update User Modal -->
    <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserModalLabel">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateUserForm">
                        <input type="hidden" id="updateUserId">
                        <div class="form-group">
                            <label for="updateFirstName">First Name</label>
                            <input type="text" class="form-control" id="updateFirstName" required>
                        </div>
                        <div class="form-group">
                            <label for="updateLastName">Last Name</label>
                            <input type="text" class="form-control" id="updateLastName" required>
                        </div>
                        <div class="form-group">
                            <label for="updateUsername">Username</label>
                            <input type="text" class="form-control" id="updateUsername" required>
                        </div>
                        <div class="form-group">
                            <label for="updatePhoneNumber">Phone Number</label>
                            <input type="text" class="form-control" id="updatePhoneNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="updateAddress">Address</label>
                            <input type="text" class="form-control" id="updateAddress" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function fetch_products() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/customers/fetch_all.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function () {
                const all_prods = document.getElementById('all_prods');
                all_prods.innerHTML = '';
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
                                <button class="btn btn-warning" onclick="showUpdateUserForm(${product.user_id}, '${product.fname}', '${product.lname}', '${product.username}', '${product.phone_number}', '${product.address}')">Update</button>
                                <button class="btn btn-danger" onclick="delete_user(${product.user_id})">Delete</button>
                            </td>
                        </tr>`;
                    all_prods.innerHTML += product_card;
                });
            }
            xhr.send();
        }

        function add_user(user) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/customers/add_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function () {
                $('#addUserModal').modal('hide');
                fetch_products();
            }
            xhr.send(JSON.stringify(user));
        }

        function update_user(user) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/customers/update_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function () {
                $('#updateUserModal').modal('hide');
                fetch_products();
            }
            xhr.send(JSON.stringify(user));
        }

        function delete_user(user_id) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/customers/delete_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function () {
                fetch_products();
            }
            xhr.send(JSON.stringify({ user_id: user_id }));
        }

        function showAddUserForm() {
            $('#addUserModal').modal('show');
        }

        function showUpdateUserForm(user_id, fname, lname, username, phone_number, address) {
            $('#updateUserId').val(user_id);
            $('#updateFirstName').val(fname);
            $('#updateLastName').val(lname);
            $('#updateUsername').val(username);
            $('#updatePhoneNumber').val(phone_number);
            $('#updateAddress').val(address);
            $('#updateUserModal').modal('show');
        }

        document.getElementById('addUserForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const user = {
                fname: $('#addFirstName').val(),
                lname: $('#addLastName').val(),
                username: $('#addUsername').val(),
                password: $('#addPassword').val(),
                phone_number: $('#addPhoneNumber').val(),
                address: $('#addAddress').val()
            };
            add_user(user);
        });

        document.getElementById('updateUserForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const user = {
                user_id: $('#updateUserId').val(),
                fname: $('#updateFirstName').val(),
                lname: $('#updateLastName').val(),
                username: $('#updateUsername').val(),
                phone_number: $('#updatePhoneNumber').val(),
                address: $('#updateAddress').val()
            };
            update_user(user);
        });

        document.addEventListener("DOMContentLoaded", () => {
            fetch_products();
        });
    </script>
</body>

</html>
