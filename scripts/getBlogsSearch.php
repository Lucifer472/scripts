<?php

include("../config.php");

// Get the page number from the POST request
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$itemsPerPage = 10; // Number of items to fetch per page

// Get the search parameter from the POST request
$search = isset($_POST['search']) ? $_POST['search'] : '';


// Calculate the offset for pagination
$offset = ($page - 1) * $itemsPerPage;

// Query to fetch blogs for the current page with search
$query = "SELECT * FROM blogs WHERE title LIKE '%$search%' LIMIT $offset, $itemsPerPage";
$result = $conn->query($query);

if ($result) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Convert the data to JSON
    $json_response = json_encode($data);

    // Determine if there is a next page
    $nextPage = false;
    $nextOffset = $offset + $itemsPerPage;

    $nextPageQuery = "SELECT 1 FROM blogs WHERE title LIKE '%$search%' LIMIT $nextOffset, 1";
    $nextResult = $conn->query($nextPageQuery);

    if ($nextResult && $nextResult->num_rows > 0) {
        $nextPage = true;
    }

    // Combine the data and next page flag into a response array
    $response = array(
        'data' => $data,
        'nextPage' => $nextPage
    );

    // Set the content type to JSON
    header('Content-Type: application/json');

    // Output the JSON response
    echo json_encode($response);
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>