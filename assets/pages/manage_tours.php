<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once "db_connect.php";

// Fetch all tours and tour types from the database
$tours_query = "SELECT * FROM tours";
$tours_result = mysqli_query($conn, $tours_query);

$tours = [];
if ($tours_result && mysqli_num_rows($tours_result) > 0) {
    $tours = mysqli_fetch_all($tours_result, MYSQLI_ASSOC);
}

$types_query = "SELECT * FROM tour_types";
$types_result = mysqli_query($conn, $types_query);

$types = [];
if ($types_result && mysqli_num_rows($types_result) > 0) {
    $types = mysqli_fetch_all($types_result, MYSQLI_ASSOC);
}

// Handle form submissions for tours
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_tour'])) {
        $tour_name = $_POST['tour_name'];
        $tour_description = $_POST['tour_description'];
        $tour_price = $_POST['tour_price'];
        $tour_duration = $_POST['tour_duration'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        // Insert new tour into the database
        $insert_tour_query = "INSERT INTO tours (tour_name, tour_description, price, duration, start_date, end_date) VALUES ('$tour_name', '$tour_description', $tour_price, $tour_duration, '$start_date', '$end_date')";
        mysqli_query($conn, $insert_tour_query);

        // Redirect to refresh the page after adding the tour
        header("Location: manage_tours.php");
        exit();
    } elseif (isset($_POST['update_tour'])) {
        // Handle tour update if needed
    } elseif (isset($_POST['delete_tour'])) {
        // Handle tour deletion if needed
    }

    // Handle form submissions for tour types
    if (isset($_POST['add_type'])) {
        $type_name = $_POST['type_name'];
        $base_price = $_POST['base_price'];
        $type_duration = $_POST['type_duration'];
        $type_image = $_POST['type_image'];

        // Insert new tour type into the database
        $insert_type_query = "INSERT INTO tour_types (type_name, base_price, type_duration, type_image) VALUES ('$type_name', $base_price, $type_duration, '$type_image')";
        mysqli_query($conn, $insert_type_query);

        // Redirect to refresh the page after adding the tour type
        header("Location: manage_tours.php");
        exit();
    } elseif (isset($_POST['update_type'])) {
        // Handle tour type update if needed
    } elseif (isset($_POST['delete_type'])) {
        // Handle tour type deletion if needed
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Tours</title>
<base href="https://localhost/UFA/">
<link rel="stylesheet" href="../css/styles.css">
<link rel="stylesheet" href="../css/admin_dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'admin_navbar.php'; ?>
        
    <!-- Back Button -->
    <div class="row mt-4">
            <div class="col-md-12">
                <a href="assets/pages/admin_dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>

    <div class="container mt-5">
        <h2>Manage Tours</h2>
        <!-- Tours Table -->
        <h3>Tours</h3>
        <table class="table">
            <!-- Table headers -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table rows for tours -->
                <?php foreach ($tours as $tour): ?>
                    <tr>
                        <td><?php echo $tour['tour_id']; ?></td>
                        <td><?php echo $tour['tour_name']; ?></td>
                        <td><?php echo $tour['tour_description']; ?></td>
                        <td>$<?php echo $tour['price']; ?></td>
                        <td><?php echo $tour['duration']; ?> hours</td>
                        <td><?php echo $tour['start_date']; ?></td>
                        <td><?php echo $tour['end_date']; ?></td>
                        <td>
                            <!-- Form for deleting tour -->
                            <form action="" method="POST">
                                <input type="hidden" name="tour_id" value="<?php echo $tour['tour_id']; ?>">
                                <button type="submit" name="delete_tour" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add Tour Form -->
        <h3>Add New Tour</h3>
        <form action="" method="POST">
            <!-- Form fields for adding a tour -->
            <!-- Input fields for tour details -->
            <button type="submit" name="add_tour" class="btn btn-primary">Add Tour</button>
        </form>

        <!-- Tour Types Table -->
        <h3>Tour Types</h3>
        <table class="table">
            <!-- Table headers for tour types -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Base Price</th>
                    <th>Duration</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table rows for tour types -->
                <?php foreach ($types as $type): ?>
                    <tr>
                        <td><?php echo $type['type_id']; ?></td>
                        <td><?php echo $type['type_name']; ?></td>
                        <td>$<?php echo $type['base_price']; ?></td>
                        <td><?php echo $type['type_duration']; ?> hours</td>
                        <td><img src="<?php echo $type['type_image']; ?>" alt="Type Image" style="width: 100px;"></td>
                        <td>
                            <!-- Form for deleting tour type -->
                            <form action="" method="POST">
                                <input type="hidden" name="type_id" value="<?php echo $type['type_id']; ?>">
                                <button type="submit" name="delete_type" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Add Tour Type Form -->
        <form action="" method="POST">
            <!-- Form fields for adding a tour type -->
            <div class="form-group">
                <label for="type_name">Type Name:</label>
                <input type="text" name="type_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="base_price">Base Price:</label>
                <input type="number" name="base_price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="type_duration">Duration (hours):</label>
                <input type="number" name="type_duration" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="type_image">Type Image (URL):</label>
                <input type="text" name="type_image" class="form-control" required>
            </div>
            <button type="submit" name="add_type" class="btn btn-primary">Add Tour Type</button>
        </form>
        </div>
    </div>

        <?php include 'footer.php'; ?>
    <!-- Bootstrap and other scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
