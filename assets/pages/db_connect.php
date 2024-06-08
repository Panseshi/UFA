<?php
$servername = "localhost"; // Assuming MySQL server is on the same host
$username = "root"; // MySQL Username
$password = ""; // MySQL Password
$dbname = "ufa_holidays"; // Database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully";
}

// Close connection (optional)
// mysqli_close($conn);

?>
