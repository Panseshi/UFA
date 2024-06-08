<?php
session_start();

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
    header("Location: login.php");
    exit();
}

// Include necessary files and database connection
include 'db_connect.php';

// Check if the hotel ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Error: Hotel ID not specified.');
}

// Get the hotel ID from the query parameter
$hotel_id = $_GET['id'];

// Prepare the SQL statement to update the deleted status
$sql = "UPDATE hotels SET deleted = 0 WHERE hotel_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param('i', $hotel_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redirect to the manage hotels page with a success message
        $_SESSION['message'] = 'Hotel restored successfully!';
        header("Location: manage_hotels.php");
    } else {
        // Redirect to the manage hotels page with an error message
        $_SESSION['error'] = 'Failed to restore the hotel. Please try again.';
        header("Location: manage_hotels.php");
    }

    $stmt->close();
} else {
    die('Error preparing the SQL statement: ' . $conn->error);
}

// Close the database connection
$conn->close();
?>
