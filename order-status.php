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
    <title>Track Order</title>
    <?php require './partials/head.php'; ?>
</head>

<body>
    <?php require './partials/header.php'; ?>

</body>

</html>