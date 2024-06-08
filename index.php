<?php
// Database connection file
include 'assets/pages/db_connect.php';

// Creates tables if not exist
include 'assets/pages/db_setup.php';

// Fetch top 3 ranked hotels for carousel
$sql = "SELECT hotel_name, hotel_image, hotel_profile FROM hotels ORDER BY hotel_rank LIMIT 3";
$result = $conn->query($sql);

$hotels = []; // Renamed from $hotel to $hotels for clarity

if ($result === false) {
    // Handle query execution error
    echo "Error executing the query: " . $conn->error;
} else {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $hotels[] = $row;
        }
    } else {
        // echo "0 results";
    }
}

// Close the connection after all queries
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <base href="https://localhost/UFA/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFA Holidays</title>
    <link rel="stylesheet" href="assets/css/hero.css">
    <link rel="stylesheet" href="assets/css/carousel.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php 
    $current_page = basename($_SERVER['PHP_SELF']);
    include 'assets/pages/navbar.php'; ?>
<div class="div container-main">
    <main>
        <!-- HERO AREA -->
        <div class="hero-image">
            <div class="hero-text">
                <h1>Where Dreams Take Flight</h1>
                <p>Explore our exclusive offers and book your perfect trip today!</p>
                <form class="nav-book-container bg-transparent" action="assets/pages/search.php" method="GET">
                <a class="btn btn-primary nav-btn nav-btn-book-now" href="assets/pages/booking.php">Book Now</a>
                </form>
            </div>
        </div>
        <!-- CAROUSEL SECTION -->
        <section id="featured-carousel" class="shadow bg-light rounded mb-5 mt-5 shadow-none">
            <div class="container">
                <h2 class="text-center text-dark">Featured Hotels</h2>
                <div id="hotelCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $isActive = true;
                        foreach ($hotels as $hotel) {
                            echo '<div class="carousel-item ' . ($isActive ? 'active' : '') . '">';
                            echo '<img src="' . htmlspecialchars($hotel['hotel_image']) . '" class="d-block w-100" alt="' . htmlspecialchars($hotel['hotel_name']) . '">';
                            echo '<div class="carousel-caption">';
                            echo '<h5>' . htmlspecialchars($hotel['hotel_name']) . '</h5>';
                            echo '<p>' . htmlspecialchars($hotel['hotel_profile']) . '</p>';
                            echo '</div></div>';
                            $isActive = false;
                        }
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#hotelCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#hotelCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </section>
    </main>
</div>
    <!-- JS to show modal -->
    <!-- <script>
        $(document).ready(function () {
            $('#searchForm').submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);

                fetch('search_process.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.text())
                .then(data => {
                    $('#modalBody').html(data);
                    $('#hotelModal').modal('show');
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script> -->

    <?php include 'assets/pages/footer.php'; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
