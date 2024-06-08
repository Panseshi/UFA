<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
include 'db_connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <base href="https://localhost/UFA/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFA Holidays - Souvenir Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Include the navbar -->
    <?php 
    $current_page = basename($_SERVER['PHP_SELF']);
    include 'navbar.php'; ?>

    <!-- Main content -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Souvenir Shop</h1>
        <div class="row">
            <!-- Souvenir cards -->
            <?php
            // Fetch souvenir items from the database
            $sql = "SELECT * FROM souvenirs";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-lg-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="' . $row['sounvenir_image'] . '" class="card-img-top" alt="' . $row['sounvenir_name'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['sounvenir_name'] . '</h5>';
                    echo '<p class="card-text">' . $row['souvenir_description'] . '</p>';
                    echo '<p class="card-text">Price: $' . $row['souvenir_price'] . '</p>';
                    echo '<p class="card-text">Quantity Available: ' . $row['stock_quantity'] . '</p>'; // Show quantity available
                    // Form for purchasing the souvenir
                    echo '<form action="assets/pages/purchase.php" method="post">';
                    echo '<input type="hidden" name="souvenir_id" value="' . $row['souvenir_id'] . '">';
                    echo '<input type="hidden" name="souvenir_price" value="' . $row['souvenir_price'] . '">';
                    echo '<label for="quantity">Quantity:</label>';
                    echo '<select id="quantity" name="purchase_quantity">';
                    for ($i = 1; $i <= min(10, $row['stock_quantity']); $i++) { // Limit to available stock or 10, whichever is lower
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    echo '</select>';
                    echo '<input type="submit" name="purchase_submit" value="Purchase" class="btn btn-primary">';
                    echo '</form>';
                    echo '</div></div></div>';
                }
            } else {
                echo "No items found.";
            }
            ?>
            <!-- End of Souvenir cards -->
        </div>
    </div>
    <!-- Include the footer -->
    <?php include 'footer.php'; ?>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
