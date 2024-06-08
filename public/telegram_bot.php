<?php
// Set session save path and cookie params before starting the session
session_save_path(__DIR__ . '/sessions');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '', // Your domain or leave empty for current domain
    'secure' => false, // Set to true if using HTTPS
    'httponly' => true,
    'samesite' => 'Lax' // or 'Strict'
]);

// Start the session
session_start();

require_once '../assets/pages/db_connect.php';
require_once 'tel_functions.php';
require_once 'tel_commands.php';

error_log("Session ID: " . session_id()); // Log session ID
error_log("Session Data at Start: " . print_r($_SESSION, true)); // Log session data at start

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

function authenticateUser($username, $password, $conn) {
    $query = "SELECT user_id, user_password FROM users WHERE user_login = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_id, $hashed_password);

        if (mysqli_stmt_fetch($stmt)) {
            error_log("Username: " . $username);
            error_log("Hashed Password from DB: " . $hashed_password);
            mysqli_stmt_close($stmt);

            if (password_verify($password, $hashed_password)) {
                return $user_id;
            }
        }

        mysqli_stmt_close($stmt);
    }

    return false;
}

function checkSessionTimeout() {
    // Implement your session timeout logic here
    // For example, if session is inactive for more than 30 minutes, return true
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        session_unset();
        session_destroy();
        return true;
    }
    $_SESSION['LAST_ACTIVITY'] = time();
    return false;
}

function sendMessage($chat_id, $message) {
    $botToken = "YOUR_TELEGRAM_BOT_TOKEN";
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $message
    ];
    file_get_contents($url . "?" . http_build_query($data));
}

function getBookings($user_id, $conn) {
    // Implement your logic to fetch bookings for the user
    $query = "SELECT * FROM bookings WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $bookings = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $bookings[] = $row;
        }
        mysqli_stmt_close($stmt);
        return $bookings;
    }
    return [];
}

if (checkSessionTimeout()) {
    sendMessage($chat_id, "Your session has expired. You have been logged out.");
    exit;
}

$user_id = false;
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    $user_id = $_SESSION['user_id'];
} else {
    // Assuming a command to login, for example: "/login username password"
    if (strpos($message, '/login') === 0) {
        list($command, $username, $password) = explode(" ", $message);
        $user_id = authenticateUser($username, $password, $conn);
        if ($user_id) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['LAST_ACTIVITY'] = time();
            sendMessage($chat_id, "Login successful!");
        } else {
            sendMessage($chat_id, "Login failed. Please check your credentials.");
        }
    } else {
        sendMessage($chat_id, "Please log in to continue.");
        exit;
    }
}

if ($user_id) {
    error_log("User ID after authentication: " . $user_id);
    $_SESSION['user_id'] = $user_id;
    error_log("Session Data after Login: " . print_r($_SESSION, true));
    $bookings = getBookings($user_id, $conn);
    error_log("Bookings after login: " . print_r($bookings, true));
    $response = "Your bookings:\n";
    foreach ($bookings as $booking) {
        $response .= "Booking ID: " . $booking['id'] . ", Date: " . $booking['date'] . ", Status: " . $booking['status'] . "\n";
    }
    sendMessage($chat_id, $response);
}

?>
