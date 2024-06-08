<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
    header("Location: login.php");
    exit();
}

include_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['room_id'])) {
    $room_id = $_POST['room_id'];
    // Fetch and display the hotel room details for editing
    $query = "SELECT * FROM hotel_rooms WHERE room_id = $room_id";
    $result = mysqli_query($conn, $query);
    $room = mysqli_fetch_assoc($result);

    // Update hotel room details if form is submitted
    if (isset($_POST['update_room'])) {
        // Process the update query
        // Update the hotel room record in the database
        // Redirect to admin dashboard or hotel list page after updating
    }
}
?>
<!-- HTML form for editing hotel room details -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include necessary meta tags and stylesheets -->
</head>
<body>
    <!-- Hotel room edit form -->
    <form action="" method="POST">
        <input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>">
        <!-- Add fields for editing room details -->
        <button type="submit" name="update_room">Update Room</button>
    </form>
</body>
</html>
