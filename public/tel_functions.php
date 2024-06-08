<?php
require_once '../assets/pages/db_connect.php';

$input = file_get_contents('php://input');
$update = json_decode($input, true);

if (!$update || !isset($update["message"]["chat"]["id"]) || !isset($update["message"]["text"])) {
    error_log("Invalid input received from Telegram bot: " . $input);
    exit;
}

$chat_id = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];

error_log("Received message from chat_id: $chat_id");
error_log("Received message: $message");

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if 'logged_in' key exists in $_SESSION and set it to false if not
if (!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
}

// Check if 'user_id' key exists in $_SESSION and set it to null if not
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = null;
}

function isLoggedIn() {
    // Check if 'logged_in' key exists in $_SESSION and is true
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
  }

function sendMessage($chat_id, $message) {
    $token = "7217408178:AAGB3-WfWteuds1777O7N5AqhpJ9uIxT2O0";
    $website = "https://api.telegram.org/bot" . $token;
    $url = $website . "/sendMessage?chat_id=" . $chat_id . "&text=" . urlencode($message);
    file_get_contents($url);
    error_log("Sent message to chat_id: $chat_id with message: $message");
}

function logoutUser() {
    error_log("Logging out user with session data: " . print_r($_SESSION, true));
    $_SESSION['logged_in'] = false;
    session_destroy();
}

function getBookings($user_id, $conn) {
    $bookings = array();

    $query = "
        SELECT reservations.room_id, reservations.room_price, reservations.check_in, reservations.check_out, 
        reservations.total_price, reservations.is_confirmed, reservations.created_at, reservations.updated_at, 
        reservations.days_of_stay, hotels.hotel_name, hotel_rooms.room_number
        FROM reservations
        JOIN hotel_rooms ON reservations.room_id = hotel_rooms.room_id
        JOIN hotels ON hotel_rooms.hotel_id = hotels.hotel_id
        WHERE reservations.user_id = ?
    ";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $bookings[] = array(
                'room_id' => $row['room_id'],
                'room_price' => $row['room_price'],
                'check_in' => $row['check_in'],
                'check_out' => $row['check_out'],
                'total_price' => $row['total_price'],
                'is_confirmed' => $row['is_confirmed'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
                'days_of_stay' => $row['days_of_stay'],
                'hotel_name' => $row['hotel_name'],
                'room_number' => $row['room_number']
            );
        }

        mysqli_stmt_close($stmt);
    }

    error_log("Retrieved bookings for user_id $user_id: " . print_r($bookings, true));
    return $bookings;
}

function getPurchases($userId, $conn) {
    $sql = "SELECT purchases.purchase_id, souvenirs.sounvenir_name, purchases.purchase_date
            FROM purchases
            INNER JOIN souvenirs ON purchases.souvenir_id = souvenirs.souvenir_id
            WHERE purchases.user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $purchases = $stmt->get_result();

    if ($purchases === false) {
        throw new Exception("Query execution failed: " . $stmt->error);
    }

    if ($purchases->num_rows > 0) {
        $response = "Your Souvenir Purchases:\n";
        while ($row = $purchases->fetch_assoc()) {
            $response .= "Purchase ID: " . $row['purchase_id'] . "\n";
            $response .= "Souvenir: " . $row['sounvenir_name'] . "\n";
            $response .= "Date: " . $row['purchase_date'] . "\n\n";
        }
    } else {
        $response = "No souvenir purchases found.\n";
    }

    return $response;
}


function getUserIdByUsername($username, $conn) {
    $sql = "SELECT user_id FROM users WHERE user_login = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();
        return $user_id;
    } else {
        // Username not found
        $stmt->close();
        return null;
    }
}

// Define the function to get souvenir details by ID
function getSouvenirById($souvenir_id, $conn) {
    // Prepare SQL statement to fetch souvenir details
    $sql = "SELECT * FROM `souvenirs` WHERE `souvenir_id` = ?";

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $souvenir_id);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if a row is returned
    if ($result->num_rows > 0) {
        // Fetch and return the souvenir details as an associative array
        return $result->fetch_assoc();
    } else {
        // Return null if no souvenir is found
        return null;
    }
}

// Include checkSessionTimeout function
function checkSessionTimeout() {
    // Your session timeout logic here
}
?>
