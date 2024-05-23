<?php
session_start();
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header("Location: http://localhost/garden-brew/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <?php require './partials/head.php'; ?>
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
    </style>
</head>

<body>


    <div id="customMessage" class="custom-message d-flex align-items-center justify-content-between gap-2 ">
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-normal text-center"></p>
        <span id="closeButton"></span>
    </div>

    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="./assets/images/gb_logo-transparent.png" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form id="form_register" method="POST">

                        <h1 class="fw-bold text-pink">Garden Brew</h1>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control shadow-none" required name="fname" />
                        </div>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control shadow-none" required name="lname" />
                        </div>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control shadow-none" required name="username" />
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-3">
                            <label class="form-label" for="form3Example4">Password</label>
                            <input type="password" id="form3Example4" class="form-control shadow-none" required name="password" />
                        </div>

                        <!-- Phone Number -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label">Phone Number</label>
                            <input type="number" class="form-control shadow-none" required name="phone_number" placeholder="09** *** ****" />
                        </div>

                        <!-- Address -->
                        <div data-mdb-input-init class="form-outline">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control shadow-none" required name="address" placeholder="Full Address" />
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-pink" style="padding-left: 2.5rem; padding-right: 2.5rem;">Register</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="http://localhost/garden-brew/login.php" class="text-pink">Login</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </section>

    <script>
        const form_register = document.getElementById('form_register')
        form_register.addEventListener('submit', e => {
            e.preventDefault()
            const form_data = new FormData(form_register)
            const json_data = {};
            for (const [key, value] of form_data.entries()) {
                json_data[key] = value;
            }
            const json_string = JSON.stringify(json_data);


            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/auth/register.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = xhr.responseText;
                if (data === 'Username already registered') {
                    display_custom_toast('Username already registered', 'danger', 3000)
                } else if (data === '1') {
                    form_register.reset()
                    display_custom_toast('Successfully Registered', 'success', 1000)
                    setTimeout(() => {
                        window.location.href = 'http://localhost/garden-brew/login.php'
                    }, 1000);
                }
            }
            xhr.send(json_string)
        })
    </script>
</body>

</html>