<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFA Holidays - Confirmation</title>
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
                            <h5 class="card-title">Payment Confirmation</h5>
                            <p class="card-text">Thank you for your payment! Your reservation is confirmed.</p>
                            <a href="index.php" class="btn btn-primary">Go to Home</a>
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
