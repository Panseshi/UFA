<?php
require_once 'tel_functions.php';

// Check if 'logged_in' key exists in $_SESSION
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    // 'logged_in' key exists and is true, proceed with the logic
    // Check if 'user_id' key exists and is set
    if (isset($_SESSION['user_id'])) {
        // 'user_id' is set, assign it to $user_id
        $user_id = $_SESSION['user_id'];
        // Now you can use $user_id safely
    }
} else {
    // 'logged_in' key is either not set or false, handle the case where the user is not logged in
}

if (checkSessionTimeout()) {
    sendMessage($chat_id, "Your session has expired. You have been logged out.");
}

if (strpos($message, "/start") === 0) {
    sendMessage($chat_id, "Welcome! Please use /login [username] [password] to log in.");
}

if (strpos($message, "/login") === 0) {
    $params = explode(" ", $message);
    if (count($params) == 3) {
        $username = $params[1];
        $password = $params[2];

        $user_id = authenticateUser($username, $password, $conn);

        if ($user_id) {
            $_SESSION['logged_in'] = true;
            $_SESSION['LAST_ACTIVITY'] = time(); // record the login time
            $_SESSION['user_id'] = $user_id; // set the user_id in the session

            // Fetch purchases after login
            $userId = getUserIdByUsername($username, $conn); // Assuming you have a function to get user ID by username
            $purchases = getPurchases($userId, $conn);

            // Log purchases to PHP error log
            error_log("Purchases retrieved: " . print_r($purchases, true));

            // Debugging: Check if $purchases is not empty
            if (!empty($purchases)) {
                error_log("Souvenir Purchases: " . print_r($purchases, true));
            } else {
                error_log("No souvenir purchases found.");
            }

            // Fetch reservations immediately after successful login
            $bookings = getBookings($user_id, $conn);

            // Send success message after fetching reservations and purchases
            $message = "Login successful. Your user ID is $user_id and your chat ID is $chat_id.\n\n";
            if (!empty($bookings)) {
                $message .= "Your reservations:\n";
                foreach ($bookings as $booking) {
                    $message .= "Hotel Name: " . $booking['hotel_name'] . "\n";
                    $message .= "Room Number: " . $booking['room_number'] . "\n";
                    $message .= "Check-in: " . $booking['check_in'] . "\n";
                    $message .= "Check-out: " . $booking['check_out'] . "\n";
                    $message .= "Total Price: " . $booking['total_price'] . "\n";
                    $message .= "Is Confirmed: " . ($booking['is_confirmed'] ? "Yes" : "No") . "\n";
                    $message .= "Created At: " . $booking['created_at'] . "\n";
                    $message .= "Updated At: " . $booking['updated_at'] . "\n\n";
                }
            } else {
                $message .= "No reservations found.\n";
            }

            // Check if $purchases exists and is not an array, then initialize as an empty array
        if (!isset($purchases) || !is_array($purchases)) {
            $purchases = [];
        }

                // Assuming $purchases contains the souvenir purchases for the user
                if (!empty($purchases)) {
                    $message .= "\nYour Souvenir Purchases:\n";
                    foreach ($purchases as $purchase) {
                        // Log each $purchase to PHP error log
                        error_log("Purchase data: " . print_r($purchase, true));
                
                        // Retrieve souvenir information for each purchase
                        $souvenir_id = $purchase['souvenir_id'];
                        $souvenir = getSouvenirById($souvenir_id, $conn); // Assuming you have a function to get souvenir details by ID
                
                        // Display souvenir details
                        if ($souvenir) {
                            $message .= "Purchase ID: " . $purchase['purchase_id'] . "\n";
                            $message .= "Souvenir Name: " . $souvenir['sounvenir_name'] . "\n"; // Corrected variable name
                            $message .= "Quantity: " . $purchase['purchase_quantity'] . "\n";
                            $message .= "Date: " . $purchase['purchase_date'] . "\n\n";
                        }
                    }
                } else {
                    $message .= "\nNo souvenir purchases found.\n";
                }
                

                // Sending the message with souvenir purchases and bookings
                sendMessage($chat_id, $message);
                }
    }}

/// Check if the message is for /bookings command
if (strpos($message, "/bookings") === 0) {
    // Debugging: Log session status
    error_log("Session Status before fetching bookings: " . ($_SESSION['logged_in'] ? "Logged in" : "Not logged in"));

    // Check if the user is logged in
    if (!isLoggedIn()) {
        sendMessage($chat_id, "You are not logged in. Please log in first.");
        return;
    }

    // Debugging: Log user ID for testing
    error_log("User ID for bookings: " . $_SESSION['user_id']);

    // Fetch reservations for the logged-in user
    $bookings = getBookings($_SESSION['user_id'], $conn);

    if (!empty($bookings)) {
        $response = "Your reservations:\n";
        foreach ($bookings as $booking) {
            $response .= "Hotel Name: " . $booking['hotel_name'] . "\n";
            $response .= "Room Number: " . $booking['room_number'] . "\n";
            $response .= "Check-in: " . $booking['check_in'] . "\n";
            $response .= "Check-out: " . $booking['check_out'] . "\n";
            $response .= "Total Price: " . $booking['total_price'] . "\n";
            $response .= "Is Confirmed: " . ($booking['is_confirmed'] ? "Yes" : "No") . "\n";
            $response .= "Created At: " . $booking['created_at'] . "\n";
            $response .= "Updated At: " . $booking['updated_at'] . "\n\n";
        }
        sendMessage($chat_id, $response);
    } else {
        sendMessage($chat_id, "No reservations found for your account.");
    }
}


// logout
if (strpos($message, "/logout") === 0) {
    if (isLoggedIn()) {
        logoutUser();
        sendMessage($chat_id, "You have been logged out.");
    } else {
        sendMessage($chat_id, "You are not logged in.");
    }
}

if (strpos($message, "/help") === 0) {
    $help_message = "Available commands:\n";
    $help_message .= "/start - Start the bot\n";
    $help_message .= "/login [username] [password] - Log in with your username and password\n";
    $help_message .= "/logout - Log out from your account\n";
    $help_message .= "/help - Show available commands\n";
    sendMessage($chat_id, $help_message);
}

