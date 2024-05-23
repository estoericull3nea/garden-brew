<?php
// Database parameters
$host = 'localhost'; // or your host, e.g., '127.0.0.1'
$username = 'root';
$password = '';
$database = 'gardenbrew_db';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
