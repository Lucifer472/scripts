<?php
require 'vendor/autoload.php'; // Load the JWT library

use Firebase\JWT\JWT;

include("../config.php");

// Function to verify the JWT token
function verifyToken($token, $secret_key)
{
    try {
        $decoded = JWT::decode($token, $secret_key, array('HS256'));
        return $decoded;
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_COOKIE['jwt'])) {
    $jwt = $_COOKIE['jwt'];

    // Verify the token
    $tokenData = verifyToken($jwt, $secret_key);

    if ($tokenData) {
        // Token is valid, proceed to insert data
        // Get data from the POST request
        $title = $_POST['title'];
        $category = $_POST['category'];
        $blog = $_POST['blog']; // JSON-decode the string into a PHP array
        $keyword = $_POST['keyword'];
        $description = $_POST['description'];
        $url = $_POST['url'];
        $img = $_POST['img'];

        // Escape and sanitize input data (to prevent SQL injection)
        $title = $conn->real_escape_string($title);
        $category = $conn->real_escape_string($category);
        $keyword = $conn->real_escape_string($keyword);
        $description = $conn->real_escape_string($description);
        $url = $conn->real_escape_string($url);
        $img = $conn->real_escape_string($img);

        // Query to insert data into the "blogs" table
        $query = "INSERT INTO blogs (title, category, blog, keyword, description, url, img) VALUES ('$title', '$category', '$blog', '$keyword', '$description', '$url', '$img')";

        if ($conn->query($query) === TRUE) {
            echo "Blog data inserted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    } else {
        // Invalid or expired token
        echo "Invalid token";
    }
} else {
    // No token provided in the cookie
    echo "Token not found";
}
?>