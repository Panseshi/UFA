<?php
// Include your database connection file here
include 'db_connect.php';

// Check if the user is logged in and has admin privileges
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
    // Redirect to login page or unauthorized access page
    header("Location: login.php");
    exit();
}

// Check if user ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: manage_users.php"); // Redirect if ID is not provided
    exit();
}

// Get the user ID from the URL
$user_id = $_GET['id'];

// Fetch user data based on the user ID
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Redirect if user not found
    header("Location: manage_users.php");
    exit();
}

// Handle user deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $delete_sql = "DELETE FROM users WHERE user_id = $user_id";
    if (mysqli_query($conn, $delete_sql)) {
        // Redirect to manage_users.php after successful deletion
        header("Location: manage_users.php");
        exit();
    } else {
        // Handle deletion failure
        $delete_error = "Error deleting user: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Delete User</h1>
        <p>Are you sure you want to delete the user <?php echo $user['user_first_name'] . ' ' . $user['user_last_name']; ?>?</p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $user_id); ?>">
            <input type="submit" name="delete" value="Delete">
            <a href="manage_users.php">Cancel</a>
        </form>
        <?php
        if (isset($delete_error)) {
            echo "<p class='error'>$delete_error</p>";
        }
        ?>
    </div>
</body>
</html>
