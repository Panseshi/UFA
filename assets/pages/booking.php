<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db_connect.php';

// Fetch available rooms with images from non-deleted hotels
$sql = "SELECT hotel_rooms.*, hotels.hotel_name
        FROM hotel_rooms
        INNER JOIN hotels ON hotel_rooms.hotel_id = hotels.hotel_id
        WHERE hotel_rooms.status = 'available' AND hotels.deleted = 0";
$result = $conn->query($sql);

// Check for errors
if (!$result) {
    die('Error executing the query: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFA Holidays - Booking</title>
    <base href="https://localhost/UFA/">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- Include custom CSS file -->
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main>
        <section class="container mt-5">
            <div class="row">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-6">';
                        echo '<div class="card mb-3">';
                        echo '<img src="' . $row['room_image'] . '" class="card-img-top" alt="Room Image">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Hotel: ' . $row['hotel_name'] . '</h5>';
                        echo '<h6 class="card-subtitle mb-2 text-muted">Room Number: ' . $row['room_number'] . '</h6>';
                        echo '<p class="card-text"><strong>Status:</strong> ' . $row['status'] . '</p>';
                        echo '<p class="card-text"><strong>Price:</strong> $' . $row['room_price'] . ' per night</p>';
                        echo '<p class="card-text"><strong>Capacity:</strong> ' . $row['room_capacity'] . ' person(s)</p>';
                        // Book Now button
                        echo '<a href="' . PAGES_PATH . 'reservation.php?room_id=' . $row['room_id'] . '" class="btn btn-primary">Book Now</a>';                    
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No available rooms found.</p>';
                }
                ?>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

    <!-- Include jQuery for AJAX handling -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Your JavaScript code here
        });
    </script>
</body>
</html>
