<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hotel_id = $_POST['hotel_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $email = $_SESSION['email'] ?? $_POST['email']; // Use session email if logged in, else POST email
    
    if (!isset($_SESSION['guest_id'])) {
        $name = $_POST['name'];
        // Additional logic to save guest details if not logged in
    } else {
        $guest_id = $_SESSION['guest_id'];
        // Logic to retrieve guest details using guest_id
    }

    // Database insertion logic here

    // Redirect or show success message
    header("Location: booking_success.php");
    exit();
}
?>
