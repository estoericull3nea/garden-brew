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


    <div class="middle border">
        <div class="container">
            <h1 class="text-center">Dashboard</h1>
            <a href="http://localhost/garden-brew/admin/admin.php" class="btn btn-pink">Admin</a>
            <a href="http://localhost/garden-brew/admin/invoice.php" class="btn btn-pink">Invoice</a>
            <a href="http://localhost/garden-brew/admin/cash_payment.php" class="btn btn-pink">Cash Payment</a>
            <a href="http://localhost/garden-brew/admin/report.php" class="btn btn-pink">Report</a>
            <a href="http://localhost/garden-brew/admin/report.php" class="btn btn-pink">Sales</a>
        </div>
    </div>
  

   
</body>

</html>