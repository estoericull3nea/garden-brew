<?php session_start(); ?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center  gap-2 " href="http://localhost/garden-brew/">
            <img src="./assets/images/gb_logo-transparent.png" alt="Logo" width="45" height="45 " class="d-inline-block align-text-top">
            <span class="fw-semibold text-pink">Garden Brew</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-2">
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="#">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="#">Cart</a>
                </li>

            </ul>
            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) : ?>
                <div>
                    <a href="http://localhost/garden-brew/logout.php" class="btn btn-dark">Logout</a>
                </div>
            <?php else : ?>

                <div>
                    <a href="http://localhost/garden-brew/login.php" class="btn btn-dark">Login</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</nav>