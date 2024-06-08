<?php
session_start();

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
    header("Location: login.php");
    exit();
}

include 'db_connect.php'; // Make sure this file contains your database connection logic

// Initialize variables for form data
$hotelName = $hotelLocation = $hotelDescription = $hotelRooms = $hotelProfile = $hotelAmenities = $hotelContactInfo = $hotelRank = $hotelImage = $hotelDistance = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hotelName = $_POST['hotel_name'];
    $hotelLocation = $_POST['hotel_location'];
    $hotelDescription = $_POST['hotel_description'];
    $hotelRooms = $_POST['hotel_rooms'];
    $hotelProfile = $_POST['hotel_profile'];
    $hotelAmenities = $_POST['hotel_amenities'];
    $hotelContactInfo = $_POST['hotel_contact_info'];
    $hotelRank = $_POST['hotel_rank'];
    $hotelImage = $_POST['hotel_image'];
    $hotelDistance = $_POST['hotel_distance'];

    // Validate and sanitize input data
    // (You can add your validation logic here)

    // Insert hotel data into database
    $query = "INSERT INTO hotels (hotel_name, hotel_location, hotel_description, hotel_rooms, hotel_profile, hotel_amenities, hotel_contact_info, hotel_rank, hotel_image, hotel_distance) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssissssis", $hotelName, $hotelLocation, $hotelDescription, $hotelRooms, $hotelProfile, $hotelAmenities, $hotelContactInfo, $hotelRank, $hotelImage, $hotelDistance);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Hotel has been added successfully.";
    } else {
        $_SESSION['error'] = "Error adding hotel. Please try again.";
    }

    header("Location: add_hotel.php"); // Redirect to the same page to clear form after submission
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hotel</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/admin_dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'admin_navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Add Hotel</h1>
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>
        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="hotel_name">Hotel Name:</label>
                        <input type="text" class="form-control" id="hotel_name" name="hotel_name" required>
                    </div>
                    <div class="form-group">
                        <label for="hotel_location">Location:</label>
                        <input type="text" class="form-control" id="hotel_location" name="hotel_location" required>
                    </div>
                    <div class="form-group">
                        <label for="hotel_description">Description:</label>
                        <textarea class="form-control" id="hotel_description" name="hotel_description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="hotel_rooms">Rooms:</label>
                        <input type="number" class="form-control" id="hotel_rooms" name="hotel_rooms" required>
                    </div>
                    <div class="form-group">
                        <label for="hotel_profile">Profile:</label>
                        <textarea class="form-control" id="hotel_profile" name="hotel_profile" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="hotel_amenities">Amenities:</label>
                        <textarea class="form-control" id="hotel_amenities" name="hotel_amenities" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="hotel_contact_info">Contact Info:</label>
                        <div class="form-group">
                        <input type="text" class="form-control" id="hotel_contact_info" name="hotel_contact_info" required>
                    </div>
                    <div class="form-group">
                        <label for="hotel_rank">Rank:</label>
                        <input type="number" class="form-control" id="hotel_rank" name="hotel_rank" required>
                    </div>
                    <div class="form-group">
                        <label for="hotel_image">Image:</label>
                        <input type="text" class="form-control" id="hotel_image" name="hotel_image" required>
                    </div>
                    <div class="form-group">
                        <label for="hotel_distance">Distance:</label>
                        <input type="number" class="form-control" id="hotel_distance" name="hotel_distance" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Hotel</button>
                    <a href="assets/pages/admin_dashboard.php" class="btn btn-secondary">Go Back</a>    
                </form>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    </body>
</html>