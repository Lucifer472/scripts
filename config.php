<?php

$url = "https://localhost/";
// secretKEy
$secret_key = "ThisIsTopSecretKey";

// db connection

// Database configuration
$host = 'localhost'; // Change to your database host
$username = 'root'; // Change to your database username
$password = ''; // Change to your database password
$database = 'scholarwithtech'; // Change to your database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>