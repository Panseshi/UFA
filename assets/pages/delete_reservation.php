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

    $user_id = $_SESSION['user_id'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Get the room_id from the reservation
        $sql_get_room = "SELECT room_id FROM reservations WHERE reservation_id = ? AND user_id = ?";
        $stmt_get_room = $conn->prepare($sql_get_room);
        if (!$stmt_get_room) {
            throw new Exception('Error preparing statement: ' . $conn->error);
        }
        $stmt_get_room->bind_param("ii", $reservation_id, $user_id);

        if (!$stmt_get_room->execute()) {
            throw new Exception('Error executing statement: ' . $stmt_get_room->error);
        }

        $result_get_room = $stmt_get_room->get_result();
        if ($result_get_room->num_rows == 0) {
            throw new Exception('No room found for this reservation.');
        }

        $row = $result_get_room->fetch_assoc();
        $room_id = $row['room_id'];

        // Delete the reservation
        $sql_delete_reservation = "DELETE FROM reservations WHERE reservation_id = ? AND user_id = ?";
        $stmt_delete_reservation = $conn->prepare($sql_delete_reservation);
        if (!$stmt_delete_reservation) {
            throw new Exception('Error preparing delete statement: ' . $conn->error);
        }
        $stmt_delete_reservation->bind_param("is", $reservation_id, $user_id);

        if (!$stmt_delete_reservation->execute()) {
            throw new Exception('Error deleting the reservation: ' . $stmt_delete_reservation->error);
        }

        // Insert a log entry for the deletion action
        $action = "Deleted reservation with ID $reservation_id";
        $sql_insert_log = "INSERT INTO action_logs (user_id, action_type, action) VALUES (?, 'delete', ?)";
        $stmt_insert_log = $conn->prepare($sql_insert_log);
        if (!$stmt_insert_log) {
            throw new Exception('Error preparing log insert statement: ' . $conn->error);
        }
        $stmt_insert_log->bind_param("is", $user_id, $action);

        if (!$stmt_insert_log->execute()) {
            throw new Exception('Error inserting log entry: ' . $stmt_insert_log->error);
        }




        // Update the room status to available
        $sql_update_room = "UPDATE hotel_rooms SET status = 'available' WHERE room_id = ?";
        $stmt_update_room = $conn->prepare($sql_update_room);
        if (!$stmt_update_room) {
            throw new Exception('Error preparing update room statement: ' . $conn->error);
        }
        $stmt_update_room->bind_param("i", $room_id);

        if (!$stmt_update_room->execute()) {
            throw new Exception('Error updating the room status: ' . $stmt_update_room->error);
        }

        // Commit the transaction
        $conn->commit();

        // Redirect back to profile page
        header("Location: profile.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        die($e->getMessage());
    }
} else {
    header("Location: profile.php");
    exit();
}
?>