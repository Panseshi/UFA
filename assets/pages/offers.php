<!DOCTYPE html>
<html lang="en">
<head>
    <base href="https://localhost/UFA/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFA Holidays - Offers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/offers.css">
</head>
<body>
    <!-- Navigation bar -->
    <?php 
    include 'navbar.php'; 
    include 'db_connect.php'; // Include your database connection file

    // Array of hotel rank to display
    $hotel_rank = [4, 5, 6];

    // Fetch hotels with the specified ranks and that are not deleted
    $sql = "SELECT * FROM hotels WHERE hotel_rank IN (" . implode(',', $hotel_rank) . ") AND deleted = 0";
    $result = $conn->query($sql);

    // Check if there are any hotels with the specified ranks
    if ($result->num_rows > 0) {
        echo '<div class="container mt-5">';
        echo '<h1 class="text-center mb-4">Special Offers</h1>';
        echo '<div class="row">';
        // Output hotel cards for each hotel
        while($row = $result->fetch_assoc()) {
            echo '<div class="col-lg-4 mb-4">';
            echo '<div class="card">';
            echo '<img src="' . $row['hotel_image'] . '" class="card-img-top" alt="' . $row['hotel_name'] . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $row['hotel_name'] . '</h5>';
            echo '<p class="card-text">' . $row['hotel_description'] . '</p>';
            echo '</div>'; // Close card-body div
            echo '<div class="card-footer">';
            echo '<a href="hotel_details.php?hotel_id=' . $row['hotel_id'] . '" class="btn btn-primary">View Details</a>';
            echo '</div>'; // Close card-footer div
            echo '</div>'; // Close card div
            echo '</div>'; // Close col div
        }
        echo '</div>'; // Close row div
        echo '</div>'; // Close container div
    } else {
        echo '<p class="text-center">No hotels found.</p>';
    }
    ?>

    <script>
        $(document).ready(function() {
            // Get the height of the tallest card
            var maxHeight = 0;
            $('.card').each(function() {
                var currentHeight = $(this).outerHeight();
                if (currentHeight > maxHeight) {
                    maxHeight = currentHeight;
                }
            });

            // Set the height of all cards to match the tallest card
            $('.card').outerHeight(maxHeight);
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include the footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
