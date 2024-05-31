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
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-semibold text-center"></p>
        <span id="closeButton"></span>
    </div>

    <section class="login">
        <div class="container">
            <div class="row align-items-center mx-auto" style="height: 100vh; max-width: 1000px;">
                <div class="col-12 col-md-6 mb-4 mb-md-0 mt-4 mt-md-0">
                    <img loading="lazy" src="./assets/images/gb_logo-transparent.png" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-12 col-md-6 ">
                    <form id="form_login" method="POST">

                        <h1 class="fw-bold text-pink mb-3">Login your account</h1>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control shadow-none" required name="username" />
                        </div>

                        <div data-mdb-input-init class="form-outline mb-3">
                            <label class="form-label" for="form3Example4">Password</label>
                            <input type="password" id="form3Example4" class="form-control shadow-none" required name="password" />
                        </div>

                        <div class="text-center text-lg-start">
                            <button type="submit" class="btn btn-dark btn-pink">Login</button>
                            <p class="small fw-bold mt-3 pt-1 mb-0">Don't have an account? <a href="http://localhost/garden-brew/register.php" class="text-pink">Register</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </section>

    <script>
        const url = new URL(window.location.href);

        const params = new URLSearchParams(url.search);

        const loginStatus = params.get('login');

        if (loginStatus === 'false') {
            display_custom_toast('Please Login or Register account first', 'danger', 3000)
        }

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
            }
            xhr.send(json_string)
        })
    </script>
</body>

</html>