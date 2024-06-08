<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection and configuration
include('db_connect.php');

// Fetch user data
$user_id = $_SESSION['user_id'];
$query = "SELECT user_first_name, user_last_name, user_email, user_phone, user_date_of_birth, user_login FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);

if ($stmt === false) {
    die('mysqli error: ' . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $user_first_name, $user_last_name, $user_email, $user_phone, $user_date_of_birth, $user_login);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Fetch user reservations
$reservations_query = "
    SELECT reservations.reservation_id, reservations.check_in, reservations.check_out, reservations.total_price, reservations.days_of_stay, hotels.hotel_name, hotel_rooms.room_number 
    FROM reservations
    JOIN hotel_rooms ON reservations.room_id = hotel_rooms.room_id
    JOIN hotels ON hotel_rooms.hotel_id = hotels.hotel_id
    WHERE reservations.user_id = ?
";
$reservations_stmt = mysqli_prepare($conn, $reservations_query);

if ($reservations_stmt === false) {
    die('mysqli error: ' . mysqli_error($conn));
}

mysqli_stmt_bind_param($reservations_stmt, "i", $user_id);
mysqli_stmt_execute($reservations_stmt);
mysqli_stmt_bind_result($reservations_stmt, $reservation_id, $check_in, $check_out, $total_price, $days_of_stay, $hotel_name, $room_number);

$reservations = [];
while (mysqli_stmt_fetch($reservations_stmt)) {
    $reservations[] = [
        'reservation_id' => $reservation_id,
        'check_in' => $check_in,
        'check_out' => $check_out,
        'total_price' => $total_price,
        'days_of_stay' => $days_of_stay,
        'hotel_name' => $hotel_name,
        'room_number' => $room_number
    ];
}
mysqli_stmt_close($reservations_stmt);
mysqli_close($conn);
?>

<<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFA Holidays - Profile</title>
    <base href="http://localhost/UFA/">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/logo-small.png" alt="Logo">
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mt-4 mb-3">Profile</h2>
                <!-- Display user information -->
                <p><strong>Name:</strong> <?php echo htmlspecialchars($user_first_name . ' ' . $user_last_name); ?>
                </p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user_phone); ?></p>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user_date_of_birth); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user_login); ?></p>
                <!-- Logout button -->
                <a href="assets/pages/logout.php" class="btn btn-danger mt-3">Logout</a>
                <h3 class="mt-5">Your Reservations</h3>
                <!-- Display reservations -->
                <?php if (empty($reservations)): ?>
                <p>You have no reservations.</p>
                <?php else: ?>
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Hotel Name</th>
                            <th>Room Number</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Total Price</th>
                            <th>Days of Stay</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['hotel_name']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['room_number']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['check_in']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['check_out']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['total_price']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['days_of_stay']); ?></td>
                            <td>
                                <!-- Delete reservation form -->
                                <form action="assets/pages/delete_reservation.php" method="post"
                                    onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                                    <input type="hidden" name="reservation_id"
                                        value="<?php echo $reservation['reservation_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>