<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
include 'db_connect.php';

function handlePurchase($conn, $souvenir_id, $souvenir_price, $purchase_quantity, $user_id) {
    // Get the current date and time
    $purchase_date = date("Y-m-d H:i:s");

    // Check if the stock is available
    $check_stock_sql = "SELECT stock_quantity FROM souvenirs WHERE souvenir_id = ?";
    $check_stock_stmt = $conn->prepare($check_stock_sql);
    $check_stock_stmt->bind_param("i", $souvenir_id);
    $check_stock_stmt->execute();
    $check_stock_result = $check_stock_stmt->get_result();

    if ($check_stock_result->num_rows > 0) {
        $row = $check_stock_result->fetch_assoc();
        $current_stock = $row['stock_quantity'];

        if ($current_stock >= $purchase_quantity) {
            // Calculate the new stock quantity after purchase
            $new_stock = $current_stock - $purchase_quantity;

            // Update the stock in the souvenirs table
            $update_stock_sql = "UPDATE souvenirs SET stock_quantity = ? WHERE souvenir_id = ?";
            $update_stock_stmt = $conn->prepare($update_stock_sql);
            $update_stock_stmt->bind_param("ii", $new_stock, $souvenir_id);
            $update_stock_success = $update_stock_stmt->execute();

            if (!$update_stock_success) {
                $conn->rollback();
                return "Error updating stock quantity.";
            }

            // Insert the purchase record into the purchases table
            $insert_purchase_sql = "INSERT INTO purchases (user_id, souvenir_id, purchase_date, purchase_quantity, purchase_price, is_deleted) 
                                    VALUES (?, ?, ?, ?, ?, 0)";
            $insert_purchase_stmt = $conn->prepare($insert_purchase_sql);
            $insert_purchase_stmt->bind_param("iisdd", $user_id, $souvenir_id, $purchase_date, $purchase_quantity, $souvenir_price);
            $insert_purchase_success = $insert_purchase_stmt->execute();

            if (!$insert_purchase_success) {
                $conn->rollback();
                return "Error inserting purchase record.";
            }

            // Update the totals table with the purchase price
            $update_totals_sql = "UPDATE totals SET total_amount = total_amount + ? WHERE id = 1";
            $update_totals_stmt = $conn->prepare($update_totals_sql);
            $update_totals_stmt->bind_param("d", $souvenir_price);
            $update_totals_success = $update_totals_stmt->execute();

            if (!$update_totals_success) {
                $conn->rollback();
                return "Error updating totals.";
            }

            $conn->commit();
            return "Purchase successful!";
        } else {
            return "Insufficient stock available.";
        }
    } else {
        return "Error retrieving stock information.";
    }

    $check_stock_stmt->close();
}

$purchase_result = "No purchase data submitted.";

if (isset($_POST['purchase_submit'])) {
    $souvenir_id = $_POST['souvenir_id'];
    $souvenir_price = $_POST['souvenir_price'];
    $purchase_quantity = $_POST['purchase_quantity'];
    $user_id = $_SESSION['user_id'];

    $purchase_result = handlePurchase($conn, $souvenir_id, $souvenir_price, $purchase_quantity, $user_id);
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <base href="https://localhost/UFA/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Result</title>
</head>
<body>
    <!-- Display purchase result message -->
    <h1>Purchase Result</h1>
    <p><?php echo $purchase_result; ?></p>
    <a href="index.php">Back to Home</a>
</body>
</html>
