<?php
include("../config.php");

// Run a query to fetch the first 10 blogs where isMostView is true, ordered by timestamp
$query = "SELECT * FROM blogs WHERE isMostView = 1 ORDER BY id DESC LIMIT 10";
$result = $conn->query($query);

if ($result) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Convert the data to JSON
    $json_response = json_encode($data);

    // Set the content type to JSON
    header('Content-Type: application/json');

    // Output the JSON response
    echo $json_response;
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>