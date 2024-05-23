<?php 
session_start();
if(!(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true )) {
    header("Location: http://localhost/garden-brew/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Garden Brew</title>
    <?php require './partials/head.php'; ?>
</head>

<body>
    <?php require './partials/header.php'; ?>

    <div class="carousel">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./assets/images/carousel/img1.jpg" class="d-block img-fluid w-100" alt="..." style="background-position: center; background-size: cover;">
                </div>
                <div class="carousel-item">
                    <img src="./assets/images/carousel/img5.jpg" class="d-block img-fluid w-100" alt="..." style="background-position: center; background-size: cover;">
                </div>
                <div class="carousel-item">
                    <img src="./assets/images/carousel/img3.jpg" class="d-block img-fluid w-100" alt="..." style="background-position: center; background-size: cover;">
                </div>
                <div class="carousel-item">
                    <img src="./assets/images/carousel/img2.jpg" class="d-block img-fluid w-100" alt="..." style="background-position: center; background-size: cover;">
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
    </div>


</body>

</html>