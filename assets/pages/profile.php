<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection and configuration
include('db_connect.php');

// Fetch user data
$user_id = $_SESSION['user_id'];
$query = "SELECT user_first_name, user_last_name, user_email, user_phone, user_date_of_birth, user_login FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt === false) {
    die('mysqli error: ' . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $user_first_name, $user_last_name, $user_email, $user_phone, $user_date_of_birth, $user_login);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Fetch user reservations
$reservations_query = "
    SELECT reservations.reservation_id, reservations.check_in, reservations.check_out, reservations.total_price, reservations.days_of_stay, hotels.hotel_name, hotel_rooms.room_number 
    FROM reservations
    JOIN hotel_rooms ON reservations.room_id = hotel_rooms.room_id
    JOIN hotels ON hotel_rooms.hotel_id = hotels.hotel_id
    WHERE reservations.user_id = ? AND reservations.is_deleted = 0
";
$reservations_stmt = mysqli_prepare($conn, $reservations_query);

if ($reservations_stmt === false) {
    die('mysqli error: ' . mysqli_error($conn));
}

mysqli_stmt_bind_param($reservations_stmt, "i", $user_id);
mysqli_stmt_execute($reservations_stmt);
mysqli_stmt_bind_result($reservations_stmt, $reservation_id, $check_in, $check_out, $total_price, $days_of_stay, $hotel_name, $room_number);

$reservations = [];
while (mysqli_stmt_fetch($reservations_stmt)) {
    $reservations[] = [
        'reservation_id' => $reservation_id,
        'check_in' => $check_in,
        'check_out' => $check_out,
        'total_price' => $total_price,
        'days_of_stay' => $days_of_stay,
        'hotel_name' => $hotel_name,
        'room_number' => $room_number
    ];
}
mysqli_stmt_close($reservations_stmt);

// Fetch user souvenir purchases
$purchases_query = "
    SELECT purchases.purchase_id, purchases.purchase_date, souvenirs.sounvenir_name, souvenirs.souvenir_price 
    FROM purchases 
    JOIN souvenirs ON purchases.souvenir_id = souvenirs.souvenir_id 
    WHERE purchases.user_id = ? AND purchases.is_deleted = 0
";

$purchases_stmt = mysqli_prepare($conn, $purchases_query);

if ($purchases_stmt === false) {
    die('mysqli error: ' . mysqli_error($conn));
}

mysqli_stmt_bind_param($purchases_stmt, "i", $user_id);
mysqli_stmt_execute($purchases_stmt);
mysqli_stmt_bind_result($purchases_stmt, $purchase_id, $purchase_date, $souvenir_name, $souvenir_price);

$purchases = [];
while (mysqli_stmt_fetch($purchases_stmt)) {
    $purchases[] = [
        'purchase_id' => $purchase_id,
        'purchase_date' => $purchase_date,
        'souvenir_name' => $souvenir_name,
        'souvenir_price' => $souvenir_price
    ];
}
mysqli_stmt_close($purchases_stmt); // Close purchases_stmt after fetching data
mysqli_close($conn);

// Include the HTML content
include('profile_html.php');
?>