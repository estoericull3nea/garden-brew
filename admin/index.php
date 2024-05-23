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
    <title>Dashboard</title>
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

  

   
</body>

</html>