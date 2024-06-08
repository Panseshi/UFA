<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db_connect.php';

// Check if room_id is provided in the URL
if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];

    // Fetch room details
    $sql_room = "SELECT hotel_rooms.*, hotels.hotel_name
                 FROM hotel_rooms
                 INNER JOIN hotels ON hotel_rooms.hotel_id = hotels.hotel_id
                 WHERE hotel_rooms.room_id = $room_id";
    $result_room = $conn->query($sql_room);

    // Check for errors
    if (!$result_room) {
        die('Error executing the query: ' . $conn->error);
    }

    // Fetch check-in and check-out dates from POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $check_in = date('Y-m-d', strtotime($_POST['check_in']));
        $check_out = date('Y-m-d', strtotime($_POST['check_out']));

        // Insert reservation record
        $sql_reservation = "INSERT INTO reservations (room_id, room_price, user_id, check_in, check_out, total_price, is_confirmed)
                            VALUES ($room_id, ?, ?, ?, ?, ?, 0)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql_reservation);
        $stmt->bind_param("siisd", $room_price, $user_id, $check_in, $check_out, $total_price);

        // Set parameters and execute
        $room_price = $_POST['room_price'];
        $user_id = $_SESSION['user_id'];
        $total_price = $room_price * (strtotime($check_out) - strtotime($check_in)) / (60 * 60 * 24); // Calculate total price based on days of stay
        $stmt->execute();
 
        // Check for errors
        if ($stmt->errno) {
            die('Error executing the query: ' . $stmt->error);
        }

        // Redirect to payment page with URL parameters
        header("Location: payment.php?check_in=$check_in&check_out=$check_out");
        exit();
    }
} else {
    // Redirect to booking page if room_id is not provided
    header("Location: booking.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFA Holidays - Reservation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- Include custom CSS file -->
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main>
        <section class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <?php
                    if ($result_room->num_rows > 0) {
                        $row = $result_room->fetch_assoc();
                        echo '<div class="card mb-3">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Hotel: ' . $row['hotel_name'] . '</h5>';
                        echo '<h6 class="card-subtitle mb-2 text-muted">Room Number: ' . $row['room_number'] . '</h6>';
                        echo '<p class="card-text"><strong>Status:</strong> ' . $row['status'] . '</p>';
                        echo '<p class="card-text"><strong>Price:</strong> $' . $row['room_price'] . ' per night</p>';
                        echo '<p class="card-text"><strong>Capacity:</strong> ' . $row['room_capacity'] . ' person(s)</p>';
                        echo '<form method="post">';
                        echo '<div class="form-group">';
                        echo '<label for="check_in">Check-in Date:</label>';
                        echo '<input type="date" id="check_in" name="check_in" required>';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label for="check_out">Check-out Date:</label>';
                        echo '<input type="date" id="check_out" name="check_out" required>';
                        echo '</div>';
                        echo '<input type="hidden" name="room_price" value="' . $row['room_price'] . '">';

                        echo '<button type="submit" class="btn btn-primary">Confirm Reservation</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<p>No room details found.</p>';
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

<!-- Include jQuery for AJAX handling -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    // jQuery script to display check-in date on button click
    $(document).ready(function() {
        $('#btnDisplayCheckIn').click(function() {
            var checkInDate = $('#check_in').val();
            alert('Selected Check-In Date: ' + checkInDate);
        });
    });
</script>

</body>
</html>
