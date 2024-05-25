<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center  gap-2 " href="http://localhost/garden-brew/">
            <img src="./assets/images/gb_logo-transparent.png" alt="Logo" width="45" height="45 " class="d-inline-block align-text-top">
            <span class="fw-semibold text-pink">Garden Brew</span>
        </a>

        <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-4">
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="http://localhost/garden-brew/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="http://localhost/garden-brew/products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="http://localhost/garden-brew/orders.php">Orders</a>
                </li>
                <li class="nav-item position-relative">
                    <a class="nav-link position-relative" aria-current="page" href="http://localhost/garden-brew/cart.php">Cart</a>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <span id="show_count_cart"></span>
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </li>
            </ul>
            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) : ?>
                <div>
                    <a href="http://localhost/garden-brew/logout.php" class="btn btn-pink">Logout</a>
                </div>
            <?php else : ?>

                <div>
                    <a href="http://localhost/garden-brew/login.php" class="btn btn-pink">Login</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</nav>

<script>
    function get_total_cart() {
        const xhr = new XMLHttpRequest()
        xhr.open('POST', './ajax/count/count_total_cart.php', true)
        xhr.onload = function() {
            document.getElementById('show_count_cart').textContent = xhr.responseText
        }
        xhr.send()
    }

    addEventListener("DOMContentLoaded", () => {
        get_total_cart()
    });
</script>