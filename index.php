<?php

include("./config.php");

// Close the database connection
$conn->close();
header("Location: $url");