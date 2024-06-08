<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
    header("Location: login.php");
    exit();
}

include_once "db_connect.php";

// Fetch all hotels from the database using prepared statement
$query = "SELECT hotel_id, hotel_name FROM hotels";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    // No hotels found, redirect or show error message
    echo "No hotels found!";
    exit();
}

$hotels = $result->fetch_all(MYSQLI_ASSOC);

// Check if form is submitted for updating hotel or adding new hotel
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_hotel'])) {
        // Validate and sanitize inputs
        $hotel_id = $_POST['hotel_id'];
        $hotel_name = htmlspecialchars($_POST['hotel_name']);
        $hotel_location = htmlspecialchars($_POST['hotel_location']);
        $hotel_description = htmlspecialchars($_POST['hotel_description']);
        // Validate other inputs...

        // Update hotel using prepared statement
        $update_query = "UPDATE hotels SET hotel_name=?, hotel_location=?, hotel_description=? WHERE hotel_id=?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("sssi", $hotel_name, $hotel_location, $hotel_description, $hotel_id);
        if ($update_stmt->execute()) {
            // Redirect after successful update
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "Error updating hotel: " . $conn->error;
        }
    } elseif (isset($_POST['add_hotel'])) {
        // Validate and sanitize inputs for new hotel
        $new_hotel_name = htmlspecialchars($_POST['new_hotel_name']);
        $new_hotel_location = htmlspecialchars($_POST['new_hotel_location']);
        $new_hotel_description = htmlspecialchars($_POST['new_hotel_description']);
        // Validate other inputs...

        // Insert new hotel using prepared statement
        $insert_query = "INSERT INTO hotels (hotel_name, hotel_location, hotel_description) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("sss", $new_hotel_name, $new_hotel_location, $new_hotel_description);
        if ($insert_stmt->execute()) {
            // Redirect after successful insert
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "Error adding new hotel: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UFA Holidays - Edit Hotel</title>
<base href="http://localhost/UFA/">
<link rel="stylesheet" href="../css/styles.css">
<link rel="stylesheet" href="../css/admin_dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    /* Custom styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }
    .container {
        margin-top: 50px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .btn {
        margin-right: 10px;
    }
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    .card-header {
        background-color: #007bff;
        color: #fff;
        border-radius: 10px 10px 0 0;
    }
    .card-body {
        padding: 20px;
    }
</style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Add new hotel -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark">
                        Add New Hotel
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <input type="text" name="new_hotel_name" placeholder="Hotel Name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="new_hotel_location" placeholder="Hotel Location" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <textarea name="new_hotel_description" placeholder="Hotel Description" class="form-control" required></textarea>
                            </div>
                            <button type="submit" name="add_hotel" class="btn btn-success">Add Hotel</button>
                            <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Update hotels -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark">
                        Update Hotels
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="hotel_id">Select Hotel to Update:</label>
                                <select name="hotel_id" id="hotel_id" class="form-control" required>
                                    <?php foreach ($hotels as $hotel): ?>
                                        <option value="<?php echo $hotel['hotel_id']; ?>"><?php echo $hotel['hotel_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="hotel_name" placeholder="New Hotel Name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="hotel_location" placeholder="New Hotel Location" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <textarea name="hotel_description" placeholder="New Hotel Description" class="form-control" required></textarea>
                            </div>
                            <button type="submit" name="update_hotel" class="btn btn-primary">Update Hotel</button>
                            <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Back Button -->
         <div class="row mt-4">
            <div class="col-md-12">
                <a href="assets/pages/manage_hotels.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Manage Hotel</a>
            </div>
        </div>

    <!-- Bootstrap and other scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
