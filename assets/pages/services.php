<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'db_connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <base href="https://localhost/UFA/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFA Holidays - Services</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Navigation bar -->
    <?php 
    $current_page = basename($_SERVER['PHP_SELF']);
    include 'navbar.php'; ?>

    <!-- Main content -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Our Services</h1>
        <div class="row">

            <?php
            // Fetch services from the database
            $sql = "SELECT * FROM services";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-lg-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="'.$row['image'].'" class="card-img-top" alt="'.$row['service_name'].'">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">'.$row['service_name'].'</h5>';
                    echo '<p class="card-text">'.$row['description'].'</p>';
                    
                    // Set link destination and button text based on service type
                    $link_destination = '';
                    $button_text = '';
                    switch($row['service_name']) {
                        case 'Hotel Booking':
                            $link_destination = 'assets/pages/booking.php';
                            $button_text = 'Book Hotel';
                            break;
                        case 'Tour Packages':
                            $link_destination = 'assets/pages/tours.php';
                            $button_text = 'Explore Tours';
                            break;
                        case 'Souvenir Shopping':
                            $link_destination = 'assets/pages/souvenir.php';
                            $button_text = 'Shop Souvenirs';
                            break;
                        default:
                            $link_destination = '#'; // Default to '#' for unknown types
                            $button_text = 'Book Now';
                            break;
                    }

                    echo '<a href="'.$link_destination.'" class="btn btn-primary">'.$button_text.'</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No services available";
            }
            $conn->close();
            ?>

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
