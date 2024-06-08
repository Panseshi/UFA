<?php
session_start();

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
    header("Location: login.php");
    exit();
}

include 'db_connect.php'; // Make sure this file contains your database connection logic

// Handle soft delete
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hotel_id'])) {
    $hotel_id = $_POST['hotel_id'];

    // Update the hotel to mark it as deleted
    $query = "UPDATE hotels SET deleted = 1 WHERE hotel_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $hotel_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Hotel has been successfully deleted.";
    } else {
        $_SESSION['error'] = "There was an error deleting the hotel. Please try again.";
    }

    header("Location: delete_hotel.php");
    exit();
}

// Fetch all hotels (including those marked as deleted)
$query = "SELECT * FROM hotels";
$result = $conn->query($query);

// Check for query errors
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Hotel</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/admin_dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'admin_navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Delete Hotel</h1>
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
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['hotel_id'] . '</td>';
                            echo '<td>' . $row['hotel_name'] . '</td>';
                            echo '<td>' . $row['hotel_location'] . '</td>';
                            echo '<td>';
                            echo '<form method="POST" action="delete_hotel.php" style="display:inline;">';
                            echo '<input type="hidden" name="hotel_id" value="' . $row['hotel_id'] . '">';
                            echo '<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <a href="assets/pages/admin_dashboard.php" class="btn btn-secondary">Go Back</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
