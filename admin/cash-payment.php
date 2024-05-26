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
    <title>Admin</title>
    <?php require './partials/head.php'; ?>

</head>

<body>

    <main class="d-flex flex-nowrap">
        <?php require './partials/aside.php'; ?>
        <h1>Orders</h1>
    </main>


</body>

</html>