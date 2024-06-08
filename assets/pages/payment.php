<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db_connect.php';

// Fetch the latest reservation for the user
$user_id = $_SESSION['user_id'];
$sql_reservation = "SELECT reservations.*, hotel_rooms.room_number, hotel_rooms.room_price, hotels.hotel_name
                    FROM reservations
                    INNER JOIN hotel_rooms ON reservations.room_id = hotel_rooms.room_id
                    INNER JOIN hotels ON hotel_rooms.hotel_id = hotels.hotel_id
                    WHERE reservations.user_id = ?
                    ORDER BY reservations.reservation_id DESC
                    LIMIT 1";
$stmt = $conn->prepare($sql_reservation);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_reservation = $stmt->get_result();

if ($result_reservation->num_rows == 0) {
    die("No reservation found.");
}

$reservation = $result_reservation->fetch_assoc();

// Retrieve the check-in date from the URL parameter
$check_in = isset($_GET['check_in']) ? $_GET['check_in'] : date('Y-m-d'); // Default to today's date if not provided
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFA - Holidays Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- Include custom CSS file -->
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main>
        <section class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Payment for Reservation</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Reservation Details</h6>
                            <!-- Inside the HTML section where you display reservation details -->
                            <p class="card-text"><strong>Hotel:</strong> <?php echo htmlspecialchars($reservation['hotel_name']); ?></p>
                            <p class="card-text"><strong>Room Number:</strong> <?php echo htmlspecialchars($reservation['room_number']); ?></p>
                            <p class="card-text"><strong>Check-in Date:</strong> <?php echo htmlspecialchars($check_in); ?></p>
                            <p class="card-text"><strong>Check-out Date:</strong> <?php echo htmlspecialchars($reservation['check_out']); ?></p>
                            <p class="card-text"><strong>Total Price:</strong> $<?php echo htmlspecialchars($reservation['total_price']); ?></p>
                            <form action="assets/pages/confirm_payment.php" method="post">
                                <!-- Inside the form -->
                                <input type="hidden" name="check_in" value="<?php echo htmlspecialchars($check_in); ?>">
                                <input type="hidden" name="check_out" value="<?php echo htmlspecialchars($reservation['check_out']); ?>">
                                <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['reservation_id']); ?>">
                                <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($reservation['total_price']); ?>">
                                <!-- Additional payment details can be added here -->
                                <button type="submit" class="btn btn-primary">Confirm Reservation and Pay</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

    <!-- Include jQuery for AJAX handling -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
