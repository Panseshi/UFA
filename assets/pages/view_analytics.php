<?php
// Include your database connection file here
include 'db_connect.php';

// Check if the user is logged in and has admin privileges
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
    // Redirect to login page or unauthorized access page
    header("Location: login.php");
    exit();
}

// Fetch analytics data from the database
$sql = "SELECT * FROM analytics";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result && mysqli_num_rows($result) > 0) {
    $analytics_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $analytics_data = [];
    $error_message = "No analytics data found.";
}

// Fetch total number of signed-up users
$sql_users = "SELECT COUNT(*) as total_users FROM users";
$result_users = mysqli_query($conn, $sql_users);
$total_users = 0;
if ($result_users && mysqli_num_rows($result_users) > 0) {
    $total_users_data = mysqli_fetch_assoc($result_users);
    $total_users = $total_users_data['total_users'];
}

// Calculate total amount paid by users for souvenirs (purchases)
$sql_souvenirs = "SELECT SUM(amount) as total_souvenir_payments FROM purchases";
$result_souvenirs = mysqli_query($conn, $sql_souvenirs);
$total_souvenir_payments = 0;
if ($result_souvenirs && mysqli_num_rows($result_souvenirs) > 0) {
    $total_souvenirs_data = mysqli_fetch_assoc($result_souvenirs);
    $total_souvenir_payments = $total_souvenirs_data['total_souvenir_payments'];
}

// Calculate total amount paid by users for hotel bookings (reservations)
$sql_hotel_bookings = "SELECT SUM(total_amount) as total_hotel_payments FROM reservations";
$result_hotel_bookings = mysqli_query($conn, $sql_hotel_bookings);
$total_hotel_payments = 0;
if ($result_hotel_bookings && mysqli_num_rows($result_hotel_bookings) > 0) {
    $total_hotel_payments_data = mysqli_fetch_assoc($result_hotel_bookings);
    $total_hotel_payments = $total_hotel_payments_data['total_hotel_payments'];
}

// Calculate total amount paid by users for earning
$total_payments = $total_souvenir_payments + $total_hotel_payments;

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Analytics</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <main>
        <?php include 'admin_navbar.php'; ?>
        <div class="container">
            <h1>View Analytics</h1>
            <div class="mb-4">
                <strong>Total Signed-Up Users:</strong> <?php echo $total_users; ?>
            </div>
            <div class="mb-4">
                <strong>Total Amount Paid by Users for Souvenirs:</strong> $<?php echo number_format($total_souvenir_payments, 2); ?>
            </div>
            <div class="mb-4">
                <strong>Total Amount Paid by Users for Hotel Bookings:</strong> $<?php echo number_format($total_hotel_payments, 2); ?>
            </div>
            <div class="mb-4">
                <strong>Total Amount Paid by Users for Earning:</strong> $<?php echo number_format($total_payments, 2); ?>
            </div>
            <?php if (!empty($analytics_data)): ?>
                <table class="table">
                    <!-- Table headers -->
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Page Views</th>
                            <th>Unique Visitors</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- PHP Loop to populate table rows -->
                        <?php foreach ($analytics_data as $data): ?>
                            <tr>
                                <td><?php echo $data['date']; ?></td>
                                <td><?php echo $data['page_views']; ?></td>
                                <td><?php echo $data['unique_visitors']; ?></td>
                                <td>
                                    <a href="edit-analytics.php?id=<?php echo $data['id']; ?>">Edit</a>
                                    <a href="delete-analytics.php?id=<?php echo $data['id']; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p><?php echo $error_message; ?></p>
            <?php endif; ?>
        </div>
    </main>
    <!-- Back Button -->
    <div class="row mt-4">
            <div class="col-md-12">
                <a href="assets/pages/admin_dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
