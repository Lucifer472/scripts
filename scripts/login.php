<?php
require '../vendor/autoload.php';
use Firebase\JWT\JWT;

include("../config.php");

// Get email and password from the POST request
$email = $_POST['email'];
$password = $_POST['password'];

// Sanitize input data (to prevent SQL injection)
$email = $conn->real_escape_string($email);

// Query to verify the email
$checkEmailQuery = "SELECT * FROM user WHERE email = '$email'";
$emailResult = $conn->query($checkEmailQuery);

if ($emailResult->num_rows === 0) {
    // Email not found
    http_response_code(401);
    echo json_encode(array("message" => "Invalid email"));
} else {
    // Email is valid, check the password
    $user = $emailResult->fetch_assoc();
    $hashedPassword = $user['password'];

    if ($password === $hashedPassword) {
        // Password is correct, create and send a JWT token as a cookie
        $tokenPayload = array(
            "email" => $email,
            "exp" => time() + 3600 // Token expiration time (1 hour)
        );

        $jwt = JWT::encode($tokenPayload, $secret_key, 'HS256');

        setcookie("token", $jwt, time() + 3600, "/");
        echo json_encode(array("message" => "Authentication successful"));
    } else {
        // Password is incorrect
        http_response_code(401);
        echo json_encode(array("message" => "Password is incorrect"));
    }
}

// Close the database connection
$conn->close();
?>