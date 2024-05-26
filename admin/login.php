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
    <title>Login</title>
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

    <section style="height: 100vh;">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 col-md-6">
                    <img src="../assets/images/gb_logo-transparent.png" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-12 col-md-6">
                    <form id="form_login" method="POST">

                        <h1 class="fw-bold text-pink">Admin</h1>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control shadow-none" required name="username" />
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-3">
                            <label class="form-label" for="form3Example4">Password</label>
                            <input type="password" id="form3Example4" class="form-control shadow-none" required name="password" />
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-pink" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </section>

    <script>
        const form_login = document.getElementById('form_login')
        form_login.addEventListener('submit', e => {
            e.preventDefault()
            const form_data = new FormData(form_login)
            const json_data = {};
            for (const [key, value] of form_data.entries()) {
                json_data[key] = value;
            }
            const json_string = JSON.stringify(json_data);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', './ajax/auth/login.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                const data = xhr.responseText;
                if (data === 'Incorrect password') {
                    display_custom_toast('Incorrect Username or Password', 'danger', 3000)
                } else if (data === '1') {
                    form_login.reset()
                    display_custom_toast('Logged In', 'success', 2000)
                    setTimeout(() => {
                        window.location.href = 'http://localhost/garden-brew/'
                    }, 2000);
                } else if (data === 'User does not exist') {
                    display_custom_toast('User does not exist', 'danger', 3000)
                } else {
                    console.log(data);
                }
                console.log(xhr.responseText);

                if (xhr.responseText === '1') {
                    form_login.reset()
                    display_custom_toast('Logged In', 'success', 2000)
                    setTimeout(() => {
                        window.location.href = 'http://localhost/garden-brew/admin/'
                    }, 2000);
                }
            }
            xhr.send(json_string)
        })
    </script>
</body>

</html>