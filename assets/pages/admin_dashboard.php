<?php
session_start();

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/admin_dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .admin-card .card-body {
            text-align: center;
        }
        .admin-card .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php include 'admin_navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Admin Dashboard</h1>
        <div class="row mt-4">
            <!-- Manage Hotels Card -->
            <div class="col-md-4">
                <div class="card admin-card">
                    <div class="card-body">
                        <div class="icon"><i class="fas fa-hotel"></i></div>
                        <h5 class="card-title">Manage Hotels</h5>
                        <p class="card-text">Add, edit, and delete hotel information.</p>
                        <a href="assets/pages/manage_hotels.php" class="btn btn-primary">Go to Manage Hotels</a>
                    </div>
                </div>
            </div>

            <!-- Manage Users Card -->
            <div class="col-md-4">
                <div class="card admin-card">
                    <div class="card-body">
                        <div class="icon"><i class="fas fa-users"></i></div>
                        <h5 class="card-title">Manage Users</h5>
                        <p class="card-text">View and manage user accounts.</p>
                        <a href="assets/pages/manage_users.php" class="btn btn-primary">Go to Manage Users</a>
                    </div>
                </div>
            </div>

            <!-- View Analytics Card -->
            <div class="col-md-4">
                <div class="card admin-card">
                    <div class="card-body">
                        <div class="icon"><i class="fas fa-chart-line"></i></div>
                        <h5 class="card-title">View Analytics</h5>
                        <p class="card-text">View site analytics and user activity.</p>
                        <a href="assets/pages/view_analytics.php" class="btn btn-primary">Go to View Analytics</a>
                    </div>
                </div>
            </div>

            <!-- Manage Souvenirs Card -->
            <div class="col-md-4">
                <div class="card admin-card">
                    <div class="card-body">
                        <div class="icon"><i class="fas fa-gift"></i></div>
                        <h5 class="card-title">Manage Souvenirs</h5>
                        <p class="card-text">Add, edit, and delete souvenirs available for purchase.</p>
                        <a href="assets/pages/manage_souvenirs.php" class="btn btn-primary">Go to Manage Souvenirs</a>
                    </div>
                </div>
            </div>

            <!-- Manage Tours Card -->
            <div class="col-md-4">
                <div class="card admin-card">
                    <div class="card-body">
                        <div class="icon"><i class="fas fa-route"></i></div>
                        <h5 class="card-title">Manage Tours</h5>
                        <p class="card-text">Add, edit, and delete tour information.</p>
                        <a href="assets/pages/manage_tours.php" class="btn btn-primary">Go to Manage Tours</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

            <!-- Back to Home Button -->
            <div class="row mt-4">
            <div class="col-md-12">
                <a href="index.php" class="btn btn-secondary"><i class="fas fa-home"></i> Back to Home</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
