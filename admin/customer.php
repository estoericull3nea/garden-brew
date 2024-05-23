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
            <table class="table text-center align-middle">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Address</th>
                    </tr>
                </thead>
                <tbody id="all_prods">

                </tbody>
            </table>
        </div>



    </main>

   


    <script>
        function fetch_products() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/customers/fetch_all.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {

                const all_prods = document.getElementById('all_prods')
                all_prods.innerHTML = ``

                const data = JSON.parse(xhr.responseText)
                data.forEach(product => {
                    console.log(product);
                    const product_card = `

                    <tr>
                        <td>${product.user_id}</td>
                        <td>${product.fname}</td>
                        <td>${product.lname}</td>
                        <td>${product.username}</td>
                        <td>${product.phone_number}</td>
                        <td>${product.address}</td>
                    </tr>
                       
                   `
                    all_prods.innerHTML += product_card;
                })
            }
            xhr.send()
        }

        

       

        addEventListener("DOMContentLoaded", () => {
            fetch_products()
        });
    </script>
</body>

</html>