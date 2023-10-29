<?php

include("../config.php");
// Run the query to get the enum values
$query = "SHOW COLUMNS FROM blogs LIKE 'category'";
$result = $conn->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    if ($row) {
        // Extract the enum values from the 'Type' column of the result
        $enum_string = $row['Type'];

        // Parse the enum values from the string
        preg_match_all("/'([^']+)'/", $enum_string, $matches);
        $enum_values = $matches[1];

        // Convert the enum values to JSON
        $json_response = json_encode($enum_values);

        // Set the content type to JSON
        header('Content-Type: application/json');

        // Output the JSON response
        echo $json_response;
    } else {
        echo "No data found for the 'category' column.";
    }

    $result->close();
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();