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
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-semibold text-center"></p>
        <span id="closeButton"></span>
    </div>

    <section>
        <div class="container" style="height: 100vh;">
            <div class="row align-items-center justify-content-center h-100">
                <div class="col-12 col-md-6 mb-4">
                    <img src="./assets/images/gb_logo-transparent.png" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-12 col-md-6">
                    <form id="form_register" method="POST">

                        <h1 class="fw-bold text-pink mb-3">Register your account</h1>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label ">First Name</label>
                                    <input type="text" class="form-control shadow-none" required name="fname" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label ">Last Name</label>
                                    <input type="text" class="form-control shadow-none" required name="lname" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label ">Username</label>
                            <input type="text" class="form-control shadow-none" required name="username" />
                        </div>

                        <div class="mb-3 mb-3">
                            <label class="form-label " for="form3Example4">Password</label>
                            <input type="password" id="form3Example4" class="form-control shadow-none" required name="password" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label ">Phone Number</label>
                            <input type="text" class="form-control shadow-none" required name="phone_number" placeholder="09** *** ****" pattern="\d{11}" title="Please enter exactly 11 digits" maxlength="11" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label ">Address</label>
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
        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.querySelector('input[name="phone_number"]');
            phoneInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^0-9]/g, '');
                if (e.target.value.length > 11) {
                    e.target.value = e.target.value.slice(0, 11);
                }
            });
        });

        const form_register = document.getElementById('form_register');
        form_register.addEventListener('submit', e => {
            e.preventDefault();
            const phoneInput = form_register.querySelector('input[name="phone_number"]');
            const phonePattern = /^\d{11}$/;
            if (!phonePattern.test(phoneInput.value)) {
                alert('Please enter a valid phone number with exactly 11 digits.');
                return;
            }

            const form_data = new FormData(form_register);
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
                console.log(data);
                if (data === 'Username already registered') {
                    display_custom_toast('Username already registered', 'danger', 3000);
                } else if (data === '1') {
                    form_register.reset();
                    display_custom_toast('Successfully Registered', 'success', 1000);
                    setTimeout(() => {
                        window.location.href = 'http://localhost/garden-brew/login.php';
                    }, 1000);
                }
            }
            xhr.send(json_string);
        });
    </script>
</body>

</html>