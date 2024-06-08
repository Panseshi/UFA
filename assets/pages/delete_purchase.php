<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection and configuration
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['purchase_id'])) {
    // Sanitize the input
    $purchase_id = filter_var($_POST['purchase_id'], FILTER_SANITIZE_NUMBER_INT);

    // Prepare and execute the delete statement
    $delete_query = "UPDATE purchases SET is_deleted = 1 WHERE purchase_id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);

    if ($stmt === false) {
        die('mysqli error: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $purchase_id);
    mysqli_stmt_execute($stmt);

    // Check if the deletion was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Log the deletion
        $log_query = "INSERT INTO action_logs (action_type, action_id, action, action_date) VALUES (?, ?, ?, NOW())";
        $log_stmt = mysqli_prepare($conn, $log_query);

        if ($log_stmt === false) {
            die('mysqli error: ' . mysqli_error($conn));
        }

        $action_type = "purchase";
        $action = "Deleted purchase ID: " . $purchase_id;
        mysqli_stmt_bind_param($log_stmt, "sis", $action_type, $purchase_id, $action);
        mysqli_stmt_execute($log_stmt);
        mysqli_stmt_close($log_stmt);

        // Redirect back to the profile page with a success message
        $_SESSION['success_message'] = 'Souvenir purchase deleted successfully.';
        header("Location: profile.php");
        exit();
    } else {
        // Redirect back to the profile page with an error message
        $_SESSION['error_message'] = 'Failed to delete souvenir purchase.';
        header("Location: profile.php");
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Redirect back to the profile page if the request method is not POST or if purchase_id is not set
    header("Location: profile.php");
    exit();
}
?>
