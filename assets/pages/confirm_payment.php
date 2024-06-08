<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize reservation_id
    $reservation_id = intval($_POST['reservation_id']);
    if ($reservation_id <= 0) {
        die("Invalid reservation ID.");
    }

    // Fetch room price for the reservation
    $sql_get_room_price = "SELECT room_price FROM hotel_rooms WHERE room_id = (
        SELECT room_id FROM reservations WHERE reservation_id = ?
    )";
    $stmt_get_room_price = $conn->prepare($sql_get_room_price);
    $stmt_get_room_price->bind_param("i", $reservation_id);

    if (!$stmt_get_room_price->execute()) {
        die("Error fetching room price: " . $stmt_get_room_price->error);
    }

    $result_room_price = $stmt_get_room_price->get_result();
    if ($result_room_price->num_rows == 0) {
        die("No room found for this reservation.");
    }

    $row_room_price = $result_room_price->fetch_assoc();
    $room_price = $row_room_price['room_price'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert payment information into payments table
        $payment_date = date('Y-m-d H:i:s'); // Current date and time
        $sql_insert_payment = "INSERT INTO payments (reservation_id, user_id, payment_date, payment_amount, payment_method) VALUES (?, ?, ?, ?, ?)";
        $stmt_payment = $conn->prepare($sql_insert_payment);

        // Bind parameters using call_user_func_array
        $params = array($reservation_id, $_SESSION['user_id'], $payment_date, $room_price, "Credit Card (Dummy)");
        $types = "issds"; // Type definition string
        $stmt_payment->bind_param($types, ...$params);

        if (!$stmt_payment->execute()) {
            throw new Exception('Error inserting payment information: ' . $stmt_payment->error);
        }

        // Update the room status to reserved
        $sql_update_room = "UPDATE hotel_rooms SET status = 'reserved' WHERE room_id = (
            SELECT room_id FROM reservations WHERE reservation_id = ?
        )";
        $stmt_room = $conn->prepare($sql_update_room);
        $stmt_room->bind_param("i", $reservation_id);

        if (!$stmt_room->execute()) {
            throw new Exception('Error updating the room status: ' . $stmt_room->error);
        }

        // Commit the transaction
        $conn->commit();

        // Redirect to confirmation page
        header("Location: confirmation.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        die($e->getMessage());
    }
} else {
    header("Location: payment.php");
    exit();
}
?>
