<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Garden Brew</title>
    <?php require './partials/head.php'; ?>
</head>

<body>
    <?php require './partials/header.php'; ?>

    <div id="customMessage" class="custom-message d-flex align-items-center justify-content-between gap-2 ">
        <p id="messageText" style="font-size: .9rem;" class="mb-0 fw-semibold text-center"></p>
        <span id="closeButton"></span>
    </div>

    <div class="container">
        <div class="hero-section">
            <div class="row align-items-center" style="height: calc(100vh - 71px);">
                <div class="col-12 col-md-6 mt-3 mt-md-0">
                    <h1 class="fw-bold  text-gradient">Garden Brew</h1>
                    <p class="my-4">
                    <p class="my-4" style="max-width: 450px;">Your ultimate destination for <span class="text-pink">delightful treats</span>. Experience the perfect blend of flavors that will leave you craving for more!</p>
                    </p>
                    <a href="http://localhost/garden-brew/products.php" class="btn btn-pink fw-medium">Order Now <img src="./assets/images/icons/bubble-tea.png" class="ms-1"></a>
                </div>
                <div class="col-12 col-md-6">
                    <img src="./assets/images/hero-img.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>


 

</body>

</html>