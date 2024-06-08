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
    <title>Manage Souvenirs</title>
    <base href="https://localhost/UFA/">
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
        <h1 class="text-center">Manage Souvenirs</h1>
        <div class="row mt-4">
            <!-- Add Souvenir Card -->
            <div class="col-md-4">
                <div class="card admin-card">
                    <div class="card-body">
                        <div class="icon"><i class="fas fa-plus-circle"></i></div>
                        <h5 class="card-title">Add Souvenir</h5>
                        <p class="card-text">Add new souvenirs to the inventory.</p>
                        <a href="assets/pages/add_souvenir.php" class="btn btn-primary">Add Souvenir</a>
                    </div>
                </div>
            </div>

            <!-- Edit Souvenir Card -->
            <div class="col-md-4">
                <div class="card admin-card">
                    <div class="card-body">
                        <div class="icon"><i class="fas fa-edit"></i></div>
                        <h5 class="card-title">Edit Souvenir</h5>
                        <p class="card-text">Edit existing souvenir details.</p>
                        <a href="assets/pages/edit_souvenir.php" class="btn btn-primary">Edit Souvenir</a>
                    </div>
                </div>
            </div>

            <!-- Delete Souvenir Card -->
            <div class="col-md-4">
                <div class="card admin-card">
                    <div class="card-body">
                        <div class="icon"><i class="fas fa-trash-alt"></i></div>
                        <h5 class="card-title">Delete Souvenir</h5>
                        <p class="card-text">Remove souvenirs from the inventory.</p>
                        <a href="assets/pages/delete_souvenir.php" class="btn btn-primary">Delete Souvenir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Back Button -->
     <div class="row mt-4">
            <div class="col-md-12">
                <a href="assets/pages/admin_dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
