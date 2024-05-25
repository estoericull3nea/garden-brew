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

    <!-- <div class="carousel">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item ">
                    <img lazy="loading" src="./assets/images/carousel/img1.jpg" class="img-fluid w-100" alt="..."  style="height: calc(100vh - 71px); background-size: cover; background-position: center;">
                </div>
                <div class="carousel-item ">
                    <img lazy="loading" src="./assets/images/carousel/img5.jpg" class="img-fluid w-100" alt="..."  style="height: calc(100vh - 71px); background-size: cover; background-position: center;">
                </div>
                <div class="carousel-item ">
                    <img lazy="loading" src="./assets/images/carousel/img3.jpg" class="img-fluid w-100" alt="..."  style="height: calc(100vh - 71px); background-size: cover; background-position: center;">
                </div>
                <div class="carousel-item active">
                    <img lazy="loading" src="./assets/images/carousel/img2.jpg" class="img-fluid w-100" alt="..."  style="height: calc(100vh - 71px); background-size: cover; background-position: center;">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div> -->

    <div class="container">
        <div class="hero-section">
            <div class="row align-items-center" style="height: calc(100vh - 71px);">
                <div class="col-12 col-md-6 mt-3 mt-md-0">
                    <h1 class="fw-bold  text-gradient">Garden Brew</h1>
                    <p class="my-4">
                    <p class="my-4" style="max-width: 450px;">Your ultimate destination for <span class="text-pink">delightful treats</span>. Experience the perfect blend of flavors that will leave you craving for more!</p>
                    </p>
                    <a href="http://localhost/garden-brew/products.php" class="btn btn-pink fw-medium">Show now <img src="./assets/images/icons/bubble-tea.png" class="ms-1"></a>
                </div>
                <div class="col-12 col-md-6">
                    <img src="./assets/images/hero-img.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>


</body>

</html>