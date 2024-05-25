<?php

// Start the session
session_start();

unset($_SESSION['user_logged_in']);
unset($_SESSION['user']);

header("Location: http://localhost/garden-brew/?logout=success");
exit();
