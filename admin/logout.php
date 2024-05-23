<?php

// Start the session
session_start();

unset($_SESSION['admin_logged_in']);

header("Location: http://localhost/garden-brew/admin/login.php");
exit();
